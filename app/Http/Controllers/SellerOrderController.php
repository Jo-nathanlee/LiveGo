<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use App\Entities\Page;
use App\Entities\CheckoutOrder;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use TCPDF;



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
            $output .= '<hr><table >
                           <thead>
                           <tr >
                              <th colspan="3">訂單編號：'.$orderid.'</th>
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
                           <td colspan="2">訂單成立時間：'.$created_time.'</td>
                           <td align="right" >總金額：'.$total_amount.' </td>
                         </tr>
                      </tbody>
                   </table>
                   <hr><br><br>';
         }
        



         $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
         // set document information
         $pdf->SetTitle('訂單');
         $pdf->SetHeaderData('', 14,'訂單', '訂單');
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
 
         return $pdf->Output('t.pdf', 'I');
     }
}