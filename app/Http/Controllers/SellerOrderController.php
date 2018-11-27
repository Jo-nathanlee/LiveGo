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
 
     public function SellerOrderUndelivered(Request $request)//未出貨訂單
     {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            $query = CheckoutOrder::all()
                    ->where('page_id', '=', $page_id)
                    ->where('order_status', '=', 'undelivered');
            
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
 
     public function SellerOrderDelivered(Request $request)//運送中訂單
     {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            $query = CheckoutOrder::all()
                    ->where('page_id', '=', $page_id)
                    ->where('order_status', '=', 'delivered');
            
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
 
     public function SellerOrderFinished(Request $request)//已完成訂單
     {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            $query = CheckoutOrder::all()
                    ->where('page_id', '=', $page_id)
                    ->where('order_status', '=', 'finished');

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
 
     public function SellerOrderCanceled(Request $request)//已取消訂單
     {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            $query = CheckoutOrder::all()
                    ->where('page_id', '=', $page_id)
                    ->where('order_status', '=', 'canceled');

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
     //------------------------------------------------------------------------------------------------------------

     public function downloadPDF(Request $request)
     {
         $order = json_decode($request->input('pdf_order'));
         $output = '';
         $order_status='';
         $created_time='';
         $total_amount='';
         foreach($order as $orderid => $collection)
         {
            $output .= '<table >
                           <thead>
                           <tr >
                              <th >訂單編號：'.$orderid.'</th>
                              <th></th>
                              <th></th>
                           </tr>
                           </thead>
                           <tbody>
                              <tr >
                                 <td >商品名稱</td>
                                 <td>商品價錢</td>
                                 <td>商品數量</td>
                              </tr>';

            foreach($collection as $order_detail)
            {
               $output .= '<tr id="order_item" >
                              <td >'.$order_detail->goods_name.'</td>
                              <td>'.$order_detail->goods_price.'</td>
                              <td>'.$order_detail->goods_num.'</td>
                           </tr>';

               $order_status=$order_detail->order_status;
               $created_time=$order_detail->created_time;
               $total_amount=$order_detail->total_price;
            }

            $output .= ' <tr >
                           <td >訂單成立時間：'.$created_time.'</td>
                           <td colspan="2" align="right" >總金額：'.$total_amount.' </td>
                         </tr>
                      </tbody>
                   </table>
                   <hr><br><br>';
         }
        



         $pdf = new \TCPDF();
         $pdf->SetCreator('懒人开发网');
         $pdf->SetAuthor('懒人开发网');
         $pdf->SetTitle('TCPDF示例');
         $pdf->SetSubject('TCPDF示例');
         $pdf->SetKeywords('TCPDF, PDF, PHP');
 
         // 设置页眉和页脚信息
         $pdf->SetHeaderData('tcpdf_logo.jpg', 30, 'LanRenKaiFA.com', '学会偷懒，并懒出效率！', [0, 64, 255], [0, 64, 128]);
         $pdf->setFooterData([0, 64, 0], [0, 64, 128]);
 
         // 设置页眉和页脚字体
         $pdf->setHeaderFont(['stsongstdlight', '', '10']);
         $pdf->setFooterFont(['helvetica', '', '8']);
 
         // 设置默认等宽字体
         $pdf->SetDefaultMonospacedFont('courier');
 
         // 设置间距
         $pdf->SetMargins(15, 15, 15);//页面间隔
         $pdf->SetHeaderMargin(5);//页眉top间隔
         $pdf->SetFooterMargin(10);//页脚bottom间隔
 
         // 设置分页
         $pdf->SetAutoPageBreak(true, 25);
 
         // set default font subsetting mode
         $pdf->setFontSubsetting(true);
 
         //设置字体 stsongstdlight支持中文
         $pdf->SetFont('stsongstdlight', '', 14);
 
         //第一页
         $pdf->AddPage();
         $pdf->writeHTML('<div style="text-align: center"><h1>第一页内容</h1></div>');
         $pdf->writeHTML('<p>我是第一行内容</p>');
         $pdf->writeHTML('<p style="color: red">我是第二行内容</p>');
         $pdf->writeHTML('<p>我是第三行内容</p>');
         $pdf->Ln(5);//换行符
         $pdf->writeHTML('<p><a href="http://www.lanrenkaifa.com/" title="">懒人开发网</a></p>');
 
         return $pdf->Output('t.pdf', 'I');
     }
}