<?php

namespace App\Http\Controllers;

use App\Entities\StreamingOrder;
use App\Entities\ShopOrder;
use App\Entities\Member;
use App\Entities\PageDetail;
use App\Entities\ShipSet;
use App\Entities\Page;
use App\User;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class BuyerIndexController extends Controller
{
    //買家購物車
    public function show(Request $request)
    {
        if($request->has('page_id')) //url上，"page_id="是null
        {
            $page_id = $request->input('page_id');
            $fb_id = Auth::user()->fb_id;
            $name = Auth::user()->name;

            if($request->has('uid'))
            {
                $psid = $request->input('uid');
                $Member = Member::where('as_id', '=', $fb_id)->where('fb_id', '=', $psid)->first();
                if($Member==null)
                {
                    Member::where('fb_id', '=', $psid)->update(['as_id' => $auth_user->id]);
                    StreamingOrder::where('fb_id', '=', $psid)->update(['fb_id' => $auth_user->id]);
                }
            }

            //直播商品
            $query = StreamingOrder::join('streaming_product','streaming_order.product_id','=','streaming_product.product_id')
                    ->where('if_valid', '=', 'Y')
                    ->whereNull('order_id')
                    ->where('streaming_order.page_id', '=', $page_id)
                    ->where('streaming_order.fb_id', '=', $fb_id)
                    ->select('streaming_order.id','streaming_order.page_id','streaming_order.fb_id','streaming_order.product_id','goods_name','streaming_order.goods_num','single_price','uid','pic_url','category')
                    ->get();

            //商城商品
            $query2 = ShopOrder::join('shop_product','shop_order.product_id','=','shop_product.product_id')
                    ->whereNull('order_id')
                    ->where('shop_order.page_id', '=', $page_id)
                    ->where('shop_order.fb_id', '=', $fb_id)
                    ->select('shop_order.id','shop_order.page_id','shop_order.fb_id','shop_order.product_id','goods_name','shop_order.goods_num','total_price','uid','pic_url','category')
                    ->get();

            //粉絲頁名稱
            $page = Page::where('page_id','=',$page_id)
                        ->first();

            $companyInfo = PageDetail::where('page_id','=',$page_id)
            ->first();

            $free_shipping = $companyInfo->free_shipping;

            $shipping = ShipSet::join('ship_cht','ship_set.ship_id','=','ship_cht.ship_id')
                            ->where('page_id','=',$page_id)
                            ->where('is_active','=','true')
                            ->select('ship_price','is_active')
                            ->first();

            

            $request->session()->put('page_id', $page_id);


            return view('buyer_index', ['shpping_cart_mall' => $query2 , 'shopping_cart_streamming' => $query, 'page_name' => $page->page_name, 'free_shipping' =>  $free_shipping , 'page_id' => $page_id,'shipping_fee' =>  $shipping->ship_price, 'fbname' => $name]);

        }
        else
        {
            return redirect('/buyer_home');
        }
    }

    //刪除購物車內加購商品
    public function DeleteShoppingCart(Request $request)
    {
        //mall購物車流水號
        $shopOrder_id = $request->input('shopOrder_id');
        $fb_id = Auth::user()->fb_id;


        ShopOrder::where('fb_id', '=', $fb_id)
                ->where('id', '=', $shopOrder_id)
                ->delete();

        return json_encode('true');


    }

    //買家能看到的粉絲團頁面 //finish 20190820
    public function home_show(Request $request)
    {
        $query = DB::table('page_detail')
        ->join('page', 'page_detail.page_id', '=', 'page.page_id')
        ->select('page_detail.page_id', 'page.page_name')
        ->distinct()->get();

        $page_id = $request->input('page_id');

        return view('buyer_home', ['query' => $query,'page_id' => $page_id]);
    }


}
