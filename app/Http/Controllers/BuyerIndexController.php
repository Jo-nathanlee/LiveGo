<?php

namespace App\Http\Controllers;

use App\Entities\StreamingOrder;
use App\Entities\ShopOrder;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class BuyerIndexController extends Controller
{
    //買家購物車
    public function show(Request $request)
    {
        $fb_id=Auth::user()->fb_id;
        $query = StreamingOrder::where('fb_id', '=', $fb_id)
                ->whereNull('streaming_order.order_id')
                ->select('page_id','page_name','fb_id','name','goods_name','goods_price','goods_num','total_price','uid','pic_path')
                ->get();
                

        $query2 = ShopOrder::where('fb_id', '=', $fb_id) 
                ->select('page_id','page_name','fb_id','name','goods_name','goods_price','goods_num','total_price','uid','pic_path')
                ->get();

        $cart=$query->union($query2);
        $cart=$cart->groupBy('page_name');
        


        return view('buyer_index', ['shopping_cart' => $cart]);
    }
}