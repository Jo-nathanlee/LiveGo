<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use DB;
use App\Entities\Page;
use App\Entities\PageDetail;
use App\Entities\CheckoutOrder;
use App\Entities\LogisticsOrder;
use App\Entities\StreamingOrder;
use App\Entities\OrderDetail;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use TCPDF;
use Ecpay;


class SellerOrderController extends Controller
{
     //賣家訂單查看------------------------------------------------------------------------
     public function SellerOrderAll(Request $request)//全部訂單
     {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            $page_name = $page->page_name;

            $query = DB::table('order_detail')
            ->where('page_id', '=', $page_id)
            ->join('orderstatus_cht', 'order_detail.status', '=', 'orderstatus_cht.orderstatus_id')
            ->leftJoin('logistics', 'order_detail.other_status', '=', 'logistics.status_code')
            ->select('order_detail.*', 'orderstatus_cht.order_status','logistics.message')
            ->orderBy('order_detail.created_at', 'desc')
            ->get();

            if(count($query) == 0) {
               //假資料
               $order_id = time().'8019215358';
               $fb_id = Auth::user()->fb_id;

               $CheckoutOrder_store = new CheckoutOrder();
               $CheckoutOrder_store->page_id = $page_id;
               $CheckoutOrder_store->order_id = $order_id;
               $CheckoutOrder_store->fb_id = '100691261074116';
               $CheckoutOrder_store->product_id = 1;
               $CheckoutOrder_store->goods_num = 1;
               $CheckoutOrder_store->total_price = '900';
               $CheckoutOrder_store->created_time = date("Y-m-d H:i:s");
               $CheckoutOrder_store->purchase_from = 1;
               $CheckoutOrder_store->save();

               $OrderDetail = new OrderDetail();
               $OrderDetail->page_id = $page_id;
               $OrderDetail->buyer_fbid = '100691261074116';
               $OrderDetail->buyer_name = 'LiveGO 教學';
               $OrderDetail->order_id = $order_id;
               $OrderDetail->transaction_date = date("Y-m-d H:i:s");
               $OrderDetail->status = 11;
               $OrderDetail->goods_total = 900;
               $OrderDetail->all_total = 980;
               $OrderDetail->freight = 80;
               $OrderDetail->buyer_address = '新北';
               $OrderDetail->buyer_phone = '22442288';
               $OrderDetail->note = 'note'; 
               $OrderDetail->save();
            }


            $countAllOrder=OrderDetail::where('page_id', '=', $page_id)
            ->count();
            $countUnpaidOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 11)
            ->count();
            $countUndeliveredOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 13)
            ->count();   
            $countDeliveredOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 12)
            ->count();     
            $countFinishedOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 14)
            ->count();  
            $countCanceledOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 15)
            ->count();          
                        
    
            return view('seller_order', ['order' => $query,'click' => 'all','statue' => '' ,'countAllOrder' => $countAllOrder,'countUnpaidOrder' => $countUnpaidOrder,'countUndeliveredOrder' => $countUndeliveredOrder,'countDeliveredOrder' => $countDeliveredOrder,'countFinishedOrder' => $countFinishedOrder,'countCanceledOrder' => $countCanceledOrder]);
        }
        else
        {
           return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
     }
     
     public function SellerOrderUnpaid(Request $request)//未付款訂單
     {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;

            $query = DB::table('order_detail')
            ->where('page_id', '=', $page_id)
            ->where('order_detail.status', '=', 11)
            ->join('orderstatus_cht', 'order_detail.status', '=', 'orderstatus_cht.orderstatus_id')
            ->leftJoin('logistics', 'order_detail.other_status', '=', 'logistics.status_code')
            ->select('order_detail.*', 'orderstatus_cht.order_status','logistics.message')
            ->orderBy('order_detail.created_at', 'desc')
            ->get();

            $countAllOrder=OrderDetail::where('page_id', '=', $page_id)
            ->count();
            $countUnpaidOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 11)
            ->count();
            $countUndeliveredOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 13)
            ->count();   
            $countDeliveredOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 12)
            ->count();     
            $countFinishedOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 14)
            ->count();  
            $countCanceledOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 15)
            ->count();          
    
            return view('seller_order', ['order' => $query,'click' => 'unpaid','statue' => '未付款' ,'countAllOrder' => $countAllOrder,'countUnpaidOrder' => $countUnpaidOrder,'countUndeliveredOrder' => $countUndeliveredOrder,'countDeliveredOrder' => $countDeliveredOrder,'countFinishedOrder' => $countFinishedOrder,'countCanceledOrder' => $countCanceledOrder]);
        }
        else
        {
           return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
     }
 
     public function SellerOrderUndelivered(Request $request)//未出貨訂單
     {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;

            $query = DB::table('order_detail')
            ->where('page_id', '=', $page_id)
            ->where('order_detail.status', '=', 13)
            ->join('orderstatus_cht', 'order_detail.status', '=', 'orderstatus_cht.orderstatus_id')
            ->leftJoin('logistics', 'order_detail.other_status', '=', 'logistics.status_code')
            ->select('order_detail.*', 'orderstatus_cht.order_status','logistics.message')
            ->orderBy('order_detail.created_at', 'desc')
            ->get();
            
            $countAllOrder=OrderDetail::where('page_id', '=', $page_id)
            ->count();
            $countUnpaidOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 11)
            ->count();
            $countUndeliveredOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 13)
            ->count();   
            $countDeliveredOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 12)
            ->count();     
            $countFinishedOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 14)
            ->count();  
            $countCanceledOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 15)
            ->count();          
    
            return view('seller_order', ['order' => $query,'click' => 'undelivered','statue' => '等待出貨中' ,'countAllOrder' => $countAllOrder,'countUnpaidOrder' => $countUnpaidOrder,'countUndeliveredOrder' => $countUndeliveredOrder,'countDeliveredOrder' => $countDeliveredOrder,'countFinishedOrder' => $countFinishedOrder,'countCanceledOrder' => $countCanceledOrder]);
        }
        else
        {
           return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
     }
 
     public function SellerOrderDelivered(Request $request)//運送中訂單
     {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            
            $query = DB::table('order_detail')
            ->where('page_id', '=', $page_id)
            ->where('order_detail.status', '=', 12)
            ->join('orderstatus_cht', 'order_detail.status', '=', 'orderstatus_cht.orderstatus_id')
            ->leftJoin('logistics', 'order_detail.other_status', '=', 'logistics.status_code')
            ->select('order_detail.*', 'orderstatus_cht.order_status','logistics.message')
            ->orderBy('order_detail.created_at', 'desc')
            ->get();
            
            $countAllOrder=OrderDetail::where('page_id', '=', $page_id)
            ->count();
            $countUnpaidOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 11)
            ->count();
            $countUndeliveredOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 13)
            ->count();   
            $countDeliveredOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 12)
            ->count();     
            $countFinishedOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 14)
            ->count();  
            $countCanceledOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 15)
            ->count();               
    
            return view('seller_order', ['order' => $query,'click' => 'delivered','statue' => '運送中' ,'countAllOrder' => $countAllOrder,'countUnpaidOrder' => $countUnpaidOrder,'countUndeliveredOrder' => $countUndeliveredOrder,'countDeliveredOrder' => $countDeliveredOrder,'countFinishedOrder' => $countFinishedOrder,'countCanceledOrder' => $countCanceledOrder]);
        }
        else
        {
           return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
     }
 
     public function SellerOrderFinished(Request $request)//已完成訂單
     {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            
            $query = DB::table('order_detail')
            ->where('page_id', '=', $page_id)
            ->where('order_detail.status', '=', 14)
            ->join('orderstatus_cht', 'order_detail.status', '=', 'orderstatus_cht.orderstatus_id')
            ->leftJoin('logistics', 'order_detail.other_status', '=', 'logistics.status_code')
            ->select('order_detail.*', 'orderstatus_cht.order_status','logistics.message')
            ->orderBy('order_detail.created_at', 'desc')
            ->get();

            $countAllOrder=OrderDetail::where('page_id', '=', $page_id)
            ->count();
            $countUnpaidOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 11)
            ->count();
            $countUndeliveredOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 13)
            ->count();   
            $countDeliveredOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 12)
            ->count();     
            $countFinishedOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 14)
            ->count();  
            $countCanceledOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 15)
            ->count();                
    
            return view('seller_order', ['order' => $query,'click' => 'finished','statue' => '訂單完成' ,'countAllOrder' => $countAllOrder,'countUnpaidOrder' => $countUnpaidOrder,'countUndeliveredOrder' => $countUndeliveredOrder,'countDeliveredOrder' => $countDeliveredOrder,'countFinishedOrder' => $countFinishedOrder,'countCanceledOrder' => $countCanceledOrder]);
        }
        else
        {
           return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
     }
 
     public function SellerOrderCanceled(Request $request)//已取消訂單
     {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
           
            $query = DB::table('order_detail')
            ->where('page_id', '=', $page_id)
            ->where('order_detail.status', '=', 15)
            ->join('orderstatus_cht', 'order_detail.status', '=', 'orderstatus_cht.orderstatus_id')
            ->leftJoin('logistics', 'order_detail.other_status', '=', 'logistics.status_code')
            ->select('order_detail.*', 'orderstatus_cht.order_status','logistics.message')
            ->orderBy('order_detail.created_at', 'desc')
            ->get();

            $countAllOrder=OrderDetail::where('page_id', '=', $page_id)
            ->count();
            $countUnpaidOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 11)
            ->count();
            $countUndeliveredOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 13)
            ->count();   
            $countDeliveredOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 12)
            ->count();     
            $countFinishedOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 14)
            ->count();  
            $countCanceledOrder=OrderDetail::where('page_id', '=', $page_id)
            ->where('status', '=', 15)
            ->count();          
    
            return view('seller_order', ['order' => $query,'click' => 'canceled','statue' => '訂單取消' ,'countAllOrder' => $countAllOrder,'countUnpaidOrder' => $countUnpaidOrder,'countUndeliveredOrder' => $countUndeliveredOrder,'countDeliveredOrder' => $countDeliveredOrder,'countFinishedOrder' => $countFinishedOrder,'countCanceledOrder' => $countCanceledOrder]);
        }
        else
        {
           return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
     }

     public function SellerOrderDetail(Request $request)//訂單詳情
     {
         if (Gate::allows('seller-only',  Auth::user())) {
            $order_id = json_decode($request->input('order_id'));
            $queryDetail = OrderDetail::where('order_id', '=', $order_id)
            ->first();
            $queryOrders = CheckoutOrder::where('order_id', '=', $order_id)
            ->get();

            $order = DB::table('order_detail')
            ->where('order_id', '=', $order_id)
            ->join('orderstatus_cht', 'order_detail.status', '=', 'orderstatus_cht.orderstatus_id')
            ->leftJoin('logistics', 'order_detail.other_status', '=', 'logistics.status_code')
            ->select('order_detail.*', 'orderstatus_cht.order_status','logistics.message')
            ->first();

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


            return view('seller_order_detail', ['order_detail' => $order,'streaming_products' => $StreamingProducts,'shop_products' => $ShopProducts]);

         }
         else
         {
            return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
         }
     }

     public function SellerOrderPDF(Request $request)//訂單詳情
     {
         if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_name = $page->page_name;

            $order_id = json_decode($request->input('order_id'));
            $Order= DB::table('order_detail')->where('order_id', '=', $order_id)
            ->first();

           

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

            $output = '';

            $pdf = new \TCPDF();
            $pdf->SetKeywords('TCPDF, PDF, PHP');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            
            // 设置默认等宽字体
            $pdf->SetDefaultMonospacedFont('courier');
            // 设置间距
            $pdf->SetMargins(15, 15, 15);//页面间隔
            $pdf->SetHeaderMargin(5);//页眉top间隔
            $pdf->SetFooterMargin(10);//页脚bottom间隔

            // // 设置分页
            $pdf->SetAutoPageBreak(true, 25);

            // set default font subsetting mode
            $pdf->setFontSubsetting(true);


            $pdf->AddPage();
            $pdf->SetFont('msungstdlight', '', 14);
            $pdf->writeHTML('<div style="text-align: center"><h1>'.$page_name.'</h1></div>');
            $pdf->writeHTML('<div style="text-align: right">訂單編號： '.$Order->order_id.'</div>');
            $pdf->writeHTML('<div style="text-align: right">收件人： '.$Order->buyer_name.'</div>');
            $pdf->writeHTML('<div style="text-align: right">寄件地址： '.$Order->buyer_address.'</div>');
            $output .= '<style>
                            table,th,tr,td{ 
                                border: 1px solid #dee2e6;    
                                padding: 10px;   
                            }
                        </style>';
            $output .=  '<table>
                            <thead>
                                <tr>
                                    <th>商品名稱</th>
                                    <th>規格</th>
                                    <th>單價</th>
                                    <th>數量</th>
                                    <th>總金額</th>
                                </tr>
                            </thead>
                            <tbody>';
                            foreach($StreamingProducts as $product){
                            if($product->category == "empty"){
                                $product->category="";
                            }
                            $output .='
                                <tr>
                                    <td>'.$product->goods_name.'</td>
                                    <td>'.$product->category.'</td>
                                    <td>'.$product->single_price.'</td>
                                    <td>'.$product->order_num.'</td>
                                    <td>'.((int)$product->single_price)*((int)$product->order_num).'</td>
                                </tr>
                                ';
                            }
                            foreach($ShopProducts as $product){
                              if($product->category == "empty"){
                                  $product->category="";
                              }
                              $output .='
                                  <tr>
                                      <td>'.$product->goods_name.'</td>
                                      <td>'.$product->category.'</td>
                                      <td>'.$product->goods_price.'</td>
                                      <td>'.$product->order_num.'</td>
                                      <td>'.$product->total_price.'</td>
                                  </tr>
                                  ';
                              }
                            $output .='
                           </tbody>

                        </table>';
            
               
            //输出PDF
            $pdf->writeHTML($output, true, false, true, false, '');
            $pdf->writeHTML('<div style="text-align: right">訂單產生時間： '.$Order->created_at.'</div>');

            $pdf->Output('送貨單-'.$order_id." ".$Order->buyer_name.'.pdf', 'D');//I输出、D下载
            return redirect()->back();


         }
         else
         {
            return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
         }
     }
     public function SellerOrderPDF_ALL(Request $request)//訂單詳情
     {
         if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_name = $page->page_name;

            $order_all = json_decode($request->input('order'));

            $order_id = preg_split('/,/',$order_all);

            

            $pdf = new \TCPDF();
            $pdf->SetKeywords('TCPDF, PDF, PHP');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            
            // 设置默认等宽字体
            $pdf->SetDefaultMonospacedFont('courier');
            // 设置间距
            $pdf->SetMargins(15, 15, 15);//页面间隔
            $pdf->SetHeaderMargin(5);//页眉top间隔
            $pdf->SetFooterMargin(10);//页脚bottom间隔

            // // 设置分页
            $pdf->SetAutoPageBreak(true, 25);

            // set default font subsetting mode
            $pdf->setFontSubsetting(true);

           
            foreach($order_id as $order_id){
               $output = '';
               
                $Order= DB::table('order_detail')->where('order_id', '=', $order_id)
                ->first();
    
               //  $Checkorder = CheckoutOrder::where('order_id', '=', $order_all)
               //  ->get();
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
   

                $pdf->AddPage();
                $pdf->SetFont('msungstdlight', '', 14);
                $pdf->writeHTML('<div style="text-align: center"><h1>'.$page_name.'</h1></div>');
                $pdf->writeHTML('<div style="text-align: right">訂單編號： '.$Order->order_id.'</div>');
                $pdf->writeHTML('<div style="text-align: right">收件人： '.$Order->buyer_name.'</div>');
                $pdf->writeHTML('<div style="text-align: right">寄件地址： '.$Order->buyer_address.'</div>');
                $output .= '<style>
                                table,th,tr,td{ 
                                    border: 1px solid #dee2e6;    
                                    padding: 10px;   
                                }
                            </style>';
                $output .=  '<table>
                                <thead>
                                    <tr>
                                        <th>商品名稱</th>
                                        <th>規格</th>
                                        <th>單價</th>
                                        <th>數量</th>
                                        <th>總金額</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                
                                foreach($StreamingProducts as $product){
                                if($product->category == "empty"){
                                    $product->category="";
                                }
                                $output .='
                                    <tr>
                                        <td>'.$product->goods_name.'</td>
                                        <td>'.$product->category.'</td>
                                        <td>'.$product->single_price.'</td>
                                        <td>'.$product->order_num.'</td>
                                        <td>'.((int)$product->single_price)*((int)$product->order_num).'</td>
                                    </tr>
                                    ';
                                }
                                foreach($ShopProducts as $product){
                                 if($product->category == "empty"){
                                     $product->category="";
                                 }
                                 $output .='
                                     <tr>
                                         <td>'.$product->goods_name.'</td>
                                         <td>'.$product->category.'</td>
                                         <td>'.$product->goods_price.'</td>
                                         <td>'.$product->order_num.'</td>
                                         <td>'.$product->total_price.'</td>
                                     </tr>
                                     ';
                                 }
                                $output .='
                               </tbody>
    
                            </table>';
                
                   
                //输出PDF
                $pdf->writeHTML($output, true, false, true, false, '');
                $pdf->writeHTML('<div style="text-align: right">訂單產生時間： '.$Order->created_at.'</div>');
            }


            $pdf->Output('送貨單'.'.pdf', 'D');//I输出、D下载
            return redirect()->back()->with('success', '列印成功');


         }
         else
         {
            return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
         }
     }
     //更改訂單狀態
     public function StatusChange(Request $request)
     {

            $order_id = $request->input('order_id');
            $status = $request->input('status');
   
            OrderDetail::where('order_id', '=', $order_id)
            ->update(['status' => (int)$status]);
   
            $status_cht = DB::table('order_detail')
            ->where('order_id', '=', $order_id)
            ->join('orderstatus_cht', 'order_detail.status', '=', 'orderstatus_cht.orderstatus_id')
            ->select('orderstatus_cht.order_status')
            ->first();
   
   
            return json_encode($status_cht, true);

            return redirect()->back()->with('success', '修改狀態成功！');


     }
     
     
     //------------------------------------------------------------------------------------------------------------

     //總PDF
     public function downloadPDF(Request $request)
     {
         $order = json_decode($request->input('pdf_order'));
         $output = '';
         $status='';
         $created_time='';
         
         foreach($order as $orderid => $collection)
         {
            $total_amount=0;
            $output .= '<hr><table >
                           <thead>
                           <tr >
                              <th colspan="4">訂單編號：'.$orderid.'</th>
                           </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td>得標者姓名</td>
                                 <td>商品名稱</td>
                                 <td>商品價錢</td>
                                 <td>商品數量</td>
                              </tr>';

            foreach($collection as $order_detail)
            {
               $output .= '<tr id="order_item" >
                              <td >'.$order_detail->name.'</td>
                              <td >'.$order_detail->goods_name.'</td>
                              <td>'.$order_detail->goods_price.'</td>
                              <td>'.$order_detail->goods_num.'</td>
                           </tr>';

               $status=$order_detail->status;
               $created_time=$order_detail->created_time;
               $total_amount+=(int)($order_detail->total_price);
            }

            $output .= ' <tr >
                           <td colspan="3">訂單成立時間：'.$created_time.'</td>
                           <td align="right" >總金額：'.$total_amount.' </td>
                         </tr>
                      </tbody>
                   </table>
                   <hr><br><br>';
         }
        



         $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
         // set document information
         $pdf->SetTitle('訂單');
         $pdf->SetHeaderData('', 20,'訂單', '');
         // set header and footer fonts
         $pdf->setHeaderFont(Array('msungstdlight', '', PDF_FONT_SIZE_MAIN));
         $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
         // set default monospaced font
         $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
         // set margins
         $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
         $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
         $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
         // set auto page breaks
         $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
         
         // set some language-dependent strings (optional)
         if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
         }
         // ---------------------------------------------------------
         // add a page
         $pdf->AddPage();

         $pdf->SetFont('msungstdlight', '', 14);

         $pdf->writeHTML($output, true, false, true, false, '');
         //$pdf->Write(0, $output, '', 0, 'L', true, 0, false, false, 0);
         // ---------------------------------------------------------
 
         return $pdf->Output('order.pdf', 'I');
     }

     //個別PDF
     public function download_pdf(Request $request)
     {
         $orderid = json_decode($request->input('order_id'));

         $page = Page::where('fb_id', Auth::user()->fb_id)->first();
         $page_id = $page->page_id;

         $query = OrderDetail::all()
         ->where('order_id', '=', $orderid);



         $output = '';
         $status='';
         $created_time='';
         $total_amount = 0;
         
         $output .= '<hr><table >
                           <thead>
                           <tr >
                              <th colspan="4">訂單編號：'.$orderid.'</th>
                           </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td>得標者姓名</td>
                                 <td>商品名稱</td>
                                 <td>商品價錢</td>
                                 <td>商品數量</td>
                              </tr>';
         foreach($query as $order )
         {
           
               $output .= '<tr>
               <td >'.$order->name.'</td>
               <td >'.$order->goods_name.'</td>
               <td>'.$order->goods_price.'</td>
               <td>'.$order->goods_num.'</td>
               </tr>';
               $created_time=$order->created_time;
               $total_amount+=(int)($order->total_price);
            
         }

         $output .= ' <tr >
                              <td colspan="3">訂單成立時間：'.$created_time.'</td>
                              <td align="right" >總金額：'.$total_amount.' </td>
                           </tr>
                        </tbody>
                     </table>
                     <hr>';

         $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
         // set document information
         $pdf->SetTitle('訂單');
         $pdf->SetHeaderData('', 20,'訂單', '');
         // set header and footer fonts
         $pdf->setHeaderFont(Array('msungstdlight', '', PDF_FONT_SIZE_MAIN));
         $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
         // set default monospaced font
         $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
         // set margins
         $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
         $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
         $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
         // set auto page breaks
         $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
         
         // set some language-dependent strings (optional)
         if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
         }
         // ---------------------------------------------------------
         // add a page
         $pdf->AddPage();

         $pdf->SetFont('msungstdlight', '', 14);

         $pdf->writeHTML($output, true, false, true, false, '');
         //$pdf->Write(0, $output, '', 0, 'L', true, 0, false, false, 0);
         // ---------------------------------------------------------
   
         return $pdf->Output('order.pdf', 'I');

     }



     //列印超商物流繳款單
     public function PrintLogisticsPaymentSlip(Request $request)
     {
        $order_id = $request->input("order_id");
        $OrderDetail = OrderDetail::where('order_id', $order_id)->first();
        $page_id = $OrderDetail->page_id;

        $PageDetail = PageDetail::where('page_id', $page_id)->first();

        $LogisticsOrder = LogisticsOrder::where('order_id', $order_id)->first();
         //統一超商，列印繳費單
         try {
             $AL = Ecpay::l();
             if($PageDetail->hashkey == null || $PageDetail->hashkey == "")
             {
                 $AL->HashKey = 'XBERn1YOvpM9nfZc'; 
             }
             else
             {
                 $AL->HashKey = $PageDetail->hashkey; 
             }
 
             if($PageDetail->hashiv == null || $PageDetail->hashiv == "")
             {
                 $AL->HashIV = 'h1ONHk4P4yqbl5LK'; 
             }
             else
             {
                 $AL->HashIV = $PageDetail->hashiv; 
             }
             $AL->Send = array(
                 'MerchantID' => $LogisticsOrder->MerchantID,  //$PageDetail->merchant_code
                 'AllPayLogisticsID' => $LogisticsOrder->AllPayLogisticsID,
                 'CVSPaymentNo' => $LogisticsOrder->CVSPaymentNo,
                 'CVSValidationNo' => $LogisticsOrder->CVSValidationNo,
                 'PlatformID' => ''
             );
             // PrintUnimartC2CBill(Button名稱, Form target)
             if($LogisticsOrder->LogisticsSubType=='UNIMARTC2C')
             {
                 $html = $AL->PrintUnimartC2CBill();  //'列印繳款單(統一超商C2C)'
                 echo $html;
             }
             if($LogisticsOrder->LogisticsSubType=='FAMIC2C')
             {
                 $html = $AL->PrintFamilyC2CBill();  //'列印繳款單(統一超商C2C)'
                 echo $html;
             }
            
         } catch(Exception $e) {
             echo $e->getMessage();
         }
     }
     
}