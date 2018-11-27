<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
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
            $query = CheckoutOrder::all()
                    ->where('fb_id', '=', $fb_id)
                    ->groupBy('order_id');
            $countAllOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->distinct()
            ->count();
            $countUnpaidOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'unpaid')
            ->distinct()
            ->count();
            $countUndeliveredOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'undelivered')
            ->distinct()
            ->count();   
            $countDeliveredOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'delivered')
            ->distinct()
            ->count();     
            $countFinishedOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'finished')
            ->distinct()
            ->count();  
            $countCanceledOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'canceled')
            ->distinct()
            ->count();          
                        
    
            return view('seller_order', ['order' => $query,'click' => 'all' ,'countAllOrder' => $countAllOrder,'countUnpaidOrder' => $countUnpaidOrder,'countUndeliveredOrder' => $countUndeliveredOrder,'countDeliveredOrder' => $countDeliveredOrder,'countFinishedOrder' => $countFinishedOrder,'countCanceledOrder' => $countCanceledOrder]);
        
     }
     
     public function BuyerOrderUnpaid(Request $request)//未付款訂單
     {
      
            $fb_id = Auth::user()->fb_id;
            $query = CheckoutOrder::all()
                    ->where('fb_id', '=', $fb_id)
                    ->where('order_status', '=', 'unpaid')
                    ->groupBy('order_id');

            $countAllOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->distinct()
            ->count();
            $countUnpaidOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'unpaid')
            ->distinct()
            ->count();
            $countUndeliveredOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'undelivered')
            ->distinct()
            ->count();   
            $countDeliveredOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'delivered')
            ->distinct()
            ->count();     
            $countFinishedOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'finished')
            ->distinct()
            ->count();  
            $countCanceledOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'canceled')
            ->distinct()
            ->count();          
    
            return view('seller_order', ['order' => $query,'click' => 'unpaid' ,'countAllOrder' => $countAllOrder,'countUnpaidOrder' => $countUnpaidOrder,'countUndeliveredOrder' => $countUndeliveredOrder,'countDeliveredOrder' => $countDeliveredOrder,'countFinishedOrder' => $countFinishedOrder,'countCanceledOrder' => $countCanceledOrder]);
       
     }
 
     public function BuyerOrderUndelivered(Request $request)//未出貨訂單
     {
        
            $fb_id = Auth::user()->fb_id;
            $query = CheckoutOrder::all()
                    ->where('fb_id', '=', $fb_id)
                    ->where('order_status', '=', 'undelivered')
                    ->groupBy('order_id');
            
            $countAllOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->distinct()
            ->count();
            $countUnpaidOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'unpaid')
            ->distinct()
            ->count();
            $countUndeliveredOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'undelivered')
            ->distinct()
            ->count();   
            $countDeliveredOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'delivered')
            ->distinct()
            ->count();     
            $countFinishedOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'finished')
            ->distinct()
            ->count();  
            $countCanceledOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'canceled')
            ->distinct()
            ->count();          
    
            return view('seller_order', ['order' => $query,'click' => 'undelivered' ,'countAllOrder' => $countAllOrder,'countUnpaidOrder' => $countUnpaidOrder,'countUndeliveredOrder' => $countUndeliveredOrder,'countDeliveredOrder' => $countDeliveredOrder,'countFinishedOrder' => $countFinishedOrder,'countCanceledOrder' => $countCanceledOrder]);
        
     }
 
     public function BuyerOrderDelivered(Request $request)//運送中訂單
     {
        
            $fb_id = Auth::user()->fb_id;
            $query = CheckoutOrder::all()
                    ->where('fb_id', '=', $fb_id)
                    ->where('order_status', '=', 'delivered')
                    ->groupBy('order_id');
            
            $countAllOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->distinct()
            ->count();
            $countUnpaidOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'unpaid')
            ->distinct()
            ->count();
            $countUndeliveredOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'undelivered')
            ->distinct()
            ->count();   
            $countDeliveredOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'delivered')
            ->distinct()
            ->count();     
            $countFinishedOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'finished')
            ->distinct()
            ->count();  
            $countCanceledOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'canceled')
            ->distinct()
            ->count();          
    
            return view('seller_order', ['order' => $query,'click' => 'delivered' ,'countAllOrder' => $countAllOrder,'countUnpaidOrder' => $countUnpaidOrder,'countUndeliveredOrder' => $countUndeliveredOrder,'countDeliveredOrder' => $countDeliveredOrder,'countFinishedOrder' => $countFinishedOrder,'countCanceledOrder' => $countCanceledOrder]);
        
     }
 
     public function BuyerOrderFinished(Request $request)//已完成訂單
     {
        
            $fb_id = Auth::user()->fb_id;
            $query = CheckoutOrder::all()
                    ->where('fb_id', '=', $fb_id)
                    ->where('order_status', '=', 'finished')
                    ->groupBy('order_id');

            $countAllOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->distinct()
            ->count();
            $countUnpaidOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'unpaid')
            ->distinct()
            ->count();
            $countUndeliveredOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'undelivered')
            ->distinct()
            ->count();   
            $countDeliveredOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'delivered')
            ->distinct()
            ->count();     
            $countFinishedOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'finished')
            ->distinct()
            ->count();  
            $countCanceledOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'canceled')
            ->distinct()
            ->count();          
    
            return view('seller_order', ['order' => $query,'click' => 'finished' ,'countAllOrder' => $countAllOrder,'countUnpaidOrder' => $countUnpaidOrder,'countUndeliveredOrder' => $countUndeliveredOrder,'countDeliveredOrder' => $countDeliveredOrder,'countFinishedOrder' => $countFinishedOrder,'countCanceledOrder' => $countCanceledOrder]);
       
     }
 
     public function BuyerOrderCanceled(Request $request)//已取消訂單
     {
        
            $fb_id = Auth::user()->fb_id;
            $query = CheckoutOrder::all()
                    ->where('fb_id', '=', $fb_id)
                    ->where('order_status', '=', 'canceled')
                    ->groupBy('order_id');

            $countAllOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->distinct()
            ->count();
            $countUnpaidOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'unpaid')
            ->distinct()
            ->count();
            $countUndeliveredOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'undelivered')
            ->distinct()
            ->count();   
            $countDeliveredOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'delivered')
            ->distinct()
            ->count();     
            $countFinishedOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'finished')
            ->distinct()
            ->count();  
            $countCanceledOrder=CheckoutOrder::where('fb_id', '=', $fb_id)
            ->where('order_status', '=', 'canceled')
            ->distinct()
            ->count();          
    
            return view('seller_order', ['order' => $query,'click' => 'canceled' ,'countAllOrder' => $countAllOrder,'countUnpaidOrder' => $countUnpaidOrder,'countUndeliveredOrder' => $countUndeliveredOrder,'countDeliveredOrder' => $countDeliveredOrder,'countFinishedOrder' => $countFinishedOrder,'countCanceledOrder' => $countCanceledOrder]);
        
     }
     //------------------------------------------------------------------------------------------------------------
}