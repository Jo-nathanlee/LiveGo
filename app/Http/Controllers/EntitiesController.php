<?php

namespace App\Http\Controllers;

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


class EntitiesController extends Controller
{
    public function CreateOrUpdatePage(Request $request)
    {
        $page = $request->input('id');
        $id_name_token = preg_split("/[,]+/", $page);
        $page_id = $id_name_token[0];
        $request->session()->put('page_id', $page_id);
        $page_name = $id_name_token[1];
        $page_token = $id_name_token[2];
        $page_pic = $id_name_token[3];
        $page_store = Page::updateOrCreate(
            ['fb_id' => Auth::user()->fb_id],
            [
                'name' => Auth::user()->name,
                'page_id' => $page_id,
                'page_name' => $page_name,
                'page_pic' => $page_pic,
                'page_token' => $page_token,
            ]
        );
        return redirect('/home');
    }
    //買家購物車
    public function BuyerIndexShow(Request $request)
    {
        $fb_id=Auth::user()->fb_id;
        $query = StreamingOrder::where('fb_id', '=', $fb_id)
                ->whereNull('streaming_order.order_id')
                ->select('page_id','page_name','fb_id','name','goods_name','goods_price','goods_num','total_price','uid')
                ->get();
                 

        $query2 = ShopOrder::where('fb_id', '=', $fb_id) 
                  ->select('page_id','page_name','fb_id','name','goods_name','goods_price','goods_num','total_price','uid')
                  ->get();

        $cart=$query->union($query2);
        $cart=$cart->groupBy('page_name');
        


        return view('buyer_index', ['shopping_cart' => $cart]);
    }
    //賣家得標清單查看
    public function BidWinnerShow(Request $request)
    {
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;

        $query = StreamingOrder::where('page_id', '=', $page_id)
                ->whereNull('streaming_order.order_id')
                ->select('name','goods_name','goods_price','goods_num','total_price','comment','created_time','note')
                ->get();

        return view('bid_winner', ['winner' => $query]);
    }
    //賣家訂單查看------------------------------------------------------------------------
    public function SellerOrderAll(Request $request)//全部訂單
    {
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;
        $query = CheckoutOrder::where('page_id', '=', $page_id)
                ->select('fb_id','name','goods_name','goods_price','goods_num','total_price','order_status')
                ->get();
        $countAllOrder=CheckoutOrder::where('page_id', '=', $page_id)
        ->count();
        $countUnpaidOrder=CheckoutOrder::where('page_id', '=', $page_id)
        ->where('order_status', '=', 'unpaid')
        ->count();
        $countUndeliveredOrder=CheckoutOrder::where('page_id', '=', $page_id)
        ->where('order_status', '=', 'undelivered')
        ->count();   
        $countDeliveredOrder=CheckoutOrder::where('page_id', '=', $page_id)
        ->where('order_status', '=', 'delivered')
        ->count();     
        $countFinishedOrder=CheckoutOrder::where('page_id', '=', $page_id)
        ->where('order_status', '=', 'finished')
        ->count();  
        $countCanceledOrder=CheckoutOrder::where('page_id', '=', $page_id)
        ->where('order_status', '=', 'canceled')
        ->count();          
                      

        return view('seller_order', ['order' => $query,'countAllOrder' => $countAllOrder,'countUnpaidOrder' => $countUnpaidOrder,'countUndeliveredOrder' => $countUndeliveredOrder,'countDeliveredOrder' => $countDeliveredOrder,'countFinishedOrder' => $countFinishedOrder,'countCanceledOrder' => $countCanceledOrder]);
    }

    public function SellerOrderUnpaid(Request $request)//未付款訂單
    {
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;
        $query = CheckoutOrder::where('page_id', '=', $page_id)
                ->where()
                ->select('fb_id','name','goods_name','goods_price','goods_num','total_price','order_status')
                ->get();

        return view('seller_order', ['order' => $query]);
    }

    public function SellerOrderUndelivered(Request $request)//未出貨訂單
    {
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;
        $query = CheckoutOrder::where('page_id', '=', $page_id)
                ->where()
                ->select('fb_id','name','goods_name','goods_price','goods_num','total_price','order_status')
                ->get();

        return view('seller_order', ['order' => $query]);
        
    }

    public function SellerOrderDelivered(Request $request)//運送中訂單
    {
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;
        $query = CheckoutOrder::where('page_id', '=', $page_id)
                ->where()
                ->select('fb_id','name','goods_name','goods_price','goods_num','total_price','order_status')
                ->get();

        return view('seller_order', ['order' => $query]);
        
    }

    public function SellerOrderFinished(Request $request)//已完成訂單
    {
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;
        $query = CheckoutOrder::where('page_id', '=', $page_id)
                ->where()
                ->select('fb_id','name','goods_name','goods_price','goods_num','total_price','order_status')
                ->get();

        return view('seller_order', ['order' => $query]);
        
    }

    public function SellerOrderCanceled(Request $request)//已取消訂單
    {
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;
        $query = CheckoutOrder::where('page_id', '=', $page_id)
                ->where()
                ->select('fb_id','name','goods_name','goods_price','goods_num','total_price','order_status')
                ->get();

        return view('seller_order', ['order' => $query]);
        
    }
    //------------------------------------------------------------------------------------------------------------
    //填寫完結帳資料後產生訂單
    public function CheckOut(Request $request)
    {
      
        $item=1;
        $order_id;
        $order_time;
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

            //產生訂單編號
            if($item==1)
            {
                $time_stamp=time();
                $random_num=rand(10,99);
                $order_id=$fb_id.time().$random_num;
                $order_time=date("Y-m-d H:i:s");
            }

        


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
            $CheckoutOrder_store->order_status = 'unpaid';
            $CheckoutOrder_store->created_time = $order_time;
            $CheckoutOrder_store->save();

            $update_StreamingOrder_OrderId = StreamingOrder::where('uid', '=', $uid)->update(['order_id' => $order_id]);
            $update_ShopOrder_OrderId = ShopOrder::where('uid', '=', $uid)->update(['order_id' => $order_id]);

            $item++; 
        }
        
        return redirect()->route('checkout_form', ['order_id' => $order_id]);
    }

    //結帳頁面讀取
    public function CheckoutForm(Request $request)
    {
        $order_id=$request->input('order_id');
        $query = CheckoutOrder::where('order_id', '=', $order_id)
                ->get();
        return view('checkout', ['order' => $query]);
    }

    //新增商城商品頁面讀取
    public function AddProduct_show(Request $request)
    {
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;

        $query = ProductCategories::where('page_id', '=', $page_id)
                ->get();
        return view('add_product', ['categories' => $query]);
    }

    //編輯商城商品頁面讀取
    public function EditProduct_show(Request $request)
    {
        $pic_url=$request->input('key');

        $query = Shop::where('pic_url', '=', $pic_url)
                ->get();
        




        return view('edit_product', ['product' => $query]);
    }
    
    //Edit商城商品
    public function EditProduct(Request $request)
    {
        $pic_url=$request->input('key');

        $query = Shop::where('pic_url', '=', $pic_url)
                ->get();
        




        return redirect()->back()->with('alert', '成功!');
    }

    //Insert商城商品
    public function AddNewProduct(Request $request)
    {
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;

        //驗證是否為圖片檔
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,dng,png,jpg,gif,svg|max:10000',
          ]);

        if($request->hasFile('image'))
        {
            $image=Imgur::upload($request->image);

            $goods_name=$request->input("name");
            $category=$request->input("category");
            $description=$request->input("description");
            $price=$request->input("price");
            $num=$request->input("num");
            $status=$request->input("status");
            //存入資料庫
            $shop = new Shop();
            $shop->page_id = $page_id;
            $shop->goods_name = $goods_name;
            $shop->category = $category;
            $shop->goods_price = $price;
            $shop->goods_num =  $num;
            $shop->description =  $description;
            $shop->pic_url = $image->link();
            $shop->status=$status;
            $shop->save();

            return redirect()->back()->with('alert', '成功!');
        }
        else
        {
            return redirect()->back()->with('alert', '失敗!');
        }
    }

    //設定直播商品頁面讀取
    public function SetStreamingProduct_show(Request $request)
    {
        
        return view('set_streaming_product');
    }

    //設定直播商品
    public function SetStreamingProduct(Request $request)
    {
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;

        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,dng,png,jpg,gif,svg|max:10000',
          ]);
         
        if($request->hasFile('image'))
        {
            $filename= $request->$image->getClientOriginalName();
            $uni_filename=$page_id.uniqid().$filename;
            
            $request->$image->storeAs('public/upload',$uni_filename);
            

            $goods_name=$request->input("name");
            $description=$request->input("description");
            $price=$request->input("price");
            $num=$request->input("num");

            $StramingProduct = new StramingProduct();

            $StramingProduct->page_id = $page_id;
            $StramingProduct->goods_name = $goods_name;
            $StramingProduct->goods_price = $price;
            $StramingProduct->goods_num =  $num;
            $StramingProduct->description =  $description;
            $StramingProduct->pic_url =  $uni_filename;
           
            $StramingProduct->save();

            return redirect()->back()->with('alert', '成功!');
        }
        else
        {
            return redirect()->back()->with('alert', '失敗!');
        }
    }

    //賣場商品總覽(賣家)
    public function ProductOverview(Request $request)
    {
       
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;
        $query = Shop::where('page_id', '=', $page_id)->get();
       
       
       
        return view('product_overview', ['products' => $query]);
    }

    //商城顯示
    public function ShowMall(Request $request)
    {
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;

        $query = Shop::where('page_id', '=', $page_id)->get();


        return view('shopping_mall', ['products' => $query]);
    }

}
