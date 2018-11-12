<?php
namespace App\Http\Controllers;
use flamelin\ECPay\Facade\Ecpay;
use Illuminate\Http\Request;
use App\Entities\OrderDetail;
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
        Ecpay::i()->Send['ReturnURL'] = "livego.herokuapp.com/checkout_return";
        Ecpay::i()->Send['MerchantTradeNo'] =$MerchantTradeNo; //訂單編號
        Ecpay::i()->Send['MerchantTradeDate'] =$MerchantTradeDate; //交易時間
        Ecpay::i()->Send['TotalAmount'] = $TotalAmount; //交易金額
        Ecpay::i()->Send['TradeDesc'] = $page_name; //交易描述
        Ecpay::i()->Send['ChoosePayment'] = $this->GetPaymentWay($request->payway); //付款方式

        //加密
        //step1、2
        $sMacValue=
        'HashKey=5294y06JbISpM5x9&ChoosePayment=ALL&EncryptType=1&ItemName=';

        $page_id='';
        $buyer_id='';
        //訂單的商品資料
        foreach($order_detail as $order)
        {
            array_push(Ecpay::i()->Send['Items'], array('Name' =>  $order->goods_name, 'Price' => (int) ( $order->goods_price),
            'Currency' => "元", 'Quantity' => (int) ( $order->goods_num), 'URL' => "dedwed"));
            $page_id=$order->page_id;
            $buyer_id=$order->fb_id;
            $sMacValue=$sMacValue.'#'. $order->goods_name;
            
        }

        $sMacValue=$sMacValue.
        '&MerchantID=2000132&MerchantTradeDate='.$MerchantTradeDate.
        '&MerchantTradeNo='.$MerchantTradeNo.
        '&PaymentType=aio&ReturnURL=livego.herokuapp.com/checkout_return&TotalAmount='.$TotalAmount.
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
        $sMacValue = str_replace('%20', '+', $sMacValue);
        //step6        
        $sMacValue=hash('sha256', $sMacValue);
        //step7
        $sMacValue = strtoupper($sMacValue);

        //insert DB
        $OrderDetail = new OrderDetail();
        $OrderDetail->page_id = $page_id;
        $OrderDetail->page_name = $page_name;
        $OrderDetail->buyer_fbid = $buyer_id;
        $OrderDetail->buyer_name = $buyer_name;
        $OrderDetail->order_id = $MerchantTradeNo;
        $OrderDetail->transaction_date = $MerchantTradeDate;
        $OrderDetail->status = '0';
        $OrderDetail->mac_value = $sMacValue;
        $OrderDetail->note = $note;
        $OrderDetail->total_price = $TotalAmount;
        $OrderDetail->buyer_address = $address;
        $OrderDetail->buyer_phone = $phone;
        $OrderDetail->save();

        //Go to EcPay
        echo "緑界頁面導向中...";
        echo Ecpay::i()->CheckOutString();
        // Ecpay::i()->CheckOut();
    }

    public function CheckoutReturn(Request $request){
        // $input = Input::all();
        $MerchantID=$request->input('MerchantID');
        $MerchantTradeNo=$request->input('MerchantTradeNo');
        //$TradeDate=$request->input('TradeDate');
        $RtnCode=$request->input('RtnCode');
        $RtnMsg=$request->input('RtnMsg');
        $TradeNo=$request->input('TradeNo');
        $TradeAmt=$request->input('TradeAmt');
        $PaymentDate=$request->input('PaymentDate');
        $PaymentType=$request->input('PaymentType');
        $PaymentTypeChargeFee=$request->input('PaymentTypeChargeFee');
        $TradeDate=$request->input('TradeDate');
        $SimulatePaid=$request->input('SimulatePaid');
        $CheckMacValue=$request->input('CheckMacValue');

        $OrderDetail = new OrderDetail();
        $OrderDetail->page_id = $MerchantID;
        $OrderDetail->page_name = $MerchantTradeNo;
        $OrderDetail->buyer_fbid = $RtnCode;
        $OrderDetail->buyer_name = $RtnMsg;
        $OrderDetail->order_id = $TradeNo;
        $OrderDetail->transaction_date = $TradeAmt;
        $OrderDetail->status = $PaymentDate;
        $OrderDetail->mac_value = $PaymentType;
        $OrderDetail->note = $PaymentTypeChargeFee;
        $OrderDetail->total_price = $TradeDate;
        $OrderDetail->buyer_address = $SimulatePaid;
        $OrderDetail->buyer_phone = $CheckMacValue;
        $OrderDetail->save();




        $sMacValue=OrderDetail::where('status', '=', '0')
                 ->where('order_id', '=',$TradeNo ) 
                 ->select('mac_value')
                 ->get();

        if($CheckMacValue==$sMacValue)
        {
            return '1|OK';
        }

        
        //輸入通知
        // notification::create([
        //     'email'=>$project -> id,
        //     'img'=>'/outImg/'.$project->out_pic_path,
        //     'title'=>$title,
        //     'detail'=>$detail,
        //     'status'=>"0"
        // ]);

    }  

      

    
   
}