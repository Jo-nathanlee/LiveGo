<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use DB;
use App\Entities\Page;
use App\Entities\Prize;
use App\Entities\PageDetail;
use App\Entities\Member;
use App\Entities\CheckoutOrder;
use App\Entities\LogisticsOrder;
use App\Entities\StreamingOrder;
use App\Entities\OrderDetail;
use App\Entities\StreamingProduct;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use TCPDF;
use Ecpay;
use DateTime;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderExport;

class OrderController extends Controller
{
   //賣家訂單查看------------------------------------------------------------------------
   // public function OrderDetail(Request $request)//全部訂單
   // {
   //    return view('order_detail');
   // }

   public function Order_edit(Request $request){

      $page_id = $request->page_id;
      $query= $request->selectedOrder;
      $status =  $request->status;


      for($i=0;$i<count($query);$i++){

         $order_id = $query[$i][0];
         $ps_id = $query[$i][1];

         if($order_id == "尚未成立訂單" && $status == 15){
            $time_stamp=time();
            $random_num=rand(10,99);
            $order_id=$time_stamp.$random_num.substr($ps_id,0,8);

            $orders =  DB::table('streaming_order')
            ->where('page_id', $page_id)
            ->where('ps_id',$ps_id)
            ->whereNull('order_id')
            ->update(['order_id' => $order_id]);

            $orders =  DB::table('streaming_order')
            ->where('page_id', $page_id)
            ->where('ps_id',$ps_id)
            ->where('order_id',$order_id)
            ->get();

            $detail_total = 0;
            foreach($orders as $order){
               $detail_total= $detail_total + ($order->goods_num * $order->bid_price);

               $product =  DB::table('streaming_product')
               ->where('product_id', $order->product_id)
               ->increment('goods_num',$order->goods_num);

               $product =  DB::table('streaming_product')
               ->where('product_id', $order->product_id)
               ->decrement('pre_sale',$order->goods_num);
            }

            $OrderDetail = new OrderDetail();
            $OrderDetail->page_id = $page_id;
            $OrderDetail->order_id = $order_id;
            $OrderDetail->ps_id = $ps_id;
            $OrderDetail->status = $status;
            $OrderDetail->goods_total = $detail_total;
            $OrderDetail->freight = 0;
            $OrderDetail->pay_id = 75;
            $OrderDetail->save();

            $update_canceltimes = Member::where('ps_id',$ps_id)->increment('cancel_times');
         }
         if($order_id != "尚未成立訂單" && $status == 15){
            DB::table('order_detail')
            ->where('page_id', $page_id)
            ->where('order_id',$order_id)
            ->update(['status' => $status]);

            $orders =  DB::table('streaming_order')
            ->where('page_id', $page_id)
            ->where('ps_id',$ps_id)
            ->where('order_id',$order_id)
            ->get();

            foreach($orders as $order){
               //後台取消，加回庫存
               $product =  DB::table('streaming_product')
               ->where('product_id', $order->product_id)
               ->increment('goods_num',$order->goods_num);
            }

         }else if($order_id != "尚未成立訂單"){
            DB::table('order_detail')
            ->where('page_id', $page_id)
            ->where('order_id',$order_id)
            ->update(['status' => $status]);
         }
      }
      return json_encode('success');
   }
   
   //全部訂單(賣家)
   public function Order(Request $request){
      
      $page = Page::where('as_id', Auth::user()->fb_id)->first();
      $page_id = $page->page_id;
      $fb_id = Auth::user()->fb_id;
      $name = Auth::user()->name;
      $token = $page->page_token;
      if($request->has('status')){
         $status = (int)$request->input('status');
      }
      else{
         $status = 0;
      }

      if($request->has('startday') && $request->has('endday')){
         $start_date = new DateTime ( $request->input('startday') ) ;
         $end_date = new DateTime ( $request->input('endday') );
      }else{
         $start_date =new DateTime('today');
         $end_date =  new DateTime('today +1 day');
      }
      
      $ps_id="";
      $total = 0;

      $query = null;
      $inconfirmed_order = null;

      if($status == 0){
         $query = DB::table('order_detail')
         ->where('order_detail.page_id',$page_id)
         ->whereBetween('order_detail.created_at', [$start_date, $end_date ])
         ->join('member','member.ps_id','order_detail.ps_id')
         ->leftJoin('orderstatus_cht','orderstatus_cht.orderstatus_id','order_detail.status')
         ->select('member.fb_name','member.ps_id','orderstatus_cht.order_status','orderstatus_cht.orderstatus_id','order_detail.order_id','order_detail.goods_total','order_detail.created_at')
         ->groupBy('order_id')
         ->get();

         $query2 = DB::table('streaming_order')
         ->where('streaming_order.page_id',$page_id)
         ->whereNull('streaming_order.order_id')
         ->join('member','member.ps_id','streaming_order.ps_id')
         ->select('member.fb_name','member.ps_id','streaming_order.order_id','streaming_order.bid_price','streaming_order.goods_num','streaming_order.created_at')
         ->get();

         $inconfirmed_order = array();

         foreach($query2 as $data){
            if( $ps_id != $data->ps_id){
               $ps_id = $data->ps_id;
               $total = $data->bid_price*$data->goods_num;
            }else{
               $total = $total + ($data->bid_price*$data->goods_num);
            }

            $inconfirmed_order[$data->ps_id] = array(
               'time' => '尚未成立訂單',
               'order_id' => '尚未成立訂單',
               'total' => $total,
               'ps_id'=>$data->ps_id,
               'name' => $data->fb_name,
               'status' => '待確定',
               'status_id' => 10,
            );
         }
      }else if($status == 10){
         $query2 = DB::table('streaming_order')
         ->where('streaming_order.page_id',$page_id)
         ->whereNull('streaming_order.order_id')
         ->join('member','member.ps_id','streaming_order.ps_id')
         ->select('member.fb_name','member.ps_id','streaming_order.order_id','streaming_order.bid_price','streaming_order.goods_num','streaming_order.created_at')
         ->get();

   

         $inconfirmed_order = array();

         foreach($query2 as $data){
            if( $ps_id != $data->ps_id){
               $ps_id = $data->ps_id;
               $total = $data->bid_price*$data->goods_num;
            }else{
               $total = $total + ($data->bid_price*$data->goods_num);
            }

            $inconfirmed_order[$data->ps_id] = array(
               'time' => '尚未成立訂單',
               'order_id' => '尚未成立訂單',
               'total' => $total,
               'ps_id'=>$data->ps_id,
               'name' => $data->fb_name,
               'status' => '待確定',
               'status_id' => 10,
            );
         }
      }else{
         $query = DB::table('order_detail')
         ->where('order_detail.page_id',$page_id)
         ->whereBetween('order_detail.created_at', [$start_date, $end_date ])
         ->join('member','member.ps_id','order_detail.ps_id')
         ->leftJoin('orderstatus_cht','orderstatus_cht.orderstatus_id','order_detail.status')
         ->where('order_detail.status',$status)
         ->where('member.page_id',$page_id)
         ->select('member.fb_name','member.ps_id','orderstatus_cht.order_status','orderstatus_cht.orderstatus_id','order_detail.order_id','order_detail.goods_total','order_detail.created_at')
         ->get();
      }


      return view('order', ['page_id' => $page_id, 'token'=>$token, 'inconfirmed_order'=> $inconfirmed_order,'confirmed_order'=> $query,'start_date'=>$start_date,'end_date'=>$end_date,'status'=>$status ,'fb_id' =>  $fb_id ,'name' =>$name]);
   }

   //excel訂單下載
   public function Excel_printer(Request $request){
         $page_id = $request->input('page_id');
         $start_time =   $request->input('start_date')['date'] ;
         $end_time = $request->input('end_date')['date']  ;
         $start_time =date($start_time);
         $end_time = date($end_time);
         $status = $request->input('status');

         $page = Page::where('as_id', Auth::user()->fb_id)->first();
         $page_name = $page->page_name;

         $order_list = [];
         $orderid=[];

         if($status ==0 OR $status ==10  ){
            $query =  DB::table('order_detail')
            ->where('order_detail.page_id',$page_id)
            ->whereBetween('order_detail.created_at', [$start_time, $end_time])
            ->join('member','member.ps_id','order_detail.ps_id')
            ->where('member.page_id',$page_id)
            ->get();
            
            
         }
         else{
            $query =  DB::table('order_detail')
            ->where('order_detail.page_id',$page_id)
            ->where('order_detail.status',$status)
            ->whereBetween('order_detail.created_at', [$start_time, $end_time])
            ->join('member','member.ps_id','order_detail.ps_id')
            ->where('member.page_id',$page_id)
            ->get();
         }

      

         foreach($query  as $data){
            array_push($orderid,$data->order_id);
            $order_list[$data->order_id]=array(
               'order_id' => $data->order_id,
               'name'=>$data->fb_name,
               'cellphone'=>$data->cellphone,
               'transaction_date' => $data->created_at,
               'address'=>$data->address,
               'note' =>$data->note,                  
               'freight'=>$data->freight,
               'goods_total'=>$data->goods_total,
               'all_total'=>$data->goods_total+$data->freight,
            );
         }
         
         foreach($orderid as $order_id){
            $streaming_order = DB::table('streaming_order')
            ->where('streaming_order.page_id',$page_id)
            ->where('streaming_order.order_id',$order_id)
            ->join('streaming_product','streaming_order.product_id','streaming_product.product_id')
            ->where('streaming_product.page_id',$page_id)
            ->select('streaming_order.goods_num','streaming_order.bid_price','streaming_product.goods_name','streaming_product.category')
            ->get();
            $order_list[$order_id]['goods']=$streaming_order;
         }



         $file_name = $page_name."- 訂單";

         $new_excel = new OrderExport($order_list);

         return Excel::download($new_excel , $file_name.".xlsx");



   }

   //order_detail
   public function OrderDetail(Request $request)
   {
      $page = Page::where('as_id', Auth::user()->fb_id)->first();
      $page_id = $page->page_id;
      $as_id = Auth::user()->fb_id;
      $name = Auth::user()->name;
      $token =  $page->page_token;
      $order_id = $request->order_id;
       $orders = StreamingOrder::where('order_id', $order_id)
      ->join('streaming_product','streaming_order.product_id','streaming_product.product_id')
      ->select('streaming_order.bid_price' ,'streaming_order.id', 'streaming_order.goods_num as bid_num','streaming_product.*')
      ->get();

      $prize = Prize::where('order_id', $order_id)
      ->get();

      $order_detail = OrderDetail::where('order_detail.order_id', $order_id)
      ->join('member','member.ps_id','order_detail.ps_id')
      ->join('member_type','member.member_type','member_type.member_type') 
      ->where('member.page_id',$page_id)   
      ->join('pay_cht','pay_cht.pay_id','order_detail.pay_id')    
      ->join('orderstatus_cht','order_detail.status','orderstatus_cht.orderstatus_id')    
      ->first();


      
      $count = $orders->count(); //?樣商品
      try{
         
         $order_detail = OrderDetail::where('order_detail.order_id', $order_id)
         ->join('member','member.ps_id','order_detail.ps_id')
         ->join('member_type','member.member_type','member_type.member_type') 
         ->where('member.page_id',$page_id)   
         ->join('pay_cht','pay_cht.pay_id','order_detail.pay_id')    
         ->join('orderstatus_cht','order_detail.status','orderstatus_cht.orderstatus_id')    
         ->first();
         $total_price = $order_detail->goods_total + $order_detail->freight;
      }catch(\Exception $e) {
         $order_detail = OrderDetail::where('order_detail.order_id', $order_id)
         ->join('member','member.ps_id','order_detail.ps_id')
         ->join('member_type','member.member_type','member_type.member_type') 
         ->where('member.page_id',$page_id)  
         ->first(); 
         $total_price = $order_detail->goods_total + $order_detail->freight;;
      } 


      return view('order_detail',['prize' =>$prize,'type' =>$order_detail->type_cht,'token'=>$token ,'user_asid'=>$as_id, 'name' =>$name, 'page_id' =>  $page_id],compact('orders','count','order_detail','total_price','product_price'));
   }

   public function InconfirmedOrders(Request $request){
      $page = Page::where('as_id', Auth::user()->fb_id)->first();
      $page_id = $page->page_id;
      $user_asid = Auth::user()->fb_id;
      $name = Auth::user()->name;
      $token = $page->page_token;

      $order_ps_id = $request->ps_id;

      $query = DB::table('streaming_order')
      ->where('streaming_order.ps_id',$order_ps_id)
      ->where('streaming_order.page_id',$page_id)
      ->whereNull('streaming_order.order_id')
      ->join('member','member.ps_id','streaming_order.ps_id')
      ->join('streaming_product','streaming_order.product_id','streaming_product.product_id')
      ->where('member.page_id',$page_id)
      ->select('member.fb_name','member.ps_id','streaming_product.*', 'streaming_order.goods_num as bid_num','streaming_order.bid_price','streaming_order.id')
      ->get();


      return view('inconfirmed_orders',['orders' =>$query,'token'=>$token , 'user_asid' =>  $user_asid , 'name' =>$name, 'token'=>$token  ]);
   }
   
   public function ShowProduct(Request $request){
 
      $page = Page::where('as_id', Auth::user()->fb_id)->first();
      $page_id = $page->page_id;
      $goods_list = [];
      $goods_key = "";
      $index = 0 ;
      $diverse = 0 ;
      $auction_product = StreamingProduct::where('page_id', '=', $page_id)
      ->where('goods_num' , '>', 0 )
      ->where('is_delete',0)
      ->get();

      foreach ($auction_product as $data) {
          $goods_num = StreamingOrder::where('page_id', '=', $page_id)
          ->where('product_id',$data->product_id)
          ->sum('goods_num');
         
          if($goods_key!=$data->goods_key){
              $diverse = 0 ;
              $goods_key =$data->goods_key;
              $index = 1;
              $StreamingProduct = StreamingProduct::where('page_id', '=', $page_id)
              ->where('goods_key', '=', $data->goods_key)
              ->where('is_delete',0)
              ->get();
              $category = '';
              foreach($StreamingProduct as $query)
              {
                  $category .= '('.$query->category . ') ';
                  $diverse ++;
              }
              if($diverse==1){
                  $category = '<b>'.$query->category. '</b>';
              }

          }else{
              $index++;
          }

          $all_category =  $category;

          $goods_list[ $data->keyword ]=array(
              'pic_url' => $data->pic_url,
              'goods_key' => $data->goods_key,
              'goods_name' => $data->goods_name,
              'keyword' => $data->keyword,
              'goods_price' => $data->goods_price,
              'goods_num' => $data->goods_num -  $data->pre_sale ,
              'goods_category' => $data->category,
              'goods_note' => $data->description,
              'product_id' => $data->product_id,
              'bid_num' => $goods_num,
              'index' => $index,
              'all_category' => str_replace("(".$data->category.")","<b>(".$data->category.")</b>",$all_category),
              'diverse'=> $diverse
          );
      }

      return $goods_list;
   }

   public function GetProductNum(Request $request){
      $page = Page::where('as_id', Auth::user()->fb_id)->first();
      $page_id = $page->page_id;
      $product_id = $request->product_id;

      $query = DB::table('streaming_product')
      ->where('page_id',$page_id)
      ->where('product_id',$product_id)
      ->first();

      return json_encode($query) ;
   }

   public function SubmitEditProduct(Request $request){
      $page = Page::where('as_id', Auth::user()->fb_id)->first();
      $page_id = $page->page_id;
      $index = $request->index;
      $product_id = $request->product_id;
      
      $goods_price = $request->goods_price;
      $goods_num = $request->goods_num;

      $query = DB::table('streaming_product')
      ->where('product_id',$product_id)
      ->where('page_id',$page_id)
      ->first();

      if( ($query->goods_num - $query->pre_sale) < $goods_num){
         return "false";
      }else{
         DB::table('streaming_order')->where('id', $index)
         ->where('page_id', $page_id )
         ->update(['product_id' => $product_id ,'bid_price' => $goods_price,'goods_num' => $goods_num, 'comment' => DB::raw("CONCAT(comment, '" . '註：賣家修改訂單內容' . "')")]);

      }

   }

   public function SubmitAddProduct(Request $request){
      $page = Page::where('as_id', Auth::user()->fb_id)->first();
      $page_id = $page->page_id;
      $addProductList = $request->addProductList;
      $ps_id = $request->ps_id;
      foreach( $addProductList as $product){
         
         $query = DB::table('streaming_product')
         ->where('product_id',$product['product_id'])
         ->where('page_id',$page_id)
         ->first();

         if( ( $query->goods_num - $query->pre_sale )>=$product['num'] ){
            $StreamingOrder = new StreamingOrder;
            $StreamingOrder->page_id = $page_id;
            $StreamingOrder->ps_id =  $ps_id;
            $StreamingOrder->goods_num = $product['num'];
            $StreamingOrder->comment = '由賣家新增';
            $StreamingOrder->bid_price = $product['price'];
            $StreamingOrder->product_id = $product['product_id'];
            $StreamingOrder->save();

            $query = DB::table('streaming_product')
            ->where('product_id',$product['product_id'])
            ->where('page_id',$page_id)
            ->increment('pre_sale',$product['num']);
         }

      }

      return json_encode("");
   }

   public function DeleteOrder(Request $request){
      $page = Page::where('as_id', Auth::user()->fb_id)->first();
      $page_id = $page->page_id;
      $index = $request->index;

      $query= DB::table('streaming_order')
      ->where('page_id',$page_id)
      ->where('id',$index)
      ->first();

      DB::table('streaming_product')->where('product_id', $query->product_id)->decrement('pre_sale',$query->goods_num);

      $deletedRows = DB::table('streaming_order')
      ->where('page_id',$page_id)
      ->where('id',$index)
      ->delete();
      return "";
   }

   public function RefreshOrder(Request $request){
      $page = Page::where('as_id', Auth::user()->fb_id)->first();
      $page_id = $page->page_id;
      $name = Auth::user()->name;
      $token =  $page->page_token;
      $ps_id = $request->ps_id;


      $orders = StreamingOrder::where('ps_id', $ps_id)
      ->whereNull('order_id')
      ->join('streaming_product','streaming_order.product_id','streaming_product.product_id')
      ->select('streaming_order.bid_price' ,'streaming_order.id', 'streaming_order.goods_num as bid_num','streaming_product.*')
      ->get();

      $prize = Prize::whereNull('order_id')
      ->get();
      
      $count = $orders->count(); //?樣商品
  
      return compact('orders','count','prize');
   }

   //買家全部訂單
   public function Buyer_Order(Request $request){
      
      $page_id = $request->input('page_id');
      $page = Page::where('page_id', $page_id)->first();
      $token = $page->page_token;
      $fb_id = Auth::user()->fb_id;
      $name = Auth::user()->name;
      

      if($request->has('startday') && $request->has('endday')){
         $start_date = new DateTime ( $request->input('startday') ) ;
         $end_date = new DateTime ( $request->input('endday') );
      }else{
         $start_date =new DateTime('today');
         $end_date =  new DateTime('today +1 day');
      }
      
      $ps_id="";
      $query = null;

      $ps_id = Member::where('as_id', Auth::user()->fb_id)->where('page_id',$page_id)->first();
      $ps_id = $ps_id['ps_id'];

      $query = DB::table('order_detail')
      ->where('order_detail.page_id',$page_id)
      ->where('order_detail.ps_id',$ps_id)
      ->whereBetween('order_detail.created_at', [$start_date, $end_date ])
      ->join('member','member.ps_id','order_detail.ps_id')
      ->leftJoin('orderstatus_cht','orderstatus_cht.orderstatus_id','order_detail.status')
      ->where('member.page_id',$page_id)
      ->select('member.fb_name','member.ps_id','orderstatus_cht.order_status','orderstatus_cht.orderstatus_id','order_detail.order_id','order_detail.goods_total','order_detail.created_at')
      ->get();

      

      return view('buyer_order', ['page_id' => $page_id, 'ps_id' => $ps_id, 'token'=>$token, 'confirmed_order'=> $query,'start_date'=>$start_date,'end_date'=>$end_date, 'fb_id' =>  $fb_id ,'name' =>$name]);
   }

      //買家order_detail
      public function Buyer_OrderDetail(Request $request)
      {
         $page = Page::where('as_id', Auth::user()->fb_id)->first();
         $page_id = $page->page_id;
         $as_id = Auth::user()->fb_id;
         $name = Auth::user()->name;
         $token =  $page->page_token;
         $order_id = $request->order_id;
          $orders = StreamingOrder::where('order_id', $order_id)
         ->join('streaming_product','streaming_order.product_id','streaming_product.product_id')
         ->select('streaming_order.bid_price' ,'streaming_order.id', 'streaming_order.goods_num as bid_num','streaming_product.*')
         ->get();
   
         $prize = Prize::where('order_id', $order_id)
         ->get();
   
         $order_detail = OrderDetail::where('order_detail.order_id', $order_id)
         ->join('member','member.ps_id','order_detail.ps_id')
         ->join('member_type','member.member_type','member_type.member_type') 
         ->where('member.page_id',$page_id)   
         ->join('pay_cht','pay_cht.pay_id','order_detail.pay_id')    
         ->join('orderstatus_cht','order_detail.status','orderstatus_cht.orderstatus_id')    
         ->first();
   
   
         
         $count = $orders->count(); //?樣商品
         try{
            
            $order_detail = OrderDetail::where('order_detail.order_id', $order_id)
            ->join('member','member.ps_id','order_detail.ps_id')
            ->join('member_type','member.member_type','member_type.member_type') 
            ->where('member.page_id',$page_id)   
            ->join('pay_cht','pay_cht.pay_id','order_detail.pay_id')    
            ->join('orderstatus_cht','order_detail.status','orderstatus_cht.orderstatus_id')    
            ->first();
            $total_price = $order_detail->goods_total + $order_detail->freight;
         }catch(\Exception $e) {
            $order_detail = OrderDetail::where('order_detail.order_id', $order_id)
            ->join('member','member.ps_id','order_detail.ps_id')
            ->join('member_type','member.member_type','member_type.member_type') 
            ->where('member.page_id',$page_id)  
            ->first(); 
            $total_price = $order_detail->goods_total + $order_detail->freight;;
         } 
   
         $ps_id = Member::where('as_id', Auth::user()->fb_id)->where('page_id',$page_id)->first();
         $ps_id = $ps_id['ps_id'];
   
         return view('buyer_order_detail',['prize' =>$prize, 'ps_id' => $ps_id, 'type' =>$order_detail->type_cht,'token'=>$token ,'user_asid'=>$as_id, 'name' =>$name, 'page_id' =>  $page_id],compact('orders','count','order_detail','total_price','product_price'));
      }
}