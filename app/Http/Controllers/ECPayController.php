<?php
namespace App\Http\Controllers;
use Ecpay;
use Illuminate\Http\Request;
use App\Entities\OrderDetail;
class ECPayController extends Controller
{
    private function GetPaymentWay($p)
    {
      
        $val = \ECPay_PaymentMethod::ALL;
              
        return $val;
    }


    public function checkout(Request $request)
    {
        $order_detail=json_decode($request->order_detail);
        $address=$request->address;
        $phone=$request->phone;
        $note=$request->note;
        $buyer_name=$request->buyer_name;
        $TotalAmount=$request->total_amount;
        $MerchantTradeNo=$request->order_id;
        $page_name=$request->page_name;
        date_default_timezone_set("Asia/Taipei");
        $MerchantTradeDate=date('Y/m/d H:i:s');

        //基本參數(請依系統規劃自行調整)
        Ecpay::i()->Send['ReturnURL'] = "http://livego.herokuapp.com/OrderResult";
        //Ecpay::i()->Send['OrderResultURL'] = "http://livego.herokuapp.com/OrderResult" ; 
        Ecpay::i()->Send['MerchantTradeNo'] =$MerchantTradeNo; //訂單編號
        Ecpay::i()->Send['MerchantTradeDate'] =$MerchantTradeDate; //交易時間
        Ecpay::i()->Send['TotalAmount'] = $TotalAmount; //交易金額
        Ecpay::i()->Send['TradeDesc'] = $page_name; //交易描述
        Ecpay::i()->Send['ChoosePayment'] = \ECPay_PaymentMethod::ALL; //付款方式
        
      
       

        $page_id='';
        $buyer_id='';
        //訂單的商品資料
        foreach($order_detail as $order)
        {
            array_push(Ecpay::i()->Send['Items'], array('Name' =>  $order->goods_name, 'Price' => (int) ( $order->goods_price),
            'Currency' => "元", 'Quantity' => (int) ( $order->goods_num), 'URL' => "dedwed"));
            $page_id=$order->page_id;
            $buyer_id=$order->fb_id;
            
        }

        //insert DB
        $OrderDetail = new OrderDetail();
        $OrderDetail->page_id = $page_id;
        $OrderDetail->page_name = $page_name;
        $OrderDetail->buyer_fbid = $buyer_id;
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



