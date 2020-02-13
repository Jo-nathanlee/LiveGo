<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\Entities\Page;
use App\Entities\Member;
use App\Entities\StreamingOrder;
use App\Entities\ShopOrder;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use URL;
use Session;
use Redirect;

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
        $auth_user = Socialite::driver('facebook')->stateless()->user();
        $user = User::updateOrCreate(
            ['fb_id' => $auth_user->id],
            [
                'token' => $auth_user->token,
                'name' => $auth_user->name,
            ]
        );
        Auth::login($user, true);

        // $query = Page::where('as_id', '=', $auth_user->id)->count();
        // $if_buyer = true;
        // if ($query > 0) {
        //     $if_buyer = false;
        // }

        // $app_token = $this->GetAppToken();
        $url = Session::get('backUrl');

        if(!isset($url)){
            return redirect()->route('buyer_default', ['page_id'=> '321923508505733']);
        }

        // if($app_token!=null){
        //     $psid = $this->asid_to_psid($auth_user->id,$app_token);
        // }


        if(strpos($url,'buyer')!=null){
                $psid = Session::get('uid');
                $page_id = Session::get('page_id');
                if($psid!=null && $page_id!=null)
                {
                    $Member = Member::where('ps_id', '=', $psid)->first();
                    $name = $Member->fb_name;

                    if($name == $auth_user->name)
                    {
                        $update = User::where('fb_id',$auth_user->id)
                        ->update(['ps_id' => $psid,]);
        
                        
                        $Member = Member::where('ps_id', '=', $psid)->first();
        
                        if($Member!=null){
                            if($Member->as_id == null){
                                Member::where('ps_id', '=', $psid)->update(['as_id' => $auth_user->id]);
                            }
                        }
                    }

                    $url = $url.'?page_id='.$page_id.'&uid='.$psid;
                }else{
                    return redirect()->route('buyer_default', ['page_id'=> '321923508505733']);                    
                }
        }
        return redirect($url);
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function GetAppToken(){
        try{
            
            $data = file_get_contents("https://graph.facebook.com/oauth/access_token?client_id=583172745360618&client_secret=d4c6ed25ace6e0d9ea920db16139d395&grant_type=client_credentials");
            $data = json_decode($data, true);
            $data = $data["access_token"];

            return $data;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function psid_to_asid($ps_id,$token){
        try{
            $data = file_get_contents("https://graph.facebook.com/" . $ps_id . "?fields=ids_for_apps%7Bid%7D&access_token=" . $token);
            $data = json_decode($data, true);
            $data = $data["ids_for_apps"]["data"][0]["id"];

            return $data;
        } catch (\Exception $e) {
            return null;
        }      
    }
}
