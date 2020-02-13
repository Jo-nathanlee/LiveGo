<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use App\Entities\OrderDetail;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Entities\Page;
use App\Entities\PageDetail;
use TCPDF;
use PhpImap\ConnectionException;
class RevenueController extends Controller
{
    public function DailyRevenue(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;

            $amount = array();
            $date = array();
            $Now = (int)date("d");
            $Now = $Now-1;
            $total = 0;
            for($i = 0; $i<=$Now ; $i++ ){
                $total = 0;
                $dateday = (string)(date('Y-m-d', strtotime('-'.$i.' days')));
                $date_query = OrderDetail::where('transaction_date', 'like', '%'.$dateday.'%')
                ->where('page_id', '=', $page_id) 
                ->where('status', '=', 'finished')
                ->get();
                
                foreach ($date_query as $order) {
                    $total += (int)($order->goods_total);
                }

                array_push($date, $dateday);
                array_push($amount, $total);
                
            }

            // $date1 = (string)(date('Y-m-d', strtotime('-7 days')));
            // $date2 = (string)(date('Y-m-d', strtotime('-6 days')));
            // $date3 = (string)(date('Y-m-d', strtotime('-5 days')));
            // $date4 = (string)(date('Y-m-d', strtotime('-4 days')));
            // $date5 = (string)(date('Y-m-d', strtotime('-3 days')));
            // $date6 = (string)(date('Y-m-d', strtotime('-2 days')));
            // $date7 = (string)(date('Y-m-d', strtotime('-1 days')));

            // $date1_query = OrderDetail::where('transaction_date', 'like', '%'.$date1.'%')
            // ->where('status', '=', 'finished')
            // ->get();
            // $date2_query = OrderDetail::where('transaction_date', 'like', '%'.$date2.'%')
            // ->where('status', '=', 'finished')
            // ->get();
            // $date3_query = OrderDetail::where('transaction_date', 'like', '%'.$date3.'%')
            // ->where('status', '=', 'finished')
            // ->get();
            // $date4_query = OrderDetail::where('transaction_date', 'like', '%'.$date4.'%')
            // ->where('status', '=', 'finished')
            // ->get();
            // $date5_query = OrderDetail::where('transaction_date', 'like', '%'.$date5.'%')
            // ->where('status', '=', 'finished')
            // ->get();
            // $date6_query = OrderDetail::where('transaction_date', 'like', '%'.$date6.'%')
            // ->where('status', '=', 'finished')
            // ->get();
            // $date7_query = OrderDetail::where('transaction_date', 'like', '%'.$date7.'%')
            // ->where('status', '=', 'finished')
            // ->get();


            // $date1_amount = 0;
            // $date2_amount = 0;
            // $date3_amount = 0;
            // $date4_amount = 0;
            // $date5_amount = 0;
            // $date6_amount = 0;
            // $date7_amount = 0;

            // foreach ($date1_query as $order) {
            //     $date1_amount += (int)($order->goods_total);
            // }
            // foreach ($date2_query as $order) {
            //     $date2_amount += (int)($order->goods_total);
            // }
            // foreach ($date3_query as $order) {
            //     $date3_amount += (int)($order->goods_total);
            // }
            // foreach ($date4_query as $order) {
            //     $date4_amount += (int)($order->goods_total);
            // }
            // foreach ($date5_query as $order) {
            //     $date5_amount += (int)($order->goods_total);
            // }
            // foreach ($date6_query as $order) {
            //     $date6_amount += (int)($order->goods_total);
            // }
            // foreach ($date7_query as $order) {
            //     $date7_amount += (int)($order->goods_total);
            // }

            // $amount = array();
            // $date = array();

            // for($i=1;$i<8;$i++)
            // {
            //     $temp2="date".(string)$i."_amount";
            //     $temp="date".(string)$i;
            //     array_push($date, $$temp);
            //     array_push($amount, $$temp2);
            // }

    

            return view('daily_revenue', ['date' => $date,'amount' => $amount]);
        }   
        else
        {
           return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
        
        

    }

    public function MonthlyRevenue(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            $month1 = date('Y-m', strtotime('-7 months'));
            $month2 = date('Y-m', strtotime('-6 months'));
            $month3 = date('Y-m', strtotime('-5 months'));
            $month4 = date('Y-m', strtotime('-4 months'));
            $month5 = date('Y-m', strtotime('-3 months'));
            $month6 = date('Y-m', strtotime('-2 months'));
            $month7 = date('Y-m', strtotime('-1 months'));

            $month1_query = OrderDetail::where('transaction_date', 'like', '%'.$month1.'%')
            ->where('status', '=', 'finished')
            ->where('page_id', '=', $page_id) 
            ->get();
            $month2_query = OrderDetail::where('transaction_date', 'like', '%'.$month2.'%')
            ->where('status', '=', 'finished')
            ->where('page_id', '=', $page_id) 
            ->get();
            $month3_query = OrderDetail::where('transaction_date', 'like', '%'.$month3.'%')
            ->where('status', '=', 'finished')
            ->where('page_id', '=', $page_id) 
            ->get();
            $month4_query = OrderDetail::where('transaction_date', 'like', '%'.$month4.'%')
            ->where('status', '=', 'finished')
            ->where('page_id', '=', $page_id) 
            ->get();
            $month5_query = OrderDetail::where('transaction_date', 'like', '%'.$month5.'%')
            ->where('status', '=', 'finished')
            ->where('page_id', '=', $page_id) 
            ->get();
            $month6_query = OrderDetail::where('transaction_date', 'like', '%'.$month6.'%')
            ->where('status', '=', 'finished')
            ->where('page_id', '=', $page_id) 
            ->get();
            $month7_query = OrderDetail::where('transaction_date', 'like', '%'.$month7.'%')
            ->where('status', '=', 'finished')
            ->where('page_id', '=', $page_id) 
            ->get();

            $month1_amount = 0;
            $month2_amount = 0;
            $month3_amount = 0;
            $month4_amount = 0;
            $month5_amount = 0;
            $month6_amount = 0;
            $month7_amount = 0;

            foreach ($month1_query as $order) {
                $month1_amount += (int)($order->goods_total);
            }
            foreach ($month2_query as $order) {
                $month2_amount += (int)($order->goods_total);
            }
            foreach ($month3_query as $order) {
                $month3_amount += (int)($order->goods_total);
            }
            foreach ($month4_query as $order) {
                $month4_amount += (int)($order->goods_total);
            }
            foreach ($month5_query as $order) {
                $month5_amount += (int)($order->goods_total);
            }
            foreach ($month6_query as $order) {
                $month6_amount += (int)($order->goods_total);
            }
            foreach ($month7_query as $order) {
                $month7_amount += (int)($order->goods_total);
            }

            $amount = array();
            $month = array();

            for($i=1;$i<8;$i++)
            {
                $temp2="month".(string)$i."_amount";
                $temp="month".(string)$i;
                array_push($month, $$temp);
                array_push($amount, $$temp2);
            }
            return view('monthly_revenue', ['month' => $month,'amount' => $amount]);



            
        }
        else
        {
           return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
    }


    public function DailyRevenue_PDF(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {

            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            $output = '';
            $count_all = 0;

            $date=$request->input('key');
            $group_name = OrderDetail::where('page_id', '=', $page_id)
                    ->first();

            $query = OrderDetail::where('transaction_date', 'like' , '%'.$date.'%')
                    ->where('page_id', '=', $page_id) 
                    ->where('status', '=', 'finished')
                    ->orderBy("transaction_date", 'desc')
                    ->get();



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

            //设置字体 stsongstdlight支持中文
            
            $pdf->AddPage();
            $pdf->SetFont('msungstdlight', '', 14);
            $pdf->writeHTML('<div style="text-align: center"><h1>'.$group_name->page_name.'</h1></div>');
            $pdf->writeHTML('<div style="text-align: center"><h2>'.$date.'</h2></div>');
            $output .= '<style>
                            table,th,tr,td{ 
                                border: 1px solid #dee2e6;    
                                padding: 10px;
                                
                            }
                            div{
                                font-size: 15px;
                                text-align: right;
                                padding: 15px;
                            }
                        </style>';
            $output .=  '<table>
                            <thead>
                                <tr>
                                    <th>訂單編號</th>
                                    <th>臉書名稱 / 收件人</th>
                                    <th>寄件地址</th>
                                    <th>總金額</th>
                                </tr>
                            </thead>
                            <tbody>';
                            foreach($query as $product){
                            $count_all+=$product->all_total;
                            $output .='
                                <tr>
                                    <td>'.$product->order_id.'</td>
                                    <td>'.$product->buyer_fbname.' / '.$product->buyer_name.'</td>
                                    <td>'.$product->buyer_address.'</td>
                                    <td>$ '.$product->all_total.'</td>
                                </tr>
                                ';
                            }
                            $output .='
                           </tbody>

                        </table>';
            $output .= '<div>總計：'
                            .$count_all.
                       '</div>';
            
               
            //输出PDF
            $pdf->writeHTML($output, true, false, true, false, '');
            $pdf->Output($group_name->page_name.'-'.$date.'.pdf', 'D');//I输出、D下载
            return redirect()->back()->with('success', '列印成功');
        }
        else
        {
           return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
    }


    public function MonthlyRevenue_PDF(Request $request){
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            $output = '';
            $count_all = 0;
           
            $month=$request->input('key');
            $group_name = OrderDetail::where('page_id', '=', $page_id)
                    ->first();

            $query = OrderDetail::where('transaction_date', 'like' , '%'.$month.'%')
                    ->where('page_id', '=', $page_id) 
                    ->where('status', '=', 'finished')
                    ->get();



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
            $pdf->writeHTML('<div style="text-align: center"><h1>'.$group_name.'</h1></div>');
            //设置字体 stsongstdlight支持中文
            $pdf->SetFont('msungstdlight', '', 14);
            $pdf->AddPage();
            $output .= '<style>
                            table,th,tr,td{ 
                                border: 1px solid #dee2e6;    
                                padding: 10px;
                                
                            }
                            div{
                                font-size: 15px;
                                text-align: right;
                                padding: 15px;
                            }
                        </style>';
            $output .=  '<table style="border: 1px solid #dee2e6 !important;" >
                            <thead>
                                <tr>
                                    <th>訂單編號</th>
                                    <th>臉書名稱 / 收件人</th>
                                    <th>寄件地址</th>
                                    <th>總金額</th>
                                    <th>日期</th>
                                </tr>
                            </thead>
                            <tbody>';
                        foreach($query as $product){
                            $count_all+=$product->all_total;
                            $count_all+=$product->all_total;
                            $output .='
                                <tr>
                                    <td>'.$product->order_id.'</td>
                                    <td>'.$product->buyer_fbname.' / '.$product->buyer_name.'</td>
                                    <td>'.$product->buyer_address.'</td>
                                    <td>$ '.$product->all_total.'</td>
                                    <td>$ '.$product->transaction_date->format('d/m/Y').'</td>
                                </tr>
                                ';
                        }
                            $output .='
                            </tbody>
                        </table>';

            $output .= '<div>總計：'
                .$count_all.
            '</div>';


            $pdf->writeHTML($output, true, false, true, false, '');
            // $pdf->writeHTML('<table>');
            //     $pdf->writeHTML('<thead>');
            //     $pdf->writeHTML('<tr>');
            //     $pdf->writeHTML('<th>訂單編號</th>');
            //     $pdf->writeHTML('<th>Facebook姓名 / 收件者姓名</th>');
            //     $pdf->writeHTML('<th>寄件地址</th>');
            //     $pdf->writeHTML('<th>運費</th>');
            //     $pdf->writeHTML('<th>總購物金額</th>');
            //     $pdf->writeHTML('<th>總付款金額</th>');
            //     $pdf->writeHTML('<th>得標日期</th>');
            //     $pdf->writeHTML('</tr>');
            //     $pdf->writeHTML('</thead>');


            //     foreach($request as $product){
            //         $pdf->writeHTML('<tr>');
            //             $pdf->writeHTML('<td>'.$product->order_id.'</td>');
            //             $pdf->writeHTML('<td>'.$product->buyer_fbname.' / '.$product->buyer_name.'</td>');
            //             $pdf->writeHTML('<td>'.$product->buyer_address.'</td>');
            //             $pdf->writeHTML('<td>'.$product->freight.'</td>');
            //             $pdf->writeHTML('<td>'.$product->goods_total.'</td>');
            //             $pdf->writeHTML('<td>'.$product->all_total.'</td>');
            //             $pdf->writeHTML('<td>'.$product->transaction_date.'</td>');
            //         $pdf->writeHTML('</tr>');
            //     }
            //     $pdf->writeHTML('<tfoot>');
            //     $pdf->writeHTML('<tr>');
            //     $pdf->writeHTML('<td style="border-bottom-style: double;">$ '.$freight_total.'</td>');
            //     $pdf->writeHTML('<td style="border-bottom-style: double;">$ '.$goods_total_total.' </td>');
            //     $pdf->writeHTML('<td style="border-bottom-style: double;">$ '.$all_total_total.'</td>');
            //     $pdf->writeHTML('<td></td>');

            //     $pdf->writeHTML('</tr>');
            //     $pdf->writeHTML('</tfoot>');
            // $pdf->writeHTML('</table>');

            //输出PDF
            $pdf->Output($group_name->page_name.'-'. $month.'.pdf', 'D');//I输出、D下载
            return redirect()->back()->with('success', '列印成功');
        }
        else
        {
           return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
    }
}
