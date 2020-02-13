<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use DB;
use App\Entities\OrderDetail;
use App\Entities\Page;
use App\Entities\CheckoutOrder;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerOrderController extends Controller
{
     //賣家訂單查看------------------------------------------------------------------------
     public function BuyerOrderAll(Request $request)//全部訂單
     {
        if(parent::ContainPage_ID($request->input('page_id')))
        {
            $fb_id = Auth::user()->fb_id;

            $page_id=$request->input('page_id');
            $request->session()->put('page_id', $page_id);
    
            $page = Page::where('page_id', '=', $page_id)->first();
            $page_name = $page->page_name;
    
            $query = DB::table('order_detail')
            ->where('order_detail.buyer_fbid', '=', $fb_id)
            ->join('orderstatus_cht', 'order_detail.status', '=', 'orderstatus_cht.orderstatus_id')
            ->join('page','order_detail.page_id', '=', 'page.page_id')
            ->leftJoin('logistics', 'order_detail.other_status', '=', 'logistics.status_code')
            ->select('order_detail.*', 'orderstatus_cht.order_status','page.page_name','logistics.message')
            ->distinct()
            ->orderBy('order_detail.created_at', 'desc')
            ->get();
    
            $countAllOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->count();
            $countUnpaidOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '11')
            ->count();
            $countUndeliveredOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '13')
            ->count();   
            $countDeliveredOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '12')
            ->count();     
            $countFinishedOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '14')
            ->count();  
            $countCanceledOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '15')
            ->count();           
    
            return view('buyer_order', ['statue'=>'','order' => $query,'click' => 'all' ,'countAllOrder' => $countAllOrder,'countUnpaidOrder' => $countUnpaidOrder,'countUndeliveredOrder' => $countUndeliveredOrder,'countDeliveredOrder' => $countDeliveredOrder,'countFinishedOrder' => $countFinishedOrder,'countCanceledOrder' => $countCanceledOrder,'page_id' => $page_id,'page_name' => $page_name]);
        }
        else
        {
            return redirect('/buyer_home');
        }

        

       
     }
     
     public function BuyerOrderUnpaid(Request $request)//未付款訂單
     {
        if(parent::ContainPage_ID($request->input('page_id')))
        {
            $fb_id = Auth::user()->fb_id;
            $page_id=$request->input('page_id');
            $request->session()->put('page_id', $page_id);
    
            $page = Page::where('page_id', '=', $page_id)->first();
            $page_name = $page->page_name;

            $query = OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '11')
            ->join('orderstatus_cht', 'order_detail.status', '=', 'orderstatus_cht.orderstatus_id')
            ->join('page','order_detail.page_id', '=', 'page.page_id')
            ->select('order_detail.*', 'orderstatus_cht.order_status','page.page_name')
            ->distinct()
            ->orderBy('order_detail.created_at', 'desc')
            ->get();

            $countAllOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->count();
            $countUnpaidOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '11')
            ->count();
            $countUndeliveredOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '13')
            ->count();   
            $countDeliveredOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '12')
            ->count();     
            $countFinishedOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '14')
            ->count();  
            $countCanceledOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '15')
            ->count();     
        
            return view('buyer_order', ['statue'=>'未付款','order' => $query,'click' => 'unpaid' ,'countAllOrder' => $countAllOrder,'countUnpaidOrder' => $countUnpaidOrder,'countUndeliveredOrder' => $countUndeliveredOrder,'countDeliveredOrder' => $countDeliveredOrder,'countFinishedOrder' => $countFinishedOrder,'countCanceledOrder' => $countCanceledOrder,'page_id' => $page_id,'page_name' => $page_name]);
        }
        else
        {
            return redirect('/buyer_home');
        }
     }
 
     public function BuyerOrderUndelivered(Request $request)//未出貨訂單
     {
        if(parent::ContainPage_ID($request->input('page_id')))
        {
            $fb_id = Auth::user()->fb_id;
            $page_id=$request->input('page_id');
            $request->session()->put('page_id', $page_id);
    
            $page = Page::where('page_id', '=', $page_id)->first();
            $page_name = $page->page_name;

            $query = OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '13')
            ->join('orderstatus_cht', 'order_detail.status', '=', 'orderstatus_cht.orderstatus_id')
            ->join('page','order_detail.page_id', '=', 'page.page_id')
            ->select('order_detail.*', 'orderstatus_cht.order_status','page.page_name')
            ->distinct()
            ->orderBy('order_detail.created_at', 'desc')
            ->get();
        
                
            $countAllOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->count();
            $countUnpaidOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '11')
            ->count();
            $countUndeliveredOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '13')
            ->count();   
            $countDeliveredOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '12')
            ->count();     
            $countFinishedOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '14')
            ->count();  
            $countCanceledOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '15')
            ->count();     
        
            return view('buyer_order', ['statue'=>'等待出貨','order' => $query,'click' => 'undelivered' ,'countAllOrder' => $countAllOrder,'countUnpaidOrder' => $countUnpaidOrder,'countUndeliveredOrder' => $countUndeliveredOrder,'countDeliveredOrder' => $countDeliveredOrder,'countFinishedOrder' => $countFinishedOrder,'countCanceledOrder' => $countCanceledOrder,'page_id' => $page_id,'page_name' => $page_name]);
        }
        else
        {
            return redirect('/buyer_home');
        }
     }
 
     public function BuyerOrderDelivered(Request $request)//運送中訂單
     {
        if(parent::ContainPage_ID($request->input('page_id')))
        {
            $fb_id = Auth::user()->fb_id;
            $page_id=$request->input('page_id');
            $request->session()->put('page_id', $page_id);
    
            $page = Page::where('page_id', '=', $page_id)->first();
            $page_name = $page->page_name;

            $query = OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '12')
            ->join('orderstatus_cht', 'order_detail.status', '=', 'orderstatus_cht.orderstatus_id')
            ->join('page','order_detail.page_id', '=', 'page.page_id')
            ->select('order_detail.*', 'orderstatus_cht.order_status','page.page_name')
            ->distinct()
            ->orderBy('order_detail.created_at', 'desc')
            ->get();
        
                
            $countAllOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->count();
            $countUnpaidOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '11')
            ->count();
            $countUndeliveredOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '13')
            ->count();   
            $countDeliveredOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '12')
            ->count();     
            $countFinishedOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '14')
            ->count();  
            $countCanceledOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '15')
            ->count();     
        
            return view('buyer_order', ['statue'=>'運送中','order' => $query,'click' => 'delivered' ,'countAllOrder' => $countAllOrder,'countUnpaidOrder' => $countUnpaidOrder,'countUndeliveredOrder' => $countUndeliveredOrder,'countDeliveredOrder' => $countDeliveredOrder,'countFinishedOrder' => $countFinishedOrder,'countCanceledOrder' => $countCanceledOrder,'page_id' => $page_id,'page_name' => $page_name]);
        }
        else
        {
            return redirect('/buyer_home');
        }
     }
 
     public function BuyerOrderFinished(Request $request)//已完成訂單
     {
        if(parent::ContainPage_ID($request->input('page_id')))
        {
            $fb_id = Auth::user()->fb_id;
            $page_id=$request->input('page_id');
            $request->session()->put('page_id', $page_id);
    
            $page = Page::where('page_id', '=', $page_id)->first();
            $page_name = $page->page_name;

            $query = OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '14')
            ->join('orderstatus_cht', 'order_detail.status', '=', 'orderstatus_cht.orderstatus_id')
            ->join('page','order_detail.page_id', '=', 'page.page_id')
            ->select('order_detail.*', 'orderstatus_cht.order_status','page.page_name')
            ->distinct()
            ->orderBy('order_detail.created_at', 'desc')
            ->get();

            $countAllOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->count();
            $countUnpaidOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '11')
            ->count();
            $countUndeliveredOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '13')
            ->count();   
            $countDeliveredOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '12')
            ->count();     
            $countFinishedOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '14')
            ->count();  
            $countCanceledOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '15')
            ->count();     
        
            return view('buyer_order', ['statue'=>'已完成','order' => $query,'click' => 'finished' ,'countAllOrder' => $countAllOrder,'countUnpaidOrder' => $countUnpaidOrder,'countUndeliveredOrder' => $countUndeliveredOrder,'countDeliveredOrder' => $countDeliveredOrder,'countFinishedOrder' => $countFinishedOrder,'countCanceledOrder' => $countCanceledOrder,'page_id' => $page_id,'page_name' => $page_name]);
        }
        else
        {
            return redirect('/buyer_home');
        }
     }
 
     public function BuyerOrderCanceled(Request $request)//已取消訂單
     {
        if(parent::ContainPage_ID($request->input('page_id')))
        {
            $fb_id = Auth::user()->fb_id;
            $page_id=$request->input('page_id');
            $request->session()->put('page_id', $page_id);
    
            $page = Page::where('page_id', '=', $page_id)->first();
            $page_name = $page->page_name;

            $query = OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '15')
            ->join('orderstatus_cht', 'order_detail.status', '=', 'orderstatus_cht.orderstatus_id')
            ->join('page','order_detail.page_id', '=', 'page.page_id')
            ->select('order_detail.*', 'orderstatus_cht.order_status','page.page_name')
            ->distinct()
            ->orderBy('order_detail.created_at', 'desc')
            ->get();
            

            $countAllOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->count();
            $countUnpaidOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '11')
            ->count();
            $countUndeliveredOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '13')
            ->count();   
            $countDeliveredOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '12')
            ->count();     
            $countFinishedOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '14')
            ->count();  
            $countCanceledOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', '15')
            ->count();     
        
            return view('buyer_order', ['statue'=>'已取消','order' => $query,'click' => 'canceled' ,'countAllOrder' => $countAllOrder,'countUnpaidOrder' => $countUnpaidOrder,'countUndeliveredOrder' => $countUndeliveredOrder,'countDeliveredOrder' => $countDeliveredOrder,'countFinishedOrder' => $countFinishedOrder,'countCanceledOrder' => $countCanceledOrder,'page_id' => $page_id,'page_name' => $page_name]);
        }
        else
        {
            return redirect('/buyer_home');
        }
     }

     public function BuyerOrderDetail(Request $request)//訂單詳情
     {

        if(parent::ContainPage_ID($request->input('page_id')))
        {
            $page_id=$request->input('page_id');
            $request->session()->put('page_id', $page_id);
    
            $page = Page::where('page_id', '=', $page_id)->first();
            $page_name = $page->page_name;

            $order_id = $request->input('order_id');
            
            $StreamingProducts = DB::table('streaming_order')
            ->where('order_id', '=', $order_id)
            ->join('streaming_product', 'streaming_order.product_id', '=', 'streaming_product.product_id')
            ->select('streaming_product.*', 'streaming_order.goods_num as order_num','streaming_order.single_price')
            ->get();

            $ShopProducts = DB::table('shop_order')
            ->where('order_id', '=', $order_id)
            ->join('shop_product', 'shop_order.product_id', '=', 'shop_product.product_id')
            ->select('shop_product.*', 'shop_order.goods_num as order_num','shop_order.total_price')
            ->get();

            $query = DB::table('order_detail')
            ->where('order_id', '=', $order_id)
            ->join('orderstatus_cht', 'order_detail.status', '=', 'orderstatus_cht.orderstatus_id')
            ->leftJoin('logistics', 'order_detail.other_status', '=', 'logistics.status_code')
            ->select('order_detail.*', 'orderstatus_cht.order_status','logistics.message')
            ->first();


            return view('buyer_order_detail', ['order_detail' => $query,'StreamingProducts' => $StreamingProducts,'ShopProducts' => $ShopProducts,'page_id' => $page_id,'page_name' => $page_name]);

        }
        else
        {
            return redirect('/buyer_home');
        }
        
     }
     //------------------------------------------------------------------------------------------------------------


}