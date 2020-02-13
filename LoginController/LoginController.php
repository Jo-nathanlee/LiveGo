<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\Entities\UpdateUser;
use App\Entities\StreamingProduct;
use DB;
use App\Entities\Page;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Laravel\Socialite\Facades\Socialite;
use URL;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/seller_index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        Session::put('backUrl', URL::previous());
        $this->middleware('guest')->except('logout');        
    }

    public function redirectToFacebookProvider()
    {
       
        return Socialite::driver('facebook')->scopes([
            'manage_pages', 'publish_pages', 'read_page_mailboxes'])->redirect();

    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return void
     */
    public function handleProviderFacebookCallback()
    {
        //登入者資料
        $auth_user = Socialite::driver('facebook')->stateless()->user();
        //$user_name = $auth_user->name;
        //是否為賣家
        $query = Page::where('fb_id', '=', $auth_user->id)->count();
        //user是否已存在
        $if_user_exisit = User::where('fb_id', '=', $auth_user->id)->first();
        
        //所有未註冊者
        // $unregistered_user = DB::table('user')
        //                     ->join('streaming_order', 'user.ps_id', '=', 'streaming_order.fb_id')
        //                     ->join('page', 'streaming_order.page_id', '=', 'page.page_id')
        //                     ->select('user.ps_id', 'user.name', 'user.fb_id', 'user.token')
        //                     ->get();
        $unregistered_user = DB::table('user')->get();
        // $unregistered_user = User::where('fb_id', '=', 'ps_id')
        //                     ->get();

        if (!$if_user_exisit) {
            //user不存在
            try{
                //替換登入者的 ps_id -> fb_id
                foreach ($unregistered_user as $key) {
                    $ps_id = $key->ps_id;
                    $stream_fb_id = $key->fb_id;
                    $token = $key->token;
                    // $default_token = str_random(10);

                    if ($ps_id == $stream_fb_id) {
                        //用ps_id取得真fb_id
                        try {
                            $data = file_get_contents("https://graph.facebook.com/".$stream_fb_id."?fields=ids_for_apps%7Bid%7D&access_token=".$token);
                            $decodingData = json_decode($data, true);
                            $real_user_id=(string)$decodingData["ids_for_apps"]["data"][0]["id"];
                        } catch (\Exception $e) {
                            $real_user_id=$stream_fb_id;
                        }

                        //轉換ID
                        DB::table('user')
                        ->where('ps_id', '=', $ps_id)
                        ->update(['fb_id' => $real_user_id]);

                        DB::table('streaming_order')
                        ->where('fb_id', '=', $ps_id)
                        ->update(['fb_id' => $real_user_id]);
                    }
                }

                //登入並更新資料
                $user = User::updateOrCreate(
                    ['fb_id' => $auth_user->id],
                    [
                        'token' => $auth_user->token,
                        'name' => $auth_user->name,
                    ]
                );
                
                
            }catch (\Exception $e){
                //未得標，登入並更新資料
                $user = User::updateOrCreate(
                    ['fb_id' => $auth_user->id],
                    [
                        'token' => $auth_user->token,
                        'name' => $auth_user->name,
                    ]
                );
            } 
                
                
                
            
        } else {
            //user已存在
            $user = User::updateOrCreate(
                ['fb_id' => $auth_user->id],
                [
                    'token' => $auth_user->token,
                    'name' => $auth_user->name,
                ]
            );
        }

        

        $if_buyer = true;
        if ($query > 0) {
            $if_buyer = false;
        }

        Auth::login($user, true);
        if ($if_buyer) {
            // if(Session::get('backUrl')==null||strpos(Session::get('backUrl'),'logout'))
            // {
            //     return redirect()->route('buyer_home');
            // }
            // else
            // {
            //     return redirect(session('backUrl'));
            // }
            return redirect()->intended('/buyer_home'); 
        } else {
           return redirect()->intended('/set_page');
        }

    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
