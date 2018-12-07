<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use App\Entities\Page;
use App\Entities\StreamingOrder;
use App\Entities\Member;
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
                    ->select('name','goods_name','pic_path','goods_price','goods_num','total_price','comment','created_time','note')
                    ->get();

            return view('bid_winner', ['winner' => $query]);
        }
        else
        {
            return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
        }
    }

    //黑名單
    public function Blacklist(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;

            $query = Member::where('page_id', '=', $page_id)
            ->where('blacklist_times', '>', 0)
            

            return view('blacklist');
        }
        else
        {
            return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
        }
    }

    //判斷黑名單
    public function Blacklist_check(Request $request)
    {
        $time_now = date("Y-m-d H:i:s");
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;
        StreamingOrder::where('page_id', '=', $page_id)
        ->whereNull('order_id')
        ->where('deadline', '<',$time_now)
        ->update(['if_valid' => 'N']);

        $query = StreamingOrder::where('page_id', '=', $page_id)
        ->whereNull('order_id')
        ->where('deadline', '<',$time_now)
        ->get();

        foreach($query as $blacklist)
        {
            Member::where('fb_id','=',$blacklist->fb_id)
            ->increment('blacklist_times');
        }

        
    }

    
    
}