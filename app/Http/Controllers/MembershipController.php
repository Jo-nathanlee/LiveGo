<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use DB;
use App\Entities\Page;
use App\Entities\OrderDetail;
use App\Entities\StreamingOrder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderExport_member;


class MembershipController extends Controller
{

    public function MemberDetail(Request $request){
        $page = Page::where('as_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;
        
        $ps_id = Auth::user()->ps_id;
        $name = Auth::user()->name;
        $token =  $page->page_token;

        $member_id = $request->input('ps_id');
        $member = DB::table('member')
        ->where('ps_id',$member_id)
        ->where('page_id',$page_id)
        ->join('member_type','member.member_type','member_type.member_type')
        ->first();

        $order = DB::table('order_detail')
        ->where('ps_id',$member_id)
        ->where('page_id',$page_id)
        ->join('orderstatus_cht','order_detail.status','orderstatus_cht.orderstatus_id')
        ->get();

        return view('member_detail',['page_token'=>$token , 'fb_id' =>  $ps_id , 'name' =>$name, 'page_id' =>  $page_id,
         'member' => $member,'order' => $order ]);

    }

    public function MemberIndex(Request $request){
        $page = Page::where('as_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;
        $ps_id = Auth::user()->ps_id;
        $name = Auth::user()->name;
        $token =  $page->page_token;

        $query = DB::table('member')->where('page_id',$page_id)->whereNotNull('ps_id')->get();

        return view('member',['page_token'=>$token , 'fb_id' =>  $ps_id , 'name' =>$name, 'page_id' =>  $page_id ,'member' => $query]);

    }
    public function MemberExcel(Request $request){
        $page = Page::where('as_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;
        $page_name = $page->page_name;
        $query = DB::table('member')
        ->where('page_id',$page_id)
        ->join('member_type','member.member_type','member_type.member_type')
        ->get();

        $file_name = $page_name."會員名單";

        $new_excel = new OrderExport_member($query);

        return Excel::download($new_excel , $file_name.".xlsx");
    }

    public function BlackMember(Request $request){
        $ps_id = $request->input('psid');
        $if_checked = $request->input('is_active');

        if($if_checked == 'true')
        {
            $update = DB::table('member')
            ->where('ps_id',$ps_id)
            ->update(['member_type' => 0]);
        }
        else
        {
            $member = DB::table('member')
            ->where('ps_id',$ps_id)
            ->first();
            

            if($member->money_spent > 1000000)
            {
                $update = DB::table('member')
                ->where('ps_id',$ps_id)
                ->update(['member_type' => 4]);
            }else if($member->money_spent > 100000 && $member->money_spent < 1000000)
            {
                $update = DB::table('member')
                ->where('ps_id',$ps_id)
                ->update(['member_type' => 3]);
            }else if($member->money_spent > 10000 && $member->money_spent < 100000)
            {
                $update = DB::table('member')
                ->where('ps_id',$ps_id)
                ->update(['member_type' => 2]);            
            }else{
                $update = DB::table('member')
                ->where('ps_id',$ps_id)
                ->update(['member_type' => 1]);       
            }
        }
        return 'true';
    }
}
