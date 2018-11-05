<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function HomePageShow()
    {
        return view('official_website');
    }
}