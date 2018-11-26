<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use App\Entities\Page;
use App\Entities\Shop;
use App\Entities\StramingProduct;
use App\Entities\StreamingOrder;
use App\Entities\ShopOrder;
use App\Entities\CheckoutOrder;
use App\Entities\ProductCategories;
use App\User;
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
     //購物車頁面確認後產生訂單
    //  public function CheckOut(Request $request)
    //  {
    //     if (Gate::allows('seller-only',  Auth::user())) {
    //         if($request->has('goods')){
    //         $item=1;
    //         $order_id;
    //         $order_time;
    //         foreach($request->input('goods') as $goods){
    //             $values = preg_split("/[,]+/", $goods);
    //             $page_name=$values[0];
    //             $fb_id=$values[1];
    //             $name=$values[2];
    //             $goods_name=$values[3];
    //             $goods_price=$values[4];
    //             $goods_num=$values[5];
    //             $total_price=$values[6];
    //             $page_id=$values[7];
    //             $uid=$values[8];
    //             $pic_url=$values[9];
    
    //             //產生訂單編號
    //             if($item==1)
    //             {
    //                 $time_stamp=time();
    //                 $random_num=rand(10,99);
    //                 $order_id=$time_stamp.$random_num.substr($fb_id,0,8);
    //                 $order_time=date("Y-m-d H:i:s");
    //             }
    
            
    
    
    //             $CheckoutOrder_store = new CheckoutOrder();
    //             $CheckoutOrder_store->page_id = $page_id;
    //             $CheckoutOrder_store->page_name = $page_name;
    //             $CheckoutOrder_store->order_id = $order_id;
    //             $CheckoutOrder_store->fb_id = $fb_id;
    //             $CheckoutOrder_store->name = $name;
    //             $CheckoutOrder_store->goods_name = $goods_name;
    //             $CheckoutOrder_store->goods_price = $goods_price;
    //             $CheckoutOrder_store->goods_num = $goods_num;
    //             $CheckoutOrder_store->total_price = $total_price;
    //             $CheckoutOrder_store->pic_path = $pic_url;
    //             $CheckoutOrder_store->order_status = 'unpaid';
    //             $CheckoutOrder_store->created_time = $order_time;
    //             $CheckoutOrder_store->save();
    
    //             $update_StreamingOrder_OrderId = StreamingOrder::where('uid', '=', $uid)->update(['order_id' => $order_id]);
    //             $update_ShopOrder_OrderId = ShopOrder::where('uid', '=', $uid)->update(['order_id' => $order_id]);
    
    //             $item++; 
    //         }
            
    //         return redirect()->route('checkout_form', ['order_id' => $order_id]);
    //         }
    //         else
    //         {
    //             return redirect()->back()->with('alert', '請選擇商品進行結帳！');
    //         }
    //     }
    //     else
    //     {
    //        return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
    //     }
    //  }
 
     //結帳頁面讀取(填寫資料)
     public function CheckoutForm(Request $request)
     {
         if (Gate::allows('seller-only',  Auth::user())) {
            if($request->has('goods')){
             

                return view('checkout', ['order' => $request->input('goods')]);
            }
            else
            {
                return redirect()->back()->with('alert', '請選擇商品進行結帳！');
            }
           
            
         }
         else
         {
            return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
         }
     }
}