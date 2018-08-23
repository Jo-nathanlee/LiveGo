<?php

namespace App\Http\Controllers;

use App\Entities\Page;
use App\Entities\StreamingOrder;
use App\Entities\ShopOrder;
use App\Entities\CheckoutOrder;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntitiesController extends Controller
{
    public function CreateOrUpdatePage(Request $request)
    {
        $page = $request->input('id');
        $id_name_token = preg_split("/[,]+/", $page);
        $page_id = $id_name_token[0];
        $request->session()->put('page_id', $page_id);
        $page_name = $id_name_token[1];
        $page_token = $id_name_token[2];
        $page_pic = $id_name_token[3];
        $page_store = Page::updateOrCreate(
            ['fb_id' => Auth::user()->fb_id],
            [
                'name' => Auth::user()->name,
                'page_id' => $page_id,
                'page_name' => $page_name,
                'page_pic' => $page_pic,
                'page_token' => $page_token,
            ]
        );
        return redirect('/home');
    }
    //買家購物車
    public function BuyerIndexShow(Request $request)
    {
        try
        {
            $fb_id=Auth::user()->fb_id;
            $query = StreamingOrder::where('fb_id', '=', $fb_id)
                    ->whereNull('streaming_order.order_id')
                    ->select('page_name','fb_id','name','goods_name','goods_price','goods_num','total_price')
                    ->get();
                     
    
            $query2 = ShopOrder::where('fb_id', '=', $fb_id) 
                      ->select('page_name','fb_id','name','goods_name','goods_price','goods_num','total_price')
                      ->get();
    
            $cart=$query->union($query2);
            $cart=$cart->groupBy('page_name');

            return view('buyer_index', ['shopping_cart' => $cart]);
        }
        catch(Exception $e)
        {
            return view('buyer_index', ['nothing' => '']);
        }
        
        


        
    }
    //賣家訂單查看
    public function SellerOrderAll(Request $request)//全部訂單
    {
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;
        $query = CheckoutOrder::where('page_id', '=', $page_id)
                ->select('fb_id','name','goods_name','goods_price','goods_num','total_price','order_status')
                ->get();
        $countAllOrder=CheckoutOrder::where('page_id', '=', $page_id)
        ->count();
        $countUnpaidOrder=CheckoutOrder::where('page_id', '=', $page_id)
        ->where('order_status', '=', 'unpaid')
        ->count();
        $countUndeliveredOrder=CheckoutOrder::where('page_id', '=', $page_id)
        ->where('order_status', '=', 'undelivered')
        ->count();   
        $countDeliveredOrder=CheckoutOrder::where('page_id', '=', $page_id)
        ->where('order_status', '=', 'delivered')
        ->count();     
        $countFinishedOrder=CheckoutOrder::where('page_id', '=', $page_id)
        ->where('order_status', '=', 'finished')
        ->count();  
        $countCanceledOrder=CheckoutOrder::where('page_id', '=', $page_id)
        ->where('order_status', '=', 'canceled')
        ->count();          
                      

        return view('seller_order', ['order' => $query,'countAllOrder' => $countAllOrder,'countUnpaidOrder' => $countUnpaidOrder,'countUndeliveredOrder' => $countUndeliveredOrder,'countDeliveredOrder' => $countDeliveredOrder,'countFinishedOrder' => $countFinishedOrder,'countCanceledOrder' => $countCanceledOrder]);
        
    }

    public function SellerOrderUnpaid(Request $request)//未付款訂單
    {
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;
        $query = CheckoutOrder::where('page_id', '=', $page_id)
                ->where()
                ->select('fb_id','name','goods_name','goods_price','goods_num','total_price','order_status')
                ->get();

        return view('seller_order', ['order' => $query]);
        
    }

    public function SellerOrderUndelivered(Request $request)//未出貨訂單
    {
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;
        $query = CheckoutOrder::where('page_id', '=', $page_id)
                ->where()
                ->select('fb_id','name','goods_name','goods_price','goods_num','total_price','order_status')
                ->get();

        return view('seller_order', ['order' => $query]);
        
    }

    public function SellerOrderDelivered(Request $request)//運送中訂單
    {
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;
        $query = CheckoutOrder::where('page_id', '=', $page_id)
                ->where()
                ->select('fb_id','name','goods_name','goods_price','goods_num','total_price','order_status')
                ->get();

        return view('seller_order', ['order' => $query]);
        
    }

    public function SellerOrderFinished(Request $request)//已完成訂單
    {
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;
        $query = CheckoutOrder::where('page_id', '=', $page_id)
                ->where()
                ->select('fb_id','name','goods_name','goods_price','goods_num','total_price','order_status')
                ->get();

        return view('seller_order', ['order' => $query]);
        
    }

    public function SellerOrderCanceled(Request $request)//已取消訂單
    {
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;
        $query = CheckoutOrder::where('page_id', '=', $page_id)
                ->where()
                ->select('fb_id','name','goods_name','goods_price','goods_num','total_price','order_status')
                ->get();

        return view('seller_order', ['order' => $query]);
        
    }

}
