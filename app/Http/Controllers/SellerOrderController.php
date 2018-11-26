<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use App\Entities\Page;
use App\Entities\CheckoutOrder;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class SellerOrderController extends Controller
{
     //賣家訂單查看------------------------------------------------------------------------
     public function SellerOrderAll(Request $request)//全部訂單
     {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            $query = CheckoutOrder::all()
                    ->where('page_id', '=', $page_id)
                    ->groupBy('order_id');
            $countAllOrder=CheckoutOrder::where('page_id', '=', $page_id)
            ->distinct()
            ->count();
            $countUnpaidOrder=CheckoutOrder::where('page_id', '=', $page_id)
            ->where('order_status', '=', 'unpaid')
            ->distinct()
            ->count();
            $countUndeliveredOrder=CheckoutOrder::where('page_id', '=', $page_id)
            ->where('order_status', '=', 'undelivered')
            ->distinct()
            ->count();   
            $countDeliveredOrder=CheckoutOrder::where('page_id', '=', $page_id)
            ->where('order_status', '=', 'delivered')
            ->distinct()
            ->count();     
            $countFinishedOrder=CheckoutOrder::where('page_id', '=', $page_id)
            ->where('order_status', '=', 'finished')
            ->distinct()
            ->count();  
            $countCanceledOrder=CheckoutOrder::where('page_id', '=', $page_id)
            ->where('order_status', '=', 'canceled')
            ->distinct()
            ->count();          
                        
    
            return view('seller_order', ['order' => $query,'countAllOrder' => $countAllOrder,'countUnpaidOrder' => $countUnpaidOrder,'countUndeliveredOrder' => $countUndeliveredOrder,'countDeliveredOrder' => $countDeliveredOrder,'countFinishedOrder' => $countFinishedOrder,'countCanceledOrder' => $countCanceledOrder]);
        }
        else
        {
           return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
        }
     }
 
     public function SellerOrderUnpaid(Request $request)//未付款訂單
     {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            $query = CheckoutOrder::all()
                    ->where('page_id', '=', $page_id)
                    ->where('order_status', '=', 'unpaid');
    
            return view('seller_order', ['order' => $query]);
        }
        else
        {
           return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
        }
     }
 
     public function SellerOrderUndelivered(Request $request)//未出貨訂單
     {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            $query = CheckoutOrder::all()
                    ->where('page_id', '=', $page_id)
                    ->where('order_status', '=', 'undelivered');
    
            return view('seller_order', ['order' => $query]);
        }
        else
        {
           return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
        }
     }
 
     public function SellerOrderDelivered(Request $request)//運送中訂單
     {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            $query = CheckoutOrder::all()
                    ->where('page_id', '=', $page_id)
                    ->where('order_status', '=', 'delivered');
    
            return view('seller_order', ['order' => $query]);
        }
        else
        {
           return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
        }
     }
 
     public function SellerOrderFinished(Request $request)//已完成訂單
     {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            $query = CheckoutOrder::all()
                    ->where('page_id', '=', $page_id)
                    ->where('order_status', '=', 'finished');
    
            return view('seller_order', ['order' => $query]);
        }
        else
        {
           return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
        }
     }
 
     public function SellerOrderCanceled(Request $request)//已取消訂單
     {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            $query = CheckoutOrder::all()
                    ->where('page_id', '=', $page_id)
                    ->where('order_status', '=', 'canceled');
    
            return view('seller_order', ['order' => $query]);
        }
        else
        {
           return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
        }
     }
     //------------------------------------------------------------------------------------------------------------
}