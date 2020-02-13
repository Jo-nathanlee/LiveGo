<?php

namespace App\Http\Controllers;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Gate;
use DB;
use App\Entities\PageDetail;
use App\Entities\Page;
use App\Entities\StreamingOrder;
use App\Entities\StreamingProduct;
use App\Entities\Member;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use TCPDF;



class BidWinnerController extends Controller
{
    //賣家得標清單查看
    public function show(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            $page_name = $page->page_name;

            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');

            $today = date('Y-m-d');
            $tomorrow = date('Y-m-d', strtotime('+1 days'));


            $query = DB::table('streaming_order')
            ->where('streaming_order.page_id', '=', $page_id)
            ->whereBetween('streaming_order.created_time', [$start_date, $end_date])
            ->join('streaming_product', 'streaming_order.product_id', '=', 'streaming_product.product_id')
            ->join('member', 'streaming_order.fb_id', '=', 'member.fb_id')
            ->where('member.page_id', '=', $page_id)
            ->select('streaming_product.*','streaming_order.id','streaming_order.created_time', 'streaming_order.goods_num as order_num','streaming_order.single_price','streaming_order.comment','member.fb_name','member.fb_id')
            ->get();

            $query2 = DB::table('streaming_order')
            ->where('streaming_order.page_id', '=', $page_id)
            ->whereBetween('streaming_order.created_time', [$today, $tomorrow])
            ->join('streaming_product', 'streaming_order.product_id', '=', 'streaming_product.product_id')
            ->join('member', 'streaming_order.fb_id', '=', 'member.fb_id')
            ->where('member.page_id', '=', $page_id)
            ->select('streaming_product.*','streaming_order.id','streaming_order.created_time','streaming_order.goods_num as order_num','streaming_order.single_price','streaming_order.comment','member.fb_name','member.fb_id')
            ->get();

            //如果是新賣家，新增一筆假資料
            // if(count($query2) == 0) {
            //     $deadline_time = 24;
            //     $fb_id = '100691261074116';
            //     $random_num=rand(100,999);

            //     $page_store = new StreamingOrder();
            //     $page_store->page_id = $page_id;
            //     $page_store->fb_id = $fb_id;
            //     $page_store->live_video_id = '22358992533898895';
            //     $page_store->goods_num =  1;
            //     $page_store->single_price =  '900';
            //     $page_store->product_id =  1;
            //     $page_store->comment = '+1';
            //     $page_store->created_time =  date("Y-m-d H:i:s");
            //     $page_store->deadline =  date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s") . ' +'.(string)($deadline_time).' hours'));
            //     $page_store->uid = $fb_id.time().$random_num;
            //     $page_store->save();
            // }

          

            $member = Member::where('page_id', '=', $page_id)
                            ->where('is_block', '=', '正常')
                            ->get();

            $streaming_product = StreamingProduct::where('page_id', '=', $page_id)
                                                ->where('goods_num', '>', 0)
                                                ->where('is_active', '=', 'true')
                                                ->get();


            if( isset($start_date) && isset($end_date) && $start_date != $end_date){
                return view('bid_winner', ['page_id'=>$page_id ,'page_token'=>$page->page_token , 'winner' => $query, 'member' => $member, 'streaming_product' => $streaming_product])->with('start_date_PDF', $start_date)->with('end_date_PDF', $end_date);
            }
            else{
                return view('bid_winner', ['page_id'=>$page_id , 'page_token'=>$page->page_token ,'winner' => $query2, 'member' => $member, 'streaming_product' => $streaming_product])->with('start_date_PDF', $today)->with('end_date_PDF', $tomorrow);
            }
        }
        else
        {
            return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
    }
    //列印bid_winner_PDF
    public function BidWinner_PDF(Request $request)
    {
        

        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;

        $start_date=$request->input('start_date_PDF');
        $end_date = $request->input('end_date_PDF');

        if (isset($start_date) && isset($end_date)) {
            $query = DB::table('streaming_order')
               ->where('streaming_order.page_id', '=', $page_id)
               ->whereBetween('created_time', [$start_date, $end_date])
               ->join('streaming_product', 'streaming_order.product_id', '=', 'streaming_product.product_id')
               ->join('member', 'streaming_order.fb_id', '=', 'member.fb_id')
               ->where('member.page_id', '=', $page_id)
               ->select('streaming_product.*', 'member.fb_name', 'streaming_order.goods_num as order_num','streaming_order.single_price','streaming_order.comment','streaming_order.created_time')
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

            //设置字体 stsongstdlight支持中文
            
            $pdf->AddPage();
            $pdf->SetFont('msungstdlight', '', 14);
            $pdf->writeHTML('<div style="text-align: center"><h1>得標者清單</h1></div>');
            $pdf->writeHTML('<div style="text-align: center"><h2>'.$start_date.'到'.$end_date.'</h2></div>');
            $output .= '<style>
                            table,th,tr,td{ 
                                border: 1px solid #dee2e6;    
                                padding: 10px;   
                            }
                        </style>';
            $output .=  '<table>
                            <thead>
                                <tr>
                                    <th>得標者姓名</th>
                                    <th>商品名稱</th>
                                    <th>得標金額</th>
                                    <th>得標數量</th>
                                    <th>得標總價</th>
                                    <th>留言內容</th>
                                    <th>得標時間</th>
                                </tr>
                            </thead>
                            <tbody>';
                            foreach($query as $product){
                            $output .='
                                <tr>
                                    <td>'.$product->fb_name.'</td>
                                    <td>'.$product->goods_name.'</td>
                                    <td>'.$product->single_price.'</td>
                                    <td>'.$product->order_num.'</td>
                                    <td>'.(int)$product->single_price*(int)$product->order_num.'</td>
                                    <td>'.$product->comment.'</td>
                                    <td>'.$product->created_time.'</td>
                                </tr>
                                ';
                            }
                            $output .='
                           </tbody>

                        </table>';
            
               
            //输出PDF
            $pdf->writeHTML($output, true, false, true, false, '');
            $pdf->Output('得標者清單-'.$start_date.'-'.$end_date.'.pdf', 'D');//I输出、D下载
            return redirect()->back()->with('success', '列印成功');
        }
        else
        {
            return redirect()->back()->with('fail', '日期未設置!');
        }
    }

    //黑名單
    public function Blacklist(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            $page_name = $page->page_name;

            $query = Member::where('page_id', '=', $page_id)
            ->get();

            //如果是新賣家，新增一筆假資料
            if(count($query) == 0){
                $query = Member::where('page_id', '=', '00000000')
                ->get();
                // $data = array(
                //     array('page_id' => $page_id, 'fb_id' => 321923508505733, 'fb_name' =>'LiveGo', 'page_name' => $page_name, 'bid_times' => 1 , 'checkout_times' => 1 , 'blacklist_times'=> 1 , 'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s"),'money_spent'=>0,'is_block'=>'正常')
                // );
                // DB::table('member')->insert($data);
            }
            

            return view('blacklist', ['blacklist' => $query , 'page_token' =>  $page->page_token]);
        }
        else
        {
            return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
    }

    public function Blacklist_detail(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;

            $fb_id = $request->input('key');
            $member = Member::where('fb_id','=',$fb_id)
            ->where('page_id', '=', $page_id)
            ->first();

            $query = DB::table('streaming_order')
            ->where('streaming_order.page_id', '=', $page_id)
            ->where('fb_id', '=', $fb_id)
            ->where('if_valid', '=', 'N')
            ->join('streaming_product', 'streaming_order.product_id', '=', 'streaming_product.product_id')
            ->select('streaming_product.*', 'streaming_order.goods_num as order_num','streaming_order.single_price','streaming_order.order_id','streaming_order.created_time')
            ->get();

            $streaming_order_count = DB::table('streaming_order')
            ->where('streaming_order.page_id', '=', $page_id)
            ->where('fb_id', '=', $fb_id)
            ->count();
            

            return view('blacklist_detail', ['Order' => $query  , 'member' =>  $member , 'streaming_order_count' =>  $streaming_order_count, 'page_token' => $page->page_token]);
        }
        else
        {
            return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
    }
    //判斷黑名單
    public function Blacklist_check(Request $request)
    {
        $time_now = date("Y-m-d H:i:s");
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;

        //結帳但未付款之棄標者
        $order = DB::table('streaming_order')
        ->where('streaming_order.page_id', '=', $page_id)
        ->where('streaming_order.deadline', '<',$time_now)
        ->join('order_detail', 'streaming_order.order_id', '=', 'order_detail.order_id')
        ->where('order_detail.status', '=', 11)
        ->select('streaming_order.*', 'order_detail.status')
        ->get();
        
        foreach($order as $order)
        {
            $member_list_psid = Member::where('fb_id','=',$order->fb_id)->where('page_id','=',$page_id)->first();   
            $member_list_asid = Member::where('as_id','=',$order->fb_id)->where('page_id','=',$page_id)->first();     

            if($member_list_psid!=null)
            {
                $member_list_psid->increment('blacklist_times');
            }
            if($member_list_asid!=null)
            {
                $member_list_asid->increment('blacklist_times');
            }
        }

        $order = DB::table('streaming_order')
        ->where('streaming_order.page_id', '=', $page_id)
        ->where('streaming_order.deadline', '<',$time_now)
        ->join('order_detail', 'streaming_order.order_id', '=', 'order_detail.order_id')
        ->where('order_detail.status', '=', 11)
        ->update(['streaming_order.if_valid' => 'N','streaming_order.deadline' => null,'order_detail.status' => 15]);



        $query = StreamingOrder::where('page_id', '=', $page_id)
        ->whereNull('order_id')
        ->where('deadline', '<',$time_now)
        ->get();


        foreach($query as $blacklist)
        {
            $member_list_psid = Member::where('fb_id','=',$blacklist->fb_id)->where('page_id','=',$page_id)->first();   
            $member_list_asid = Member::where('as_id','=',$blacklist->fb_id)->where('page_id','=',$page_id)->first();     

            if($member_list_psid!=null)
            {
                $member_list_psid->increment('blacklist_times');
            }
            if($member_list_asid!=null)
            {
                $member_list_asid->increment('blacklist_times');
            }
        }

        //尚未點選結帳之棄標者
        StreamingOrder::where('page_id', '=', $page_id)
        ->whereNull('order_id')
        ->where('deadline', '<',$time_now)
        ->update(['if_valid' => 'N','deadline' => null]);

        return 'true';
    }

    
    //棄標時間設定
    public function Blacklist_time(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;

            $blacklist_time = PageDetail::where('page_id', '=', $page_id)
            ->first();


            return view('set_blacklist_time', ['hours' => $blacklist_time->deadline_time]);
        }
        else
        {
            return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
    }

    public function Set_BlacklistTime(Request $request)
    {
        $hours =  $request->input('hours');

        
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;

        DB::table('page_detail')
        ->where('page_id', '=', $page_id)
        ->update(['deadline_time' => $hours]);

        return redirect()->back()->with('success', '棄標時間修改成功!');
    }

    //是否為黑名單
    public function Set_Block_State(Request $request)
    {
        $fb_id = $request->input('fb_id');
        $is_block = $request->input('is_block');

        $sql = Member::where('fb_id', '=', $fb_id)
        ->update(['is_block' => $is_block]);



        return json_encode($sql, true);

        return redirect()->back()->with('success', '狀態更改成功');
    }
    
    //得標者刪除
    public function Delete_Bid_winner(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;

            $id=$request->input('id');
            $product_id = $request->input('product_id');
            //加回已賣出商品數量
            $streaming_order = StreamingOrder::where('id', '=', $id)->first();
            $goods_num = $streaming_order->goods_num;

            
            StreamingProduct::where('product_id', '=', $product_id)->where('page_id', '=', $page_id)->increment('goods_num',$goods_num);

            //刪除得標者
            $delete = StreamingOrder::where('id', '=', $id)->delete();

            return json_encode($delete, true);
        }
        else
        {
           return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
    }

    //新增得標者
    public function Create_Bid_winner(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            try {

                $page = Page::where('fb_id', Auth::user()->fb_id)->first();
                $page_id = $page->page_id;
                $page_name = $page->page_name;

                $blacklist_time = PageDetail::where('page_id', '=', $page_id)->first();

                $fb_id=$request->input("fb_id");
                $goods_name=$request->input("goods_name");
                $goods_price=$request->input("goods_price");
                $goods_num=$request->input("goods_num");
                $product_id=$request->input("product_id");
                $category=$request->input("category");

                $streaming_product = StreamingProduct::where('page_id', '=', $page_id)
                ->where('product_id','=',$product_id)
                ->first();

                if($streaming_product->goods_num < $goods_num){
                    return redirect('/')->with('fail', '商品數量不足，至多新增至'.$streaming_product->goods_num.'個');
                }else{
                
                    //產生uid
                    $time_stamp=time();
                    $random_num=rand(100,999);
                    $uid=$fb_id.time().$random_num;


                    //存入資料庫
                    $NewOrder = new StreamingOrder();
                    $NewOrder->page_id = $page_id;
                    $NewOrder->fb_id = $fb_id;
                    $NewOrder->product_id = $product_id;
                    $NewOrder->goods_num =  $goods_num;
                    $NewOrder->comment = "由賣家新增";
                    $NewOrder->single_price = $goods_price;
                    $NewOrder->uid = $uid;
                    $NewOrder->created_time = date("Y-m-d H:i:s");
                    $NewOrder->deadline = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s") . ' +'.(string)($blacklist_time->deadline_time).' hours'));
                    $NewOrder->save();
                    
                    $now = (string)date("Y-m-d H:i:s");
                    $max_id = StreamingOrder::max('id');
                    
                    $result = array($now, $max_id);

                    //扣掉直播商品數量
                    if($category == ""){
                        StreamingProduct::where('product_id', '=', $product_id)->where('page_id', '=', $page_id)->decrement('goods_num',$goods_num);
                        // //修改已銷售商品數量
                        // StreamingProduct::where('pic_url', '=', $pic_url)->where('page_id', '=', $page_id)->increment('selling_num',$goods_num);
        
                    }else{
                        StreamingProduct::where('product_id', '=', $product_id)->where('page_id', '=', $page_id)->where('category', '=', $category)->decrement('goods_num',$goods_num);
                        // //修改已銷售商品數量
                        // StreamingProduct::where('pic_url', '=', $pic_url)->where('page_id', '=', $page_id)->where('category', '=', $category)->increment('selling_num',$goods_num);
        
                    }

                    return json_encode($result, true);
                }
                
            }
            catch (\Exception $e) {
                
            }
        }
        else
        {
            return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
    }

    //修改得標者
    public function Edit_Bid_winner(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            try {

                $page = Page::where('fb_id', Auth::user()->fb_id)->first();
                $page_id = $page->page_id;

                $id = $request->input("id");
                $goods_num = $request->input("goods_num");
                $product_id = $request->input("product_id");
                $original_num = $request->input("original_num");

              

                $streaming_product = StreamingProduct::where('page_id', '=', $page_id)->where('product_id', '=', $product_id)->first();
                $storage = $streaming_product->goods_num;

                $count = (int)$storage ;
                $goodsincrease = (int)$goods_num - (int)$original_num;
                $goodsdecrease = (int)$original_num - (int)$goods_num ; 

                //如果後來新增等於原本數量
                if((int)$goods_num  == (int)$original_num){
                    return json_encode($streaming_product, true);
                }
                elseif ($goodsincrease > 0)   //商品修改為新增
                {
                    //如果資料庫商品數量大於新增數量
                   if($goodsincrease<=(int)$storage)
                   {
                        $sql = StreamingOrder::where('page_id', '=', $page_id)
                        ->where('id', '=', $id)
                        ->update(array(
                            'goods_num'=>$goods_num,
                        ));

                        StreamingProduct::where('page_id', '=', $page_id)
                        ->where('product_id', '=', $product_id)
                        ->decrement('goods_num',$goodsincrease);
                        return json_encode($streaming_product, true);
                   }
                }
                else //商品修改為減少
                {
                    $sql = StreamingOrder::where('page_id', '=', $page_id)
                    ->where('id', '=', $id)
                    ->update(array(
                        'goods_num'=>$goods_num,
                    ));
                    StreamingProduct::where('page_id', '=', $page_id)
                    ->where('product_id', '=', $product_id)
                    ->increment('goods_num',$goodsdecrease);
                    return json_encode($streaming_product, true);
                }

                
                
                
            }
            catch (\Exception $e) {
                
            }
        }
        else
        {
            return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
    }

    public function Get_Member_data(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
    
            $fb_id = $request->input('fb_id');

            $sql = Member::where('page_id', '=', $page_id)->where('fb_id', '=', $fb_id)->first();
    
            return json_encode($sql, true);
        }
        else
        {
            return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }

       
    }

    public function Get_Goods_data(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
    
            $product_id = $request->input('pid');

            $sql = StreamingProduct::where('page_id', '=', $page_id)->where('product_id', '=', $product_id)->first();

            return json_encode($sql, true);
        }
        else
        {
            return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }

        
    }

    
}