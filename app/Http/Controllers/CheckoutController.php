<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use App\Entities\Page;
use App\Entities\PageDetail;
use App\Entities\OrderDetail;
use App\Entities\StramingProduct;
use App\Entities\StreamingOrder;
use App\Entities\CheckoutOrder;
use App\Entities\ShipSet;
use App\Entities\ShippingFee;
use App\Entities\Member;
use App\Entities\Prize;
use App\User;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Uploadcare;
use GuzzleHttp\Exception\ClientException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Imgur;
use Yish\Imgur\Upload;


class CheckoutController extends Controller
{
    public function psid_to_asid($ps_id,$token){
        try{
            $data = file_get_contents("https://graph.facebook.com/" . $ps_id . "?fields=ids_for_apps%7Bid%7D&access_token=" . $token);
            $data = json_decode($data, true);
            $data = $data["ids_for_apps"]["data"][0]["id"];

            return $data;
        } catch (\Exception $e) {
            return null;
        }      
    }

    public function cart_show(Request $request){
        if($request->has('page_id'))
        {
            $page_id = $request->page_id;
            $page_token = Page::where('page_id',$page_id)->select('page_token')->first();
            $page_name = Page::where('page_id',$page_id)->select('page_name')->first();
            $free_shipping = ShippingFee::where('page_id',$page_id)->first();
            $fb_id = Auth::user()->fb_id;
            $member = Member::where('as_id',$fb_id)->where('page_id',$page_id)->first();
            $ps_id = "";
            $data_as="";

            if($member!=null){
                $ps_id = $member->ps_id;

            }else{
                if($request->has('uid'))
                {
                    $psid = $request->uid;
                    $member = Member::where('ps_id',$psid)->first();
                    $fb_name = $member->fb_name;
                    if($fb_name == Auth::user()->name)
                    {
                        Member::where('ps_id', '=', $psid)->update(['as_id' => $fb_id]);
                    }
                }    
            }


            $name = Auth::user()->name;
            $total = 0;
            $bid_price=null;
            $product_id = null;
            $total_num = 0;
    
            $goods_list = [];
            $shipping_list = [];


            $page_detall = DB::table('page_detail')
            ->where('page_id',$page_id )
            ->first();

            $shipping = DB::table('shipping_fee')
            ->where('page_id',$page_id )
            ->get();

            foreach(  $shipping as  $shipping){
                $shipping_list[$shipping->ship_id] = array(
                    'fee' => $shipping->fee
                );
            }

            $order = StreamingOrder::where('streaming_order.page_id',$page_id )
            ->where('streaming_order.ps_id',$ps_id)
            ->join('streaming_product','streaming_order.product_id','streaming_product.product_id')
            ->whereNull('order_id')
            ->select('streaming_order.*','streaming_product.category','streaming_product.description','streaming_product.goods_name','streaming_product.goods_num as store_num','streaming_product.description','streaming_product.pic_url','streaming_product.goods_key','streaming_product.selling_num','streaming_product.pre_sale')
            ->orderBy('streaming_order.product_id')
            ->get();
            
    
            $prize = DB::table('prize')->where('page_id',$page_id )
            ->where('ps_id',$ps_id)
            ->whereNull('order_id')
            ->get();
    
            foreach ($order as $data){
                $total += ($data->goods_num * $data->bid_price);
                if($data->product_id == $product_id){
                    $total_num += $data->goods_num;
    
                    $goods_list[ $data->product_id ] = array(
                        'goods_name' => $data->goods_name,
                        'pic_url' => $data->pic_url,
                        'goods_key' => $data->goods_key,
                        'live_video_id' => $data->live_video_id,
                        'store_num' => $data->store_num,
                        'selling_num' => $data->selling_num,
                        'pre_sale' => $data->pre_sale,
                        'bid_price' => $data->bid_price,
                        'category' => $data->category,
                        'goods_num' =>$total_num,
                        'description' =>$data->description,
                        'product_id' => $data->product_id
                    );
                }else{
                    $product_id = $data->product_id;
                    $bid_price = $data->bid_price;
                    $total_num = $data->goods_num;
                    $goods_list[ $data->product_id ] = array(
                        'goods_name' => $data->goods_name,
                        'pic_url' => $data->pic_url,
                        'goods_key' => $data->goods_key,
                        'live_video_id' => $data->live_video_id,
                        'store_num' => $data->store_num,
                        'selling_num' => $data->selling_num,
                        'pre_sale' => $data->pre_sale,
                        'bid_price' => $data->bid_price,
                        'category' => $data->category,
                        'goods_num' =>$data->goods_num,
                        'description' =>$data->description,
                        'product_id' => $data->product_id
                    );
                }
    
            }

            return view('cart',['shipping'=>$shipping_list ,'free_shipping' =>$free_shipping['free_shipping'] , 'page_detall' =>$page_detall , 'orders'=> $goods_list ,'prize' => $prize , 'page_id' =>$page_id ,'ps_id' =>  $ps_id  ,'name' =>$name,'page_name' => $page_name]);
        }
        else
        {
            return redirect('/buyer_home');
        }
    }
    public function shop_show(Request $request){
        $page_id = $request->page_id;
        $fb_id = Auth::user()->fb_id;
        $ps_id = Auth::user()->ps_id;
        $name = Auth::user()->name;
        return view('shop',[ 'page_id' =>$page_id ,'fb_id' =>  $fb_id ,'name' =>$name]);
    }
     //購物車頁面確認後產生訂單
     public function Checkout(Request $request)
     {
         //買家填寫之資訊
         $address=$request->address;
         $phone=$request->phone;
         $note=$request->note;
         $buyer_name=Auth::user()->name;
         $freight_type=$request->freight_type;
         $receiver_name=$request->receiver_name;
         $bankcode=$request->bankcode;
         $goods_num=$request->goodsnum;
         $goods_total=$request->goods_total;
         $ps_id=$request->ps_id;
         $page_id=$request->page_id;
         $delivery_type=$request->delivery_type;
         $payment_type=$request->payment_type;
        
        $freight_type = DB::table('shipping_fee')
        ->where('page_id',$page_id)
        ->where('ship_id',$freight_type)
        ->first();

         //產生訂單號碼
         $time_stamp=time();
         $random_num=rand(10,99);
         $order_id=$time_stamp.$random_num.substr($ps_id,0,8);
 
 
         $selectedOrderProduct=$request->selectedOrderProduct;
         if($selectedOrderProduct!=null)
         {
             $i=0;
            foreach($selectedOrderProduct as $product_id){
                $data = explode("&",$product_id);
                $update_StreamingOrder_OrderId = StreamingOrder::where('product_id', '=', $data[0])
                ->whereNull('order_id')->update(['order_id' => $order_id]);


                DB::table('streaming_order')->where('product_id', '=', $data[0])->where('order_id',$order_id)->update(['goods_num' => (int)$goods_num[$i]]);
                DB::table('streaming_product')->where('product_id', '=', $data[0])->decrement('goods_num', (int)$goods_num[$i]);
                DB::table('streaming_product')->where('product_id', '=', $data[0])->decrement('pre_sale', $data[1]);
                $i++;
             }
         }

         $selectedPrize=$request->selectedPrize;
         if($selectedPrize!=null)
         {
            foreach($selectedPrize as $prize_id){
                $update_Prize = Prize::where('id', '=', $prize_id)
                ->whereNull('order_id')->update(['order_id' => $order_id]);
             }
         }

         DB::table('member')
         ->where('page_id',$page_id)
         ->where('ps_id',$ps_id)
         ->update(['checkout_times' =>  DB::raw('checkout_times + 1'),
                   'money_spent' =>  DB::raw('money_spent + '.$goods_total)]);

         $member = Member::where('page_id',$page_id)
         ->where('ps_id',$ps_id)
         ->first();

         if($member->money_spent > 1000000)
         {
             $update = DB::table('member')
             ->where('ps_id',$ps_id)
             ->where('page_id',$page_id)
             ->update(['member_type' => 4]);
         }
         if($member->money_spent > 100000 && $member->money_spent < 1000000)
         {
             $update = DB::table('member')
             ->where('ps_id',$ps_id)
             ->where('page_id',$page_id)
             ->update(['member_type' => 3]);
         }
         if($member->money_spent > 10000 && $member->money_spent < 100000)
         {
             $update = DB::table('member')
             ->where('ps_id',$ps_id)
             ->where('page_id',$page_id)
             ->update(['member_type' => 2]);            
         } 
         

         //insert DB
         $OrderDetail = new OrderDetail();
         $OrderDetail->page_id = $page_id;
         $OrderDetail->ps_id = $ps_id;
         $OrderDetail->receiver_name = $receiver_name;
         $OrderDetail->order_id = $order_id;
         $OrderDetail->status = 11;
         $OrderDetail->goods_total = (int)$goods_total;
         $OrderDetail->buyer_bankcode = $bankcode;
         $OrderDetail->freight = (int)$freight_type->fee;
         $OrderDetail->address = $address;
         $OrderDetail->cellphone = $phone;
         $OrderDetail->delivery_type = $delivery_type;
         $OrderDetail->pay_id = $payment_type;
         $OrderDetail->note = $note;
         $OrderDetail->save();



         $request->session()->put('success', '成功成立訂單！如繳費請主動告知粉絲團，以便出貨流程！');
         return json_encode('success',true);
     }

    // public function CheckOutOld(Request $request)
    // {
    //     //買家填寫之資訊
    //     $address=$request->address;
    //     $phone=$request->phone;
    //     $note=$request->note;
    //     $buyer_fbname=$request->buyer_fbname;
    //     $freight=$request->freight;
    //     $buyer_name=$request->buyer_name;
    //     $goods_total=$request->goods_total;
    //     $TotalAmount=$request->all_total;

    //     date_default_timezone_set("Asia/Taipei");
    //     $MerchantTradeDate=date('Y/m/d H:i:s');
    //     $input_gooods=json_decode($request->input('goods'));

    //     //取得fb_id
    //     $arr_goods=json_decode($request->input('goods'));
    //     $temp=preg_split("/[,]+/", $arr_goods[0]);
    //     $fb_id=$temp[1];

    //     //產生訂單號碼
    //     $time_stamp=time();
    //     $random_num=rand(10,99);
    //     $order_id=$time_stamp.$random_num.substr($fb_id,0,8);

    //     //基本參數(請依系統規劃自行調整)
    //     Ecpay::i()->Send['ReturnURL'] = "https://livego.com.tw/OrderResult";
    //     Ecpay::i()->Send['OrderResultURL'] = "https://livego.com.tw/OrderResult" ;
    //     // Ecpay::i()->Send['ClientBackURL'] = "https://livego.com.tw/ecpayCheckoutCellphone"; //交易描述
    //     Ecpay::i()->Send['MerchantTradeNo'] =$order_id; //訂單編號
    //     Ecpay::i()->Send['MerchantTradeDate'] =$MerchantTradeDate; //交易時間
    //     Ecpay::i()->Send['TotalAmount'] = $TotalAmount; //交易金額
    //     Ecpay::i()->Send['TradeDesc'] = 'LIVE GO'; //交易描述
    //     Ecpay::i()->Send['ChoosePayment'] = \ECPay_PaymentMethod::Credit; //付款方式

    //     //產生訂單----------------------------------------------------------------------------------------
    //     $item=1;
    //     $order_time;
    //     $page_id='';
    //     $fb_id='';
    //     $page_name='';

    //     Session::put('InputGoods', $input_gooods);


    //     foreach($input_gooods as $goods){
    //         $values = preg_split("/[,]+/", $goods);
    //         $page_name=$values[0];
    //         $fb_id=$values[1];
    //         $name=$values[2];
    //         $goods_name=$values[3];
    //         $goods_price=$values[4];
    //         $goods_num=$values[5];
    //         $total_price=$values[6];
    //         $page_id=$values[7];
    //         $uid=$values[8];
    //         $pic_url=$values[9];
    //         $category=$values[10];
    //         $product_id=$values[11];
    //         ShopProduct::where('product_id', '=', $product_id)->where('page_id', '=', $page_id)->decrement('goods_num',$goods_num);
    //         //產生訂單編號
    //         if($item==1)
    //         {
    //             // $time_stamp=time();
    //             // $random_num=rand(10,99);
    //             // $order_id=$time_stamp.$random_num.substr($fb_id,0,8);
    //             $order_time=date("Y-m-d H:i:s");
    //         }
    //         if($category!="empty"){
    //             array_push(Ecpay::i()->Send['Items'], array('Name' =>  $goods_name.'，'.$category, 'Price' => (int) ( $goods_price),
    //             'Currency' => "元", 'Quantity' => (int) ( $goods_num), 'URL' => "dedwed"));

    //         }else{
    //             array_push(Ecpay::i()->Send['Items'], array('Name' =>  $goods_name, 'Price' => (int) ( $goods_price),
    //             'Currency' => "元", 'Quantity' => (int) ( $goods_num), 'URL' => "dedwed"));

    //         }

    //         //檢查商品是否售完
    //         // if($category==""){
    //             $if_sold_out = ShopProduct::where('product_id','=',$product_id)
    //                 ->where('page_','=',$page_id)
    //                 ->first();

    //             // $if_sold_out_stream = StreamingProduct::where('pic_url','=',$pic_url)
    //             //     ->where('page_id','=',$page_id)
    //             //     ->where('goods_num','=',0)
    //             //     ->first();
    //         // }else{
    //         //     $if_sold_out = Shop::where('pic_url','=',$pic_url)
    //         //     ->where('page_id','=',$page_id)
    //         //     ->where('category','=',$category)
    //         //     ->first();
    //         // }


    //         if($if_sold_out != null AND $if_sold_out->goods_num<=0){
    //             return redirect('/buyer_index?page_id='.$page_id)->with('fail', '結帳失敗!。<br>'.$if_sold_out->goods_num.'<small>QQ商品庫存不足！。</small>');
    //         }
    //         Session::put('OrderID', $order_id);
    //         $CheckoutOrder_store = new CheckoutOrder();
    //         $CheckoutOrder_store->page_id = $page_id;
    //         $CheckoutOrder_store->page_name = $page_name;
    //         $CheckoutOrder_store->order_id = $order_id;
    //         $CheckoutOrder_store->fb_id = $fb_id;
    //         $CheckoutOrder_store->name = $name;
    //         $CheckoutOrder_store->goods_name = $goods_name;
    //         $CheckoutOrder_store->goods_price = $goods_price;
    //         $CheckoutOrder_store->goods_num = $goods_num;
    //         $CheckoutOrder_store->total_price = $total_price;
    //         $CheckoutOrder_store->pic_path = $pic_url;
    //         $CheckoutOrder_store->category = $category;
    //         //$CheckoutOrder_store->order_status = 'unpaid';
    //         $CheckoutOrder_store->created_time = $order_time;
    //         $CheckoutOrder_store->save();

    //         $update_StreamingOrder_OrderId = StreamingOrder::where('uid', '=', $uid)->update(['order_id' => $order_id]);
    //         $update_ShopOrder_OrderId = ShopOrder::where('uid', '=', $uid)->update(['order_id' => $order_id]);

    //         //修改剩餘商品數量
    //         //Shop::where('pic_url', '=', $pic_url)->where('page_id', '=', $page_id)->decrement('goods_num',$goods_num);
    //         //修改已銷售商品數量
    //         //Shop::where('pic_url', '=', $pic_url)->where('page_id', '=', $page_id)->increment('selling_num',$goods_num);

    //         $item++;
    //     }
    //         //--------------------------------------------------------------------------------------------------------------
    //     //insert DB
    //     $OrderDetail = new OrderDetail();
    //     $OrderDetail->page_id = $page_id;
    //     $OrderDetail->page_name = $page_name;
    //     $OrderDetail->buyer_fbid = $fb_id;
    //     $OrderDetail->buyer_fbname = $buyer_fbname;
    //     $OrderDetail->buyer_name = $buyer_name;
    //     $OrderDetail->order_id = $order_id;
    //     $OrderDetail->transaction_date = $MerchantTradeDate;
    //     $OrderDetail->status = 'unpaid';
    //     $OrderDetail->goods_total = $goods_total;
    //     $OrderDetail->all_total = $TotalAmount;
    //     $OrderDetail->freight = $freight;
    //     $OrderDetail->buyer_address = $address;
    //     $OrderDetail->buyer_phone = $phone;
    //     $OrderDetail->note = $note;
    //     $OrderDetail->save();

    //     //Go to EcPay
    //     echo "緑界頁面導向中...";
    //     echo Ecpay::i()->CheckOutString();
    // }

    //  //結帳頁面讀取(填寫資料)
    //  public function CheckoutForm(Request $request)
    //  {

    //         if($request->has('goods_streaming')||$request->has('goods_shop')){

    //             $page_id =  $request->input('page_id');
    //             // $freight_query = Page::where('page_id','=',$page_id)
    //             //           ->first();
    //             // $freight = $freight_query->freight;
    //             $page_detal = PageDetail::where('page_id', '=', $page_id)->first();
    //             $ship_set_query =DB::table('ship_set')
    //             ->where('page_id','=',$page_id)
    //             ->where('is_active','=','true')
    //             ->join('ship_cht','ship_cht.ship_id','=','ship_set.ship_id')
    //             ->get();

    //             // if($freight==null)
    //             // {
    //             //     $frieght=0;
    //             // }

    //             if(!$request->has('goods_streaming'))
    //             {
    //                 $goods_streaming = null;
    //             }
    //             else
    //             {
    //                 $goods_streaming = $request->input('goods_streaming');
    //             }
    //             if(!$request->has('goods_shop'))
    //             {
    //                 $goods_shop = null;
    //             }
    //             else
    //             {
    //                 $goods_shop = $request->input('goods_shop');
    //             }

    //             // 'freight' => $freight,'page_id' => $page_id ,
    //             return view('checkout', ['page'=>$page_detal,'streaming_order' => $goods_streaming,'shop_order' => $goods_shop, 'ship'=>$ship_set_query , 'page_id'=>$page_id ]);
    //         }
    //         else
    //         {
    //             return redirect()->back()->with('fail', '請選擇商品進行結帳！');
    //         }



    //  }

    //  public function Transfercheckout(Request $request)
    //  {
    //     //買家填寫之資訊
    //     $address=$request->transferaddress;
    //     $phone=$request->transferphone;
    //     $note=$request->transfernote;
    //     $buyer_fbname=$request->transferbuyer_fbname;
    //     $freight=$request->transferfreight;
    //     $buyer_name=$request->transferbuyer_name;
    //     $goods_total=$request->transfergoods_total;
    //     $TotalAmount=$request->transferall_total;
    //     date_default_timezone_set("Asia/Taipei");
    //     $MerchantTradeDate=date('Y/m/d H:i:s');

    //     //取得fb_id
    //     $arr_goods=json_decode($request->input('transfergoods'));
    //     $temp=preg_split("/[,]+/", $arr_goods[0]);
    //     $fb_id=$temp[1];

    //     //產生訂單號碼
    //     $time_stamp=time();
    //     $random_num=rand(10,99);
    //     $order_id=$time_stamp.$random_num.substr($fb_id,0,8);

    //     $item=1;
    //     $order_time;
    //     $page_id='';
    //     $fb_id='';
    //     $page_name='';

    //     $input_gooods=json_decode($request->input('transfergoods'));
    //     foreach($input_gooods as $goods){
    //         $values = preg_split("/[,]+/", $goods);
    //         $page_name=$values[0];
    //         $fb_id=$values[1];
    //         $name=$values[2];
    //         $goods_name=$values[3];
    //         $goods_price=$values[4];
    //         $goods_num=$values[5];
    //         $total_price=$values[6];
    //         $page_id=$values[7];
    //         $uid=$values[8];
    //         $pic_url=$values[9];

    //         //產生訂單編號
    //         if($item==1)
    //         {
    //             // $time_stamp=time();
    //             // $random_num=rand(10,99);
    //             // $order_id=$time_stamp.$random_num.substr($fb_id,0,8);
    //             $order_time=date("Y-m-d H:i:s");
    //         }


    //         $CheckoutOrder_store = new CheckoutOrder();
    //         $CheckoutOrder_store->page_id = $page_id;
    //         $CheckoutOrder_store->page_name = $page_name;
    //         $CheckoutOrder_store->order_id = $order_id;
    //         $CheckoutOrder_store->fb_id = $fb_id;
    //         $CheckoutOrder_store->name = $name;
    //         $CheckoutOrder_store->goods_name = $goods_name;
    //         $CheckoutOrder_store->goods_price = $goods_price;
    //         $CheckoutOrder_store->goods_num = $goods_num;
    //         $CheckoutOrder_store->total_price = $total_price;
    //         $CheckoutOrder_store->pic_path = $pic_url;
    //         //$CheckoutOrder_store->order_status = 'unpaid';
    //         $CheckoutOrder_store->created_time = $order_time;
    //         $CheckoutOrder_store->save();

    //         $update_StreamingOrder_OrderId = StreamingOrder::where('uid', '=', $uid)->update(['order_id' => $order_id]);
    //         $update_ShopOrder_OrderId = ShopOrder::where('uid', '=', $uid)->update(['order_id' => $order_id]);



    //         $item++;
    //     }
    //     //insert DB
    //     $OrderDetail = new OrderDetail();
    //     $OrderDetail->page_id = $page_id;
    //     $OrderDetail->page_name = $page_name;
    //     $OrderDetail->buyer_fbid = $fb_id;
    //     $OrderDetail->buyer_fbname = $buyer_fbname;
    //     $OrderDetail->buyer_name = $buyer_name;
    //     $OrderDetail->order_id = $order_id;
    //     $OrderDetail->transaction_date = $MerchantTradeDate;
    //     $OrderDetail->status = 'unpaid';
    //     $OrderDetail->goods_total = $goods_total;
    //     $OrderDetail->all_total = $TotalAmount;
    //     $OrderDetail->freight = $freight;
    //     $OrderDetail->buyer_address = $address;
    //     $OrderDetail->buyer_phone = $phone;
    //     $OrderDetail->note = $note;
    //     $OrderDetail->save();
    //     return redirect('/buyer_index?page_id='.$page_id)->with('success', '訂單完成，請盡快付款謝謝合作。');
    //  }
}
