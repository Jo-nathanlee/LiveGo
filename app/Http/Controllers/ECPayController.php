<?php
namespace App\Http\Controllers;
use Ecpay;
use Illuminate\Http\Request;
use App\Entities\OrderDetail;
use App\Entities\PageDetail;
use App\Entities\StreamingOrder;
use App\Entities\StreamingProduct;
use App\Entities\ShopOrder;
use App\Entities\ShopProduct;
use App\Entities\CheckoutOrder;
use App\Entities\LogisticsOrder;
use App\Entities\Member;
use App\Entities\PayMethod;
use App\Entities\Logistics;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class ECPayController extends Controller
{
    private function GetPaymentWay($p)
    {
      
        $val = \ECPay_PaymentMethod::ALL;
              
        return $val;
    }


    public function checkout(Request $request)
    {
        $this->validate($request, [
            'buyer_name' => 'required | max:10',
            'phone' => 'required | regex:/(09)[0-9]{8}/',
            'email' => 'required | email',
        ]);
        //買家填寫之資訊
        $address=$request->address;
        $phone=$request->phone;
        $note=$request->note;
        $buyer_fbname=$request->buyer_fbname;
        $freight=$request->freight;
        $buyer_name=$request->buyer_name;
        $goods_total=$request->goods_total;
        $TotalAmount=$request->all_total;
        $shipping_method=(int)$request->shipping_method;
        $payment_type=(int)$request->payment_type;
        $page_id=$request->page_id;
        $email=$request->email;


        

        if($shipping_method==53 || $shipping_method==54)
        {
            $LogisticsSubType = 'UNIMARTC2C';
        }
        if($shipping_method==63 || $shipping_method==64)
        {
            $LogisticsSubType = 'FAMIC2C';
        }
        if($shipping_method==53 || $shipping_method==63)
        {
            $IsCollection = 'N';
        }
        if($shipping_method==54 || $shipping_method==64)
        {
            $IsCollection = 'Y';
        }

        Session::put('ReceiverName',$buyer_name);
        Session::put('ReceiverCellPhone',$phone);
        Session::put('ReceiverEmail',$email);
        Session::put('page_id',$page_id);


        

        date_default_timezone_set("Asia/Taipei");
        $MerchantTradeDate=date('Y/m/d H:i:s');
        $streaming_order=json_decode($request->input('streaming_order'));
        $shop_order=json_decode($request->input('shop_order'));


        //取得fb_id
        if($streaming_order!=null)
        {
            $temp=preg_split("/[,]+/", $streaming_order[0]);
            $fb_id=$temp[1];
        }
        if($shop_order!=null)
        {
            $temp=preg_split("/[,]+/", $shop_order[0]);
            $fb_id=$temp[1];
        }

        

        //產生訂單號碼
        $time_stamp=time();
        $random_num=rand(10,99);
        $order_id=$time_stamp.substr($fb_id,0,7).$random_num;
        
        //產生訂單----------------------------------------------------------------------------------------
        $item=1;
        $order_time;
        $page_id='';
        $fb_name='';
        $page_name='';
        $sent_goods_name="";
       

        //商城訂單
        if($shop_order!=null)
        {
            foreach($shop_order as $goods){
                $values = preg_split("/[,]+/", $goods);
                $page_name=$values[0];
                $name=$values[2];
                $goods_name=$values[3];
                $goods_price=$values[4];
                $goods_num=$values[5];
                $total_price=$values[6];
                $page_id=$values[7];
                $uid=$values[8];
                $pic_url=$values[9];
                $category=$values[10];
                $product_id=$values[11];
                $sent_goods_name=$goods_name."#";
                $fb_name=$name;
    
                //檢查商品是否售完
                $if_sold_out = ShopProduct::where('product_id','=',$product_id)
                    ->where('page_id','=',$page_id)
                    ->first();
    
                if($if_sold_out == null || $if_sold_out->goods_num<=0 || $if_sold_out->goods_num<$goods_num){
                    return redirect('/buyer_index?page_id='.$page_id)->with('fail', '結帳失敗!。<br>'.$goods_name.'<small>商品庫存不足！。</small>');
                }
                else
                {
                    ShopProduct::where('product_id', '=', $product_id)->where('page_id', '=', $page_id)->decrement('goods_num',$goods_num);
                }
    
                //產生訂單編號
                if($item==1)
                {
                    // $time_stamp=time();
                    // $random_num=rand(10,99);
                    // $order_id=$time_stamp.$random_num.substr($fb_id,0,8);
                    $order_time=date("Y-m-d H:i:s");
                }
                if($payment_type==2)
                {
                    if($category!="empty"){
                        array_push(Ecpay::i()->Send['Items'], array('Name' =>  $goods_name.'，'.$category, 'Price' => (int) ( $goods_price),
                        'Currency' => "元", 'Quantity' => (int) ( $goods_num), 'URL' => "dedwed"));
                       
                    }else{
                        array_push(Ecpay::i()->Send['Items'], array('Name' =>  $goods_name, 'Price' => (int) ( $goods_price),
                        'Currency' => "元", 'Quantity' => (int) ( $goods_num), 'URL' => "dedwed"));
                       
                    }
                }
                
    
                
                // $CheckoutOrder_store = new CheckoutOrder();
                // $CheckoutOrder_store->page_id = $page_id;
                // $CheckoutOrder_store->order_id = $order_id;
                // $CheckoutOrder_store->fb_id = $fb_id;
                // $CheckoutOrder_store->product_id = $product_id;
                // $CheckoutOrder_store->goods_num = $goods_num;
                // $CheckoutOrder_store->total_price = $total_price;
                // $CheckoutOrder_store->created_time = $order_time;
                // $CheckoutOrder_store->purchase_from = 2;
                // $CheckoutOrder_store->save();
    
                // $update_StreamingOrder_OrderId = StreamingOrder::where('id', '=', $uid)->update(['order_id' => $order_id]);
                $update_ShopOrder_OrderId = ShopOrder::where('id', '=', $uid)->update(['order_id' => $order_id]);
    
                //修改剩餘商品數量
                //Shop::where('pic_url', '=', $pic_url)->where('page_id', '=', $page_id)->decrement('goods_num',$goods_num);
                //修改已銷售商品數量
                //Shop::where('pic_url', '=', $pic_url)->where('page_id', '=', $page_id)->increment('selling_num',$goods_num);
    
                $item++; 
            }
        }
        
        //直播訂單
        if($streaming_order!=null)
        {
            foreach($streaming_order as $goods){
                $values = preg_split("/[,]+/", $goods);
                $page_name=$values[0];
                $name=$values[2];
                $goods_name=$values[3];
                $goods_price=$values[4];
                $goods_num=$values[5];
                $total_price=$values[6];
                $page_id=$values[7];
                $uid=$values[8];
                $pic_url=$values[9];
                $category=$values[10];
                $product_id=$values[11];
                $sent_goods_name=$goods_name."#";
                $fb_name=$name;
                //產生訂單編號
                if($item==1)
                {
                    $order_time=date("Y-m-d H:i:s");
                }
                if($payment_type==2)
                {
                    if($category!="empty"){
                        array_push(Ecpay::i()->Send['Items'], array('Name' =>  $goods_name.'，'.$category, 'Price' => (int) ( $goods_price),
                        'Currency' => "元", 'Quantity' => (int) ( $goods_num), 'URL' => "dedwed"));
                       
                    }else{
                        array_push(Ecpay::i()->Send['Items'], array('Name' =>  $goods_name, 'Price' => (int) ( $goods_price),
                        'Currency' => "元", 'Quantity' => (int) ( $goods_num), 'URL' => "dedwed"));
                    }
                }
                
    
                
                // $CheckoutOrder_store = new CheckoutOrder();
                // $CheckoutOrder_store->page_id = $page_id;
                // $CheckoutOrder_store->order_id = $order_id;
                // $CheckoutOrder_store->fb_id = $fb_id;
                // $CheckoutOrder_store->product_id = $product_id;
                // $CheckoutOrder_store->goods_num = $goods_num;
                // $CheckoutOrder_store->total_price = $total_price;
                // $CheckoutOrder_store->created_time = $order_time;
                // $CheckoutOrder_store->purchase_from = 1;
                // $CheckoutOrder_store->save();
    
                $update_StreamingOrder_OrderId = StreamingOrder::where('id', '=', $uid)->update(['order_id' => $order_id]);
                $item++; 
            }
        }

        
        
            //--------------------------------------------------------------------------------------------------------------
        //insert DB
        $OrderDetail = new OrderDetail();
        $OrderDetail->page_id = $page_id;
        $OrderDetail->buyer_fbid = $fb_id;
        $OrderDetail->buyer_name = $buyer_name;
        $OrderDetail->buyer_email = $email;
        $OrderDetail->order_id = $order_id;
        $OrderDetail->transaction_date = $MerchantTradeDate;
        $OrderDetail->status = 11;
        $OrderDetail->goods_total = $goods_total;
        $OrderDetail->all_total = $TotalAmount;
        $OrderDetail->freight = $freight;
        $OrderDetail->buyer_address = $address;
        $OrderDetail->buyer_phone = $phone;
        $OrderDetail->note = $note; 
        $OrderDetail->save();


        if($payment_type == 1)
        {
            //自行匯款&綠界超商物流
            if($shipping_method == 54 || $shipping_method == 64 || $shipping_method == 53 || $shipping_method == 63)
            {
                return redirect("https://livego.com.tw/EcpayCvsMap?page_id=".$page_id."&MerchantTradeNo=".$order_id."&LogisticsSubType=".$LogisticsSubType."&IsCollection=".$IsCollection);
            }
            //自行匯款&自行物流
            else
            {
                return redirect()->route('buyer_order', ['page_id'=>$page_id]);   
            }
        }
        //綠界付款
        else
        {
            //基本參數(請依系統規劃自行調整)
            Ecpay::i()->Send['ReturnURL'] = "https://livego.com.tw/OrderResult";
            //超商
            if($shipping_method==53 || $shipping_method==54 || $shipping_method==64 || $shipping_method==63)
            {
                Ecpay::i()->Send['OrderResultURL'] = "https://livego.com.tw/EcpayCvsMap?page_id=".$page_id."&MerchantTradeNo=".$order_id."&LogisticsSubType=".$LogisticsSubType."&IsCollection=".$IsCollection; 
                Ecpay::i()->Send['ClientBackURL'] = "https://livego.com.tw/buyer_index?page_id=".$page_id; //交易描述
            }
            //自行物流
            else
            {
                Ecpay::i()->Send['OrderResultURL'] = "https://livego.com.tw/buyer_order?page_id=".$page_id; 
                Ecpay::i()->Send['ClientBackURL'] = "https://livego.com.tw/buyer_index?page_id=".$page_id; //交易描述
            }

            Ecpay::i()->Send['MerchantTradeNo'] =$order_id; //訂單編號
            Ecpay::i()->Send['MerchantTradeDate'] =$MerchantTradeDate; //交易時間
            Ecpay::i()->Send['TotalAmount'] = $TotalAmount; //交易金額
            Ecpay::i()->Send['TradeDesc'] = 'LIVE GO'; //交易描述
            Ecpay::i()->Send['ChoosePayment'] = \ECPay_PaymentMethod::ALL; //付款方式
            Ecpay::i()->Send['CustomField1'] = $fb_name; 
            Ecpay::i()->Send['CustomField2'] = $request->page_id; 
            Ecpay::i()->Send['CustomField3'] = $fb_id;   


            // $pay_methods = PayMethod::where('page_id', $page_id)->where('is_active', 'false')->get();
            // if(count($pay_methods) == 3){
            //     //使用者未勾選付款方式，預設為信用卡
            //     Ecpay::i()->Send['ChoosePayment'] = \ECPay_PaymentMethod::Credit;         }
            // else{
            //     
            //     //賣家未選擇的付款方式
            //     //注意：手機版不支援 WebATM，BARCODE
            //     //選項：Credit#ATM#CVS#WebATM#BARCODE 用#連結
            //     $ignore_payment = '';
            //     foreach ($pay_methods as $pay) {
            //         $ignore_payment .= '#'.$pay['pay_method'];
            //     }
            //     $ignore_payment .= '#WebATM#BARCODE';
            //     $ignore_payment = substr($ignore_payment,1,strlen($ignore_payment));

            //     //Ecpay::i()->Send['IgnorePayment'] = (string)$ignore_payment;
            // }

            //Go to EcPay
            echo "緑界頁面導向中...";
            echo Ecpay::i()->CheckOutString();
        }
    }

    public function payReturn(Request $request)
    {
        $payment_time = date("Y-m-d H:i:s");

        $order_id = $request->MerchantTradeNo;
        $fb_name = $request->CustomField1;
        $page_id = $request->CustomField2;
        $fb_id = $request->CustomField3;

        Session::put('page_id',$page_id);

        $streaming_order = DB::table('streaming_order')
        ->where('order_id', '=', $order_id)
        ->join('streaming_product', 'streaming_order.product_id', '=', 'streaming_product.product_id')
        ->select('streaming_product.*', 'streaming_order.goods_num as order_num','streaming_order.single_price')
        ->get();

        $shop_order = DB::table('shop_order')
        ->where('order_id', '=', $order_id)
        ->join('shop_product', 'shop_order.product_id', '=', 'shop_product.product_id')
        ->select('shop_product.*', 'shop_order.goods_num as order_num','shop_order.total_price')
        ->get();


        $total_money_spent=0;

        $arFeedback = Ecpay::i()->CheckOutFeedback($request->all());
        $response = Ecpay::i()->getResponse($arFeedback);
        if($response=='1|OK')
        {
            $query = OrderDetail::where('order_id', '=', $order_id)->first();
            

            if($streaming_order!=null)
            {
                foreach($streaming_order as $goods){
                    $total_money_spent+=(((int)$goods->order_num)*((int)$goods->single_price));
                    //修改已銷售商品數量
                    StreamingProduct::where('product_id', '=', $goods->product_id)->where('page_id', '=', $page_id)->increment('selling_num',(int)$goods->order_num);
    
                }
            }
            
            if($shop_order!=null)
            {
                foreach($shop_order as $goods){
                    $total_money_spent+=(int)($goods->total_price);
                    //修改已銷售商品數量
                    ShopProduct::where('product_id', '=', $goods->product_id)->where('page_id', '=', $page_id)->increment('selling_num',(int)$goods->order_num);
                }
            }

            //更新member購物金額
            $Member_Data = Member::where('page_id', '=', $page_id)->where('as_id', '=', $fb_id)->first();
            if($Member_Data!=null){
                $total_money_spent= $total_money_spent+$Member_Data->money_spent;
                $Member_Data->update(['money_spent' => $total_money_spent ,'updated_at'=>date("Y-m-d H:i:s")]);
            }
                            
            $update_OrderDetail = OrderDetail::where('order_id', '=', $order_id)->update(['status' => 13,'transaction_date' => $payment_time]);
            $OrderDetail = OrderDetail::where('order_id', '=', $order_id)->first();
            
        }
        else
        {
            $cancel_OrderDetail = OrderDetail::where('order_id', '=', $order_id)->delete();
            $update_StreamingOrder_OrderId = StreamingOrder::where('order_id', '=', $order_id)->update(['order_id' => null]);
            $update_ShopOrder_OrderId = ShopOrder::where('order_id', '=', $order_id)->update(['order_id' => null]);
            foreach($shop_order as $goods){
                //失敗的時候不會增加
                ShopProduct::where('product_id', '=', $goods->product_id)->where('page_id', '=', $page_id)->increment('goods_num',$goods->order_num);
            }
        }
        
           
        
    }
    
    
    public function EcpayCvsMap(Request $request)
    {
        $PageDetail = PageDetail::where('page_id','=',$page_id)->first();
        Session::put('page_id',$request->page_id);
        //基本參數(請依系統規劃自行調整)
        if($PageDetail->hashkey == null || $PageDetail->hashkey == "")
        {
            Ecpay::l()->HashKey = 'XBERn1YOvpM9nfZc'; 
        }
        else
        {
            Ecpay::l()->HashKey = $PageDetail->hashkey; 
        }

        if($PageDetail->hashiv == null || $PageDetail->hashiv == "")
        {
            Ecpay::l()->HashIV = 'h1ONHk4P4yqbl5LK'; 
        }
        else
        {
            Ecpay::l()->HashIV = $PageDetail->hashiv; 
        }

        if($PageDetail->merchant_code == null || $PageDetail->merchant_code == "")
        {
            Ecpay::l()->Send['MerchantID'] = '2000933';
        }
        else
        {
            Ecpay::l()->Send['MerchantID'] = $PageDetail->merchant_code; 
        }
        
        Ecpay::l()->Send['MerchantTradeNo'] = $request->MerchantTradeNo; //訂單編號
        Ecpay::l()->Send['LogisticsType'] = 'CVS';
        Ecpay::l()->Send['LogisticsSubType'] = $request->LogisticsSubType; //或FAMIC2C,全家
        Ecpay::l()->Send['IsCollection'] = $request->IsCollection;//是否代收貨款
        Ecpay::l()->Send['ServerReplyURL'] =  "https://livego.com.tw/EcpayLogisticsReply"; //超商系統回覆路徑post
        Ecpay::l()->Send['ExtraData'] = $request->IsCollection.'#'.$request->page_id;		
        Ecpay::l()->Send['Device'] = 0;		
        $logisticsForm = Ecpay::l()->CvsMap();
        echo $logisticsForm;

    }

    public function EcpayLogisticsReply(Request $request)
    {
        $data = array();	
        $data['MerchantID'] = $request->MerchantID; //店編號	
        $data['MerchantTradeNo'] = $request->MerchantTradeNo; //訂單編號
        $data['LogisticsSubType'] = $request->LogisticsSubType; //物流通路代碼,如統一:UNIMART
        $data['CVSStoreID'] = $request->CVSStoreID;//商店代碼
        $data['CVSStoreName'] = $request->CVSStoreName;
        $data['CVSAddress'] = $request->CVSAddress;//User 所選之超商店舖地址
        $data['ExtraData'] = $request->ExtraData;//額外資訊,原資料回傳

        $temp = array();
        $temp = explode("#",$data['ExtraData']);
        $IsCollection = $temp[0];
        $page_id = $temp[1];
        Session::put('page_id',$page_id);
        //change array to json object (return view才需要)
        //$data = json_decode(json_encode($data), FALSE);
        $order_id = $data['MerchantTradeNo'];
        $OrderDetail = OrderDetail::where('order_id', '=', $data['MerchantTradeNo'])->first();
        if($IsCollection=='Y')
        {
            $CollectionAmount=(string)$OrderDetail->all_total;
        }
        else
        {
            $CollectionAmount='';
        }

        $GoodsName='';
        $streaming_order = DB::table('streaming_order')
        ->where('order_id', '=', $order_id)
        ->join('streaming_product', 'streaming_order.product_id', '=', 'streaming_product.product_id')
        ->select('streaming_product.*', 'streaming_order.goods_num as order_num','streaming_order.single_price')
        ->get();

        if($streaming_order!=null)
        {
            foreach($streaming_order as $order)
            {
                $GoodsName.=$order->goods_name." ";
            }
        }
    
        $shop_order = DB::table('shop_order')
        ->where('order_id', '=', $order_id)
        ->join('shop_product', 'shop_order.product_id', '=', 'shop_product.product_id')
        ->select('shop_product.*', 'shop_order.goods_num as order_num','shop_order.total_price')
        ->get();

        if($shop_order!=null)
        {
            foreach($shop_order as $order)
            {
                $GoodsName.=$order->goods_name." ";
            }
        }


        $page_detail=PageDetail::where('page_id', $page_id)->first();
        $sender_name=$page_detail->sender_name;
        $sender_cell=$page_detail->sender_cell;
        $GoodsName=str_replace(',', '', $GoodsName);
        //背景建立店到付物流單
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
                'MerchantID' =>  $data['MerchantID'], //$page_detail->merchant_code
                'MerchantTradeNo' => 'l'.$data['MerchantTradeNo'],
                'MerchantTradeDate' => date('Y/m/d H:i:s'),
                'LogisticsType' => 'CVS',
                'LogisticsSubType' =>  $data['LogisticsSubType'],
                'GoodsAmount' => (int)$OrderDetail->goods_total,
                'IsCollection' => $IsCollection,    //是否代收貨款
                'CollectionAmount' => (int)$CollectionAmount,
                'GoodsName' => $GoodsName,
                'SenderName' => $sender_name,
                'SenderPhone' => '',
                'SenderCellPhone' => $sender_cell,
                'ReceiverName' => $OrderDetail->buyer_name,
                'ReceiverPhone' => '',
                'ReceiverEmail' => $OrderDetail->buyer_email,
                'ReceiverCellPhone' => $OrderDetail->buyer_phone,
                'TradeDesc' => $data['MerchantTradeNo'],
                'ServerReplyURL' => 'https://livego.com.tw/LogisticsStatusReply ',        //物流狀態回覆網址
                'LogisticsC2CReplyURL' => 'https://livego.com.tw/LogisticsStatusReply',    //到付店若有異動訊息回覆網址
                'Remark' => '',
                'PlatformID' => '',
            );
            $AL->SendExtend = array(
                'ReceiverStoreID' => $data['CVSStoreID'] ,     //到付店id
            );
            $Result = $AL->BGCreateShippingOrder();   //超商系統回覆內容
            echo '<pre>' . print_r($Result, true) . '</pre>';  

            if(isset($Result['RtnCode']) && $Result['RtnCode'] == 300){
                $LogisticsOrder = new LogisticsOrder();
                $LogisticsOrder->MerchantID = $data['MerchantID'];
                $LogisticsOrder->AllPayLogisticsID = $Result['AllPayLogisticsID'];
                $LogisticsOrder->CVSPaymentNo = $Result['CVSPaymentNo'];
                $LogisticsOrder->CVSValidationNo = $Result['CVSValidationNo'];
                $LogisticsOrder->LogisticsSubType = $data['LogisticsSubType'];
                $LogisticsOrder->order_id = $order_id;
                $LogisticsOrder->save();

             
                return redirect()->route('buyer_order', ['page_id'=>$page_id]);
        		//托運單成功建立
              }
              else
              {
                return redirect('/buyer_index')->with('page_id',$page_id);
              }

        } catch(Exception $e) {
            $Result = $e->getMessage();
            echo $e->getMessage();
        } 

       
        
    }  

    public function LogisticsStatusReply(Request $request)
    {

        $MerchantTradeNo = $request->MerchantTradeNo; 
        $order_id = str_replace('l', '', $MerchantTradeNo);
        $RtnCode = $request->RtnCode; 
        $RtnMsg = $request->RtnMsg; 


        $Logistic = Logistics::where('status_code','=',(int)$RtnCode)->first();
        $orderstatus_id = $Logistic->orderstatus_id;
        if($orderstatus_id==16)
        {
            $update_OrderDetail = OrderDetail::where('order_id', '=', $order_id)->update(['status' => (int)$orderstatus_id,'other_status' => (int)$Logistic->status_code,'updated_at' => date('Y/m/d H:i:s')]);
        }
        else
        {
            $update_OrderDetail = OrderDetail::where('order_id', '=', $order_id)->update(['status' => (int)$orderstatus_id,'updated_at' => date('Y/m/d H:i:s')]);
        }
  
    }  
}



