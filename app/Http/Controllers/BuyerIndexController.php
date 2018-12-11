<?php

namespace App\Http\Controllers;

use App\Entities\StreamingOrder;
use App\Entities\ShopOrder;
use App\Entities\PageDetail;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class BuyerIndexController extends Controller
{
    //買家購物車
    public function show(Request $request)
    {
        if($request->has('page_id')){
            $page_id = $request->input('page_id');
            $fb_id=Auth::user()->fb_id;
            
            $query = StreamingOrder::where('fb_id', '=', $fb_id)
                    ->whereNull('if_valid', '=', 'Y')
                    ->whereNull('order_id')
                    ->where('page_id', '=', $page_id)
                    ->select('page_id','page_name','fb_id','name','goods_name','goods_price','goods_num','total_price','uid','pic_path')
                    ->get();
                    
    
            $query2 = ShopOrder::where('fb_id', '=', $fb_id) 
                    ->whereNull('order_id')
                    ->where('page_id', '=', $page_id)
                    ->select('page_id','page_name','fb_id','name','goods_name','goods_price','goods_num','total_price','uid','pic_path')
                    ->get();
    
            $cart=$query->union($query2);
          
    
            $companyInfo = PageDetail::where('page_id','=',$page_id)
            ->first();
            
    
            $request->session()->put('page_id', $page_id);
    
    
            return view('buyer_index', ['shopping_cart' => $cart,'address' => $companyInfo->company_address,'phone' => $companyInfo->company_phone,'page_id' => $page_id]);
        }
    }
}