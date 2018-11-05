<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use App\Entities\Page;
use App\Entities\StreamingOrder;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class BidWinnerController extends Controller
{
    //賣家得標清單查看
    public function show(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;

            $query = StreamingOrder::where('page_id', '=', $page_id)
                    ->whereNull('streaming_order.order_id')
                    ->select('name','goods_name','goods_price','goods_num','total_price','comment','created_time','note')
                    ->get();

            return view('bid_winner', ['winner' => $query]);
        }
        else
        {
            return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
        }
    }
}