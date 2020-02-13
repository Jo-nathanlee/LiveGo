<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }
    public function index()
    {
        return view('home');
    }


    public function info()
    {
        return view('info');
    }

   public function notfound()
   {
        return view('404');
   }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

}
