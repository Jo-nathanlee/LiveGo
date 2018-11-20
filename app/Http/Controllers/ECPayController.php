<?php
namespace App\Http\Controllers;
use Ecpay;
use Illuminate\Http\Request;
use App\Entities\OrderDetail;
use App\Entities\StreamingOrder;
use App\Entities\ShopOrder;
use App\Entities\CheckoutOrder;
class ECPayController extends Controller
{
    private function GetPaymentWay($p)
    {
      
        $val = \ECPay_PaymentMethod::ALL;
              
        return $val;
    }


    public function checkout(Request $request)
    {
        //買家填寫之資訊
        $address=$request->address;
        $phone=$request->phone;
        $note=$request->note;
        $buyer_name=$request->buyer_name;
        $TotalAmount=$request->total_amount;
        date_default_timezone_set("Asia/Taipei");
        $MerchantTradeDate=date('Y/m/d H:i:s');

        //取得fb_id
        $arr_goods=$request->input('goods');
        $temp=preg_split("/[,]+/", $arr_goods[0]);
        $fb_id=$values[1];

        //產生訂單號碼
        $time_stamp=time();
        $random_num=rand(10,99);
        $order_id=$time_stamp.$random_num.substr($fb_id,0,8);

        //基本參數(請依系統規劃自行調整)
        Ecpay::i()->Send['ReturnURL'] = "http://livego.herokuapp.com/OrderResult";
        //Ecpay::i()->Send['OrderResultURL'] = "http://livego.herokuapp.com/OrderResult" ; 
        Ecpay::i()->Send['MerchantTradeNo'] =$order_id; //訂單編號
        Ecpay::i()->Send['MerchantTradeDate'] =$MerchantTradeDate; //交易時間
        Ecpay::i()->Send['TotalAmount'] = $TotalAmount; //交易金額
        Ecpay::i()->Send['TradeDesc'] = $page_name; //交易描述
        Ecpay::i()->Send['ChoosePayment'] = \ECPay_PaymentMethod::ALL; //付款方式
        
        //產生訂單----------------------------------------------------------------------------------------
        $item=1;
        $order_id;
        $order_time;
        $page_id='';
        $fb_id='';
        $page_name='';
        
        foreach($request->input('goods') as $goods){
            $values = preg_split("/[,]+/", $goods);
            $page_name=$values[0];
            $fb_id=$values[1];
            $name=$values[2];
            $goods_name=$values[3];
            $goods_price=$values[4];
            $goods_num=$values[5];
            $total_price=$values[6];
            $page_id=$values[7];
            $uid=$values[8];
            $pic_url=$values[9];

            //產生訂單編號
            if($item==1)
            {
                // $time_stamp=time();
                // $random_num=rand(10,99);
                // $order_id=$time_stamp.$random_num.substr($fb_id,0,8);
                $order_time=date("Y-m-d H:i:s");
            }

            array_push(Ecpay::i()->Send['Items'], array('Name' =>  $goods_name, 'Price' => (int) ( $goods_price),
            'Currency' => "元", 'Quantity' => (int) ( $goods_num), 'URL' => "dedwed"));
           

            $CheckoutOrder_store = new CheckoutOrder();
            $CheckoutOrder_store->page_id = $page_id;
            $CheckoutOrder_store->page_name = $page_name;
            $CheckoutOrder_store->order_id = $order_id;
            $CheckoutOrder_store->fb_id = $fb_id;
            $CheckoutOrder_store->name = $name;
            $CheckoutOrder_store->goods_name = $goods_name;
            $CheckoutOrder_store->goods_price = $goods_price;
            $CheckoutOrder_store->goods_num = $goods_num;
            $CheckoutOrder_store->total_price = $total_price;
            $CheckoutOrder_store->pic_path = $pic_url;
            $CheckoutOrder_store->order_status = 'unpaid';
            $CheckoutOrder_store->created_time = $order_time;
            $CheckoutOrder_store->save();

            $update_StreamingOrder_OrderId = StreamingOrder::where('uid', '=', $uid)->update(['order_id' => $order_id]);
            $update_ShopOrder_OrderId = ShopOrder::where('uid', '=', $uid)->update(['order_id' => $order_id]);

            $item++; 
        }
            //--------------------------------------------------------------------------------------------------------------
       

        


        //insert DB
        $OrderDetail = new OrderDetail();
        $OrderDetail->page_id = $page_id;
        $OrderDetail->page_name = $page_name;
        $OrderDetail->buyer_fbid = $fb_id;
        $OrderDetail->buyer_name = $buyer_name;
        $OrderDetail->order_id = $MerchantTradeNo;
        $OrderDetail->transaction_date = $MerchantTradeDate;
        $OrderDetail->note = $note;
        $OrderDetail->total_price = $TotalAmount;
        $OrderDetail->buyer_address = $address;
        $OrderDetail->buyer_phone = $phone;
        $OrderDetail->save();




        
        //Go to EcPay
        echo "緑界頁面導向中...";
        echo Ecpay::i()->CheckOutString();
    }



    public function payReturn(Request $request)
    {
        $arFeedback = Ecpay::i()->CheckOutFeedback($request->all());
        //$response = Ecpay::i()->getResponse($arFeedback);
        echo Ecpay::i()->getResponse($arFeedback);
    }  
}



