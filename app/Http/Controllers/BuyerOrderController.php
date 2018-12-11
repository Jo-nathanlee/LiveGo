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
            $fb_id = Auth::user()->fb_id;
            $query = DB::table('order_detail')
            ->where('buyer_fbid', '=', $fb_id)
            ->join('status', 'order_detail.status', '=', 'status.status_eng')
            ->select('order_detail.*', 'status.status_cht')
            ->get();

            $countAllOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->count();
            $countUnpaidOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', 'unpaid')
            ->count();
            $countUndeliveredOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', 'undelivered')
            ->count();   
            $countDeliveredOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', 'delivered')
            ->count();     
            $countFinishedOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', 'finished')
            ->count();  
            $countCanceledOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', 'canceled')
            ->count();          
                        
    
            return view('buyer_order', ['order' => $query,'click' => 'all' ,'countAllOrder' => $countAllOrder,'countUnpaidOrder' => $countUnpaidOrder,'countUndeliveredOrder' => $countUndeliveredOrder,'countDeliveredOrder' => $countDeliveredOrder,'countFinishedOrder' => $countFinishedOrder,'countCanceledOrder' => $countCanceledOrder]);
        
     }
     
     public function BuyerOrderUnpaid(Request $request)//未付款訂單
     {
      
        $fb_id = Auth::user()->fb_id;

        $query = OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'unpaid')
        ->get();

        $countAllOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->count();
        $countUnpaidOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'unpaid')
        ->count();
        $countUndeliveredOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'undelivered')
        ->count();   
        $countDeliveredOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'delivered')
        ->count();     
        $countFinishedOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'finished')
        ->count();  
        $countCanceledOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'canceled')
        ->count();          
    
            return view('buyer_order', ['order' => $query,'click' => 'unpaid' ,'countAllOrder' => $countAllOrder,'countUnpaidOrder' => $countUnpaidOrder,'countUndeliveredOrder' => $countUndeliveredOrder,'countDeliveredOrder' => $countDeliveredOrder,'countFinishedOrder' => $countFinishedOrder,'countCanceledOrder' => $countCanceledOrder]);
       
     }
 
     public function BuyerOrderUndelivered(Request $request)//未出貨訂單
     {
        
        $fb_id = Auth::user()->fb_id;
        $query = OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'undelivered')
        ->get();
       
            
        $countAllOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->count();
        $countUnpaidOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'unpaid')
        ->count();
        $countUndeliveredOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'undelivered')
        ->count();   
        $countDeliveredOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'delivered')
        ->count();     
        $countFinishedOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'finished')
        ->count();  
        $countCanceledOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'canceled')
        ->count();          
    
            return view('buyer_order', ['order' => $query,'click' => 'undelivered' ,'countAllOrder' => $countAllOrder,'countUnpaidOrder' => $countUnpaidOrder,'countUndeliveredOrder' => $countUndeliveredOrder,'countDeliveredOrder' => $countDeliveredOrder,'countFinishedOrder' => $countFinishedOrder,'countCanceledOrder' => $countCanceledOrder]);
        
     }
 
     public function BuyerOrderDelivered(Request $request)//運送中訂單
     {
        
        $fb_id = Auth::user()->fb_id;
        $query = OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'delivered')
        ->get();
       
            
        $countAllOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->count();
        $countUnpaidOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'unpaid')
        ->count();
        $countUndeliveredOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'undelivered')
        ->count();   
        $countDeliveredOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'delivered')
        ->count();     
        $countFinishedOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'finished')
        ->count();  
        $countCanceledOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'canceled')
        ->count();          
    
            return view('buyer_order', ['order' => $query,'click' => 'delivered' ,'countAllOrder' => $countAllOrder,'countUnpaidOrder' => $countUnpaidOrder,'countUndeliveredOrder' => $countUndeliveredOrder,'countDeliveredOrder' => $countDeliveredOrder,'countFinishedOrder' => $countFinishedOrder,'countCanceledOrder' => $countCanceledOrder]);
        
     }
 
     public function BuyerOrderFinished(Request $request)//已完成訂單
     {
        
        $fb_id = Auth::user()->fb_id;
        $query = OrderDetail::where('buyer_fbid', '=', $fb_id)
            ->where('status', '=', 'finished')
            ->get();

        $countAllOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->count();
        $countUnpaidOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'unpaid')
        ->count();
        $countUndeliveredOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'undelivered')
        ->count();   
        $countDeliveredOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'delivered')
        ->count();     
        $countFinishedOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'finished')
        ->count();  
        $countCanceledOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'canceled')
        ->count();          
    
            return view('buyer_order', ['order' => $query,'click' => 'finished' ,'countAllOrder' => $countAllOrder,'countUnpaidOrder' => $countUnpaidOrder,'countUndeliveredOrder' => $countUndeliveredOrder,'countDeliveredOrder' => $countDeliveredOrder,'countFinishedOrder' => $countFinishedOrder,'countCanceledOrder' => $countCanceledOrder]);
       
     }
 
     public function BuyerOrderCanceled(Request $request)//已取消訂單
     {
        
        $fb_id = Auth::user()->fb_id;
        $query = OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'canceled')
        ->get();
        

        $countAllOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->count();
        $countUnpaidOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'unpaid')
        ->count();
        $countUndeliveredOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'undelivered')
        ->count();   
        $countDeliveredOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'delivered')
        ->count();     
        $countFinishedOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'finished')
        ->count();  
        $countCanceledOrder=OrderDetail::where('buyer_fbid', '=', $fb_id)
        ->where('status', '=', 'canceled')
        ->count();          
    
            return view('buyer_order', ['order' => $query,'click' => 'canceled' ,'countAllOrder' => $countAllOrder,'countUnpaidOrder' => $countUnpaidOrder,'countUndeliveredOrder' => $countUndeliveredOrder,'countDeliveredOrder' => $countDeliveredOrder,'countFinishedOrder' => $countFinishedOrder,'countCanceledOrder' => $countCanceledOrder]);
        
     }

     public function BuyerOrderDetail(Request $request)//訂單詳情
     {
         if (Gate::allows('seller-only',  Auth::user())) {
            $order_id = $request->input('order_id');
            $queryDetail = OrderDetail::where('order_id', '=', $order_id)
            ->first();
            $queryOrders = CheckoutOrder::where('order_id', '=', $order_id)
            ->get();

            $order = DB::table('order_detail')
            ->where('order_id', '=', $order_id)
            ->join('status', 'order_detail.status', '=', 'status.status_eng')
            ->select('order_detail.*', 'status.status_cht')
            ->first();

            return view('buyer_order_detail', ['order_detail' => $order,'order_goods' => $queryOrders]);

         }
         else
         {
            return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
         }
     }
     //------------------------------------------------------------------------------------------------------------
}