<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use App\Entities\Page;
use App\Entities\StreamingOrder;
use App\Entities\StreamingProduct;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class SellerIndexController extends Controller
{
    private $api;
    public function __construct(Facebook $fb)
    {
        
        $this->middleware(function ($request, $next) use ($fb) {
            $fb->setDefaultAccessToken(Auth::user()->token);
            $this->api = $fb;
            return $next($request);
        });

    }

    public function graphapi($query, $token)
    {
        
        $response = $this->api->get($query, $token);
        return $response;
    }
    
    public function show(Request $request)
    {
        $fb_id=Auth::user()->fb_id;
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;
        $page_token = $page->page_token;

        $query = '/' . $page_id . '/insights/page_views_total';
        $response = $this->graphapi($query, $page_token);

        $page_views_total = $response->getGraphEdge()->asArray();
        //$views_total=$page_views_total[0][0]['values'][0]['value'];

        



        return view('seller_index', ['page_info' => '']);
    }
}