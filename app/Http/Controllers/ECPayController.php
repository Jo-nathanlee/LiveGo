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

        
        
        //加密
        //step1、2
        $sMacValue=
        'HashKey=5294y06JbISpM5x9&ChoosePayment=ALL&EncryptType=1&ItemName=test';

        // $page_id='';
        // $buyer_id='';
        // //訂單的商品資料
        // foreach($order_detail as $order)
        // {
        //     array_push(Ecpay::i()->Send['Items'], array('Name' =>  $order->goods_name, 'Price' => (int) ( $order->goods_price),
        //     'Currency' => "元", 'Quantity' => (int) ( $order->goods_num), 'URL' => "dedwed"));
        //     $page_id=$order->page_id;
        //     $buyer_id=$order->fb_id;
        //     $sMacValue=$sMacValue.'#'. $order->goods_name;
        // }
        $sMacValue2=$sMacValue;
        $sMacValue=$sMacValue.
        '&MerchantID=2000132&MerchantTradeDate='.$MerchantTradeDate.
        '&MerchantTradeNo='.$MerchantTradeNo.
        '&PaymentType=aio&ReturnURL=http://livego.herokuapp.com/OrderResult&TotalAmount='.$TotalAmount.
        '&TradeDesc='.$page_name.
        '&HashIV=v77hoKGq4kWxNNIS';
        //step3
        $sMacValue=urlencode($sMacValue);        
        //step4
        $sMacValue = strtolower($sMacValue);
        //step5
        $sMacValue = str_replace('%2d', '-', $sMacValue);
        $sMacValue = str_replace('%5f', '_', $sMacValue);
        $sMacValue = str_replace('%2e', '.', $sMacValue);
        $sMacValue = str_replace('%21', '!', $sMacValue);
        $sMacValue = str_replace('%2a', '*', $sMacValue);
        $sMacValue = str_replace('%28', '(', $sMacValue);
        $sMacValue = str_replace('%29', ')', $sMacValue);

        //step6        
        $sMacValue=hash('sha256', $sMacValue);
        //step7
        $sMacValue = strtoupper($sMacValue);

        //insert DB
        $OrderDetail = new OrderDetail();
        $OrderDetail->page_id = '111';
        $OrderDetail->page_name = $page_name;
        $OrderDetail->buyer_fbid = '111';
        $OrderDetail->buyer_name = $buyer_name;
        $OrderDetail->order_id = $MerchantTradeNo;
        $OrderDetail->transaction_date = $MerchantTradeDate;
        $OrderDetail->status = '0';
        $OrderDetail->mac_value = $sMacValue;
        $OrderDetail->note = $sMacValue2;
        $OrderDetail->total_price = $TotalAmount;
        $OrderDetail->buyer_address = $address;
        $OrderDetail->buyer_phone = $phone;
        $OrderDetail->save();

        //基本參數(請依系統規劃自行調整)
        Ecpay::i()->Send['ReturnURL'] = "http://livego.herokuapp.com/OrderResult";
        //Ecpay::i()->Send['OrderResultURL'] = "http://livego.herokuapp.com/OrderResult" ; 
        Ecpay::i()->Send['MerchantTradeNo'] =$MerchantTradeNo; //訂單編號
        Ecpay::i()->Send['MerchantTradeDate'] =$MerchantTradeDate; //交易時間
        Ecpay::i()->Send['TotalAmount'] = $TotalAmount; //交易金額
        Ecpay::i()->Send['TradeDesc'] = $page_name; //交易描述
        Ecpay::i()->Send['ChoosePayment'] = \ECPay_PaymentMethod::ALL; //付款方式

        array_push(Ecpay::i()->Send['Items'], array('Name' => 'test', 'Price' => 1,
        'Currency' => "元", 'Quantity' => 1, 'URL' => "dedwed"));
        
        //Go to EcPay
        echo "緑界頁面導向中...";
        echo Ecpay::i()->CheckOutString();
    }



    public function payReturn(Request $request)
    {
        $arFeedback = Ecpay::i()->CheckOutFeedback($request->all());
        $return_status = Ecpay::i()->getResponse($arFeedback);
        $arParameters = $request->all();
        $HashKey = '5294y06JbISpM5x9';
        $HashIV = 'v77hoKGq4kWxNNIS';


        $MerchantID = $request->input('MerchantID');
        $MerchantTradeNo = $request->input('MerchantTradeNo');
        $RtnCode = $request->input('RtnCode');
        $RtnMsg = $request->input('RtnMsg');
        $TradeNo=$request->input('TradeNo');
        $TradeAmt=$request->input('TradeAmt');
        $PaymentDate=$request->input('PaymentDate');
        $PaymentType=$request->input('PaymentType');
        $PaymentTypeChargeFee=$request->input('PaymentTypeChargeFee');
        $TradeDate=$request->input('TradeDate');
        $SimulatePaid=$request->input('SimulatePaid');
        $CheckMacValue=$request->input('CheckMacValue');

        $szCheckMacValue = ECPay_CheckMacValue::generate($arParameters,$HashKey,$HashIV,1);

        $OrderDetail = new OrderDetail();
        $OrderDetail->page_id = $CheckMacValue;
        $OrderDetail->page_name = $szCheckMacValue;
        $OrderDetail->save();

      


        

        // if($RtnCode==1)
        // {
        //     if($CheckMacValue==$sMacValue)
        //     {
        //         return '1|OK';
        //     }
        //     else
        //     {
        //         $OrderDetail = new OrderDetail();
        //         $OrderDetail->page_id = 'mac_wrong';
        //         $OrderDetail->save();
        //     }
        // }
        // else
        // {
        //     $OrderDetail = new OrderDetail();
        //     $OrderDetail->page_id = $RtnMsg;
        //     $OrderDetail->save();
        // }
        

        
       
    }  

      

    
   
}