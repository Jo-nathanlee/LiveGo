<?php

namespace App\Http\Middleware;
use App\Entities\Page;
use Illuminate\Support\Facades\Auth;
use Closure;

class SellerGate
{
     /**
     * 執行請求過濾器。
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }
    public function handle($request, Closure $next)
    {
        $user =  Auth::user();
        $ifSeller=Page::where('as_id', $user->fb_id)->count();
        if($ifSeller>0)
        {
            return $next($request);
        }
        
        return redirect('/');
        

        
    }
}
