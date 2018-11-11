<?php
namespace App\Http\Controllers;
use flamelin\ECPay\Facade\Ecpay;
use Illuminate\Http\Request;
class ECPayController extends Controller
{
    private function GetPaymentWay($p)
    {
        $val = "";
        switch ($p) {
            case 'ALL':
                $val = \ECPay_PaymentMethod::ALL;
                break;
            case 'Credit':
                $val = \ECPay_PaymentMethod::Credit;
                break;
            case 'CVS':
                $val = \ECPay_PaymentMethod::CVS;
                break;
            default:
                $val = \ECPay_PaymentMethod::ALL;
                break;
        }
        return $val;
    }

    public function index()
    {
        return view('ecpay::demo');
    }

    public function checkout(Request $request)
    {
        $order_detail=json_decode($request->order_detail);


        //基本參數(請依系統規劃自行調整)
        Ecpay::i()->Send['ReturnURL'] = "http://www.ecpay.com.tw/receive.php";
        Ecpay::i()->Send['MerchantTradeNo'] = "Test" . time(); //訂單編號
        Ecpay::i()->Send['MerchantTradeDate'] = date('Y/m/d H:i:s'); //交易時間
        Ecpay::i()->Send['TotalAmount'] = $request->total_amount; //交易金額
        Ecpay::i()->Send['TradeDesc'] = "good to drink"; //交易描述
        Ecpay::i()->Send['ChoosePayment'] = $this->GetPaymentWay($request->payway); //付款方式
        //訂單的商品資料
        foreach($order_detail as $order)
        {
            array_push(Ecpay::i()->Send['Items'], array('Name' =>  $order->goods_name, 'Price' => (int) ( $order->goods_price),
            'Currency' => "元", 'Quantity' => (int) ( $order->goods_num), 'URL' => "dedwed"));
        //Go to EcPay
        echo "緑界頁面導向中...";
        echo Ecpay::i()->CheckOutString();
        // Ecpay::i()->CheckOut();
    }
   
}