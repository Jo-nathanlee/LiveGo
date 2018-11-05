<?php
use Allpay; 
class AllPayController extends Controller
{
    public function Index()
    {   
    //Official Example :     
    //https://github.com/allpay/PHP/blob/master/AioSDK/example/sample_Credit_CreateOrder.php

    //基本參數(可依系統規劃自行調整)
    Allpay::i()->Send['ReturnURL']         = "http://livego.herokuapp.com/" ; 
                                            //交易結果回報的網址
    Allpay::i()->Send['ClientBackURL']     = "hhttp://livego.herokuapp.com/buyer_index" ; 
                                            //交易結束，讓user導回的網址
    Allpay::i()->Send['MerchantTradeNo']   = "Test".time() ;           //訂單編號
    Allpay::i()->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');      //交易時間
    Allpay::i()->Send['TotalAmount']       = 2000;                     //交易金額
    Allpay::i()->Send['TradeDesc']         = "good to drink" ;         //交易描述
    Allpay::i()->Send['EncryptType']      = '1' ;  
    Allpay::i()->Send['ChoosePayment']     = "Credit" ;     //付款方式:信用卡
    Allpay::i()->Send['PaymentType']        = 'aio' ;

    //訂單的商品資料
    array_push(Allpay::i()->Send['Items'], 
            array('Name' => "美美小包包", 
            'Price' => (int)"2000",'Currency' => "元", 
            'Quantity' => (int) "1", 
            'URL' => "http://www.yourwebsites.com.tw/Product"));

    //Go to EcPay    
    echo "線上刷卡頁面導向中...";    
    echo Allpay::i()->CheckOutForm();

    //開發階段，如果你希望看到表單的內容，可以改為以下敘述：   
    //echo Allpay::i()->CheckOutForm('按我，才送出');

    }

    public function return_url()
    {
        
    }
}