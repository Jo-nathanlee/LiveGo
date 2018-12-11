<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Entities\Page;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $auth_user = Socialite::driver('facebook')->stateless()->user();
            $query = Page::where('fb_id', '=', $auth_user->id)->count();

            $if_buyer = true;
            if ($query > 0) {
                $if_buyer = false;
            }

            if ($if_buyer) {
                //return redirect()->route('buyer_index');
            } else {
               return redirect()->route('seller_index');
            }
        }

        return $next($request);
    }
}
