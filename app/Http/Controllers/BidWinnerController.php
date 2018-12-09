<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use App\Entities\PageDetail;
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
                    ->select('fb_id','name','goods_name','pic_path','goods_price','goods_num','total_price','comment','created_time','note')
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
            ->get();
            

            return view('blacklist', ['blacklist' => $query]);
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
        //尚未點選結帳之棄標者
        StreamingOrder::where('page_id', '=', $page_id)
        ->whereNull('order_id')
        ->where('deadline', '<',$time_now)
        ->update(['if_valid' => 'N']);

        //結帳但未付款之棄標者
        $order = DB::table('streaming_order')
        ->where('streaming_order.page_id', '=', $page_id)
        ->where('streaming_order.deadline', '<',$time_now)
        ->join('order_detail', DB::raw('BINARY streaming_order.order_id'), '=', DB::raw('BINARY order_detail.order_id'))
        ->where('order_detail.status', '=', 'unpaid')
        ->update(['streaming_order.if_valid' => 'N','order_detail.status' => 'canceled']);




        $query = StreamingOrder::where('page_id', '=', $page_id)
        ->whereNotNull('deadline')
        ->where('if_valid', '=', 'N')
        ->get();



        foreach($query as $blacklist)
        {
            Member::where('fb_id','=',$blacklist->fb_id)
            ->increment('blacklist_times');

            StreamingOrder::where('id','=',$blacklist->id)
            ->update(['deadline' => null]);
        }

        
    }

    
    //棄標時間設定
    public function Blacklist_time(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;

            $blacklist_time = PageDetail::where('page_id', '=', $page_id)
            ->first();

            dd($blacklist_time);

            return view('set_blacklist_time', ['hours' => $blacklist_time]);
        }
        else
        {
            return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
        }
    }

    public function Set_BlacklistTime(Request $request)
    {
        $hours =  $request->input('hours');

        
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;

        DB::table('page_detail')
        ->where('page_id', '=', $page_id)
        ->update(['deadline_time' => $hours]);

        return redirect()->back()->with('alert', '成功!');
    }
    
    
}