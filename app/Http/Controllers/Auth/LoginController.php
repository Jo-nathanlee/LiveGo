<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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
    protected $redirectTo = '/home';

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
        $query = User::where('fb_id', '=', $auth_user->id)->count();

        $if_firsttime = true;
        if ($query > 0) {
            $if_firsttime = false;
        }
        $user = User::updateOrCreate(
            ['fb_id' => $auth_user->id],
            [
                'token' => $auth_user->token,
                'name' => $auth_user->name,
            ]
        );

        Auth::login($user, true);
        if ($if_firsttime) {
            return redirect()->route('set_page');
        } else {
            return redirect()->route('home');
        }

    }
    public function logout()
    {
        Auth::logout();
        return redirect('/set_page');
    }
}
