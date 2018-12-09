<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use DB;
use App\Entities\Page;
use App\Entities\Member;
use App\Entities\OrderDetail;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class MembershipController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;

            $query = Member::where('page_id','=', $page_id)
            ->get();

            return view('member', ['member' => $query]);
        }
        else
        {
           return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
        }
    }

    public function detail(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $fb_id = json_decode($request->input('fb_id'));
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;

            $member = Member::where('page_id','=', $page_id)
            ->where('fb_id', '=', $fb_id)
            ->first();

            $order = DB::table('order_detail')
            ->where('page_id', '=', $page_id)
            ->where('buyer_fbid', '=', $fb_id)
            ->join('status', 'order_detail.status', '=', 'status.status_eng')
            ->select('order_detail.*', 'status.status_cht')
            ->get();





            return view('member_detail', ['member' => $member,'order' => $order]);

         }
         else
         {
            return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
         }
    }
}