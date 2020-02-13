<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use App\Entities\Page;
use App\Entities\PageDetail;
use App\Entities\ShopProduct;
use App\Entities\ShopOrder;
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
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersImport;


class MallProductController extends Controller
{
    //新增商城商品頁面讀取 // finish 20190820
    public function AddProduct_show(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {

            return view('add_product');
        }
        else
        {
           return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
    }


    //編輯商城商品頁面讀取 // finish 20190820
    public function EditProduct_show(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {

            $validatedData = $request->validate([
                'key' => 'required|regex:/^[0-9]+$/|max:10',
            ]);

            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;

            $product_id=$request->input('key');

            $query = ShopProduct::where('product_id', '=', $product_id)
                    ->first();

            if(!$query){
                //查無此product_id
                return redirect()->route('product_overview')->with('fail', '查無此商品！');
            }

            if ($query->category == "empty") {
                $category = "";
            } else {
                $category = $query->category; 
            }

            return view('edit_product', ['product' => $query, 'category' => $category]);
        }
        else
        {
           return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
    }

    //Edit商城商品 //20190820 finish
    public function EditProduct(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {

            $validatedData = $request->validate([
                'product_id' => 'required|regex:/^[0-9]+$/|max:10',
                'name' => 'required|string|max:60',
                'description' => 'string|max:255|nullable',
                'category' => 'string|max:255|nullable',
                'price' => 'required|regex:/^[0-9]+$/|max:20',
                'num' => 'required|regex:/^[0-9]+$/|max:11',
                'new_pic' => 'is_pngORjpeg|nullable',
            ]);

            $pic_url=$request->input('new_pic');
            $goods_name=$request->input('name');
            $description=$request->input('description');
            $category=$request->input('category');
            $goods_price=$request->input('price');
            $goods_num=$request->input('num');
            $product_id=$request->input('product_id');

            try {
                $product_id = $request->input('product_id');
                $goods_name = $request->input('name');
                $description = $request->input('description');
                $category = $request->input('category');
                $goods_price = $request->input('price');
                $goods_num = $request->input('num');

                if ($category == null) {
                    $category = "empty";
                }

                if ($request->input('new_pic')) {
                    //有更新圖片
                    $image = Imgur::upload($request->new_pic);
                    $pic_url = $image->link();
                    ShopProduct::where('product_id', '=', $product_id)->update([
                        'goods_name' => $goods_name,
                        'description' => $description,
                        'category' => $category,
                        'goods_price' => $goods_price,
                        'pic_url' => $pic_url,
                        'goods_num' => $goods_num 
                    ]);
                    return redirect()->back()->with('success', '修改圖片成功!'); //不再使用pic_url當key，所以route()改成back()，不然success會跑不出來
                } else {
                    //沒更新圖片
                    ShopProduct::where('product_id', '=', $product_id)->update([
                        'goods_name' => $goods_name,
                        'description' => $description,
                        'category' => $category,
                        'goods_price' => $goods_price,
                        'goods_num' => $goods_num 
                    ]);
                }

                return redirect()->back()->with('success', '修改商品成功！');
            } catch (\Exception $e) {
                return redirect()->back()->with('fail', '請確認上傳檔案為圖檔');
            }

        }
        else
        {
           return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
    }

    //刪除商品 //finish 20190820 
    public function DeleteProduct(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {

            $validatedData = $request->validate([
                'primary_key' => 'required|regex:/^[0-9]+$/|max:10',
            ]);

            $product_id=$request->input('primary_key');

            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;

            $delete = ShopProduct::where('product_id', '=', $product_id)->where('page_id', '=', $page_id)->update([
                'is_active' => 'false'
            ]);

            if($delete){
                return redirect()->route('product_overview')->with('success', '刪除商品成功!');
            }else{
                return redirect()->route('product_overview')->with('fail', '刪除商品失敗！');
            }
            
        }
        else
        {
           return redirect('/')->with('fail', '內部連線錯誤，請稍後再試！');
        }
    }



    //Insert商城商品 //finish 20190820
    public function AddNewProduct(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;

            $validatedData = $request->validate([
                'name' => 'required|string|max:10',
                'category' => 'string|max:255|nullable',    //分類可null
                'description' => 'string|max:255|nullable', //備註可null
                'price' => 'required|regex:/^[0-9]+$/|max:20',
                'num' => 'required|regex:/^[0-9]+$/|max:11',
                'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
            ]);

            try {
                $image=Imgur::upload($request->image);

                $goods_name=$request->input("name");                
                $description=$request->input("description");
                $price=$request->input("price");
                $num=$request->input("num");
                $category=$request->input("category");

                if ($category == null) {
                    $category = "empty";
                }

                //存入資料庫
                $shop = new ShopProduct();
                $shop->page_id = $page_id;
                $shop->goods_name = $goods_name;
                $shop->category = $category;
                $shop->goods_price = $price;
                $shop->goods_num =  $num;
                $shop->description =  $description;
                $shop->pic_url = $image->link();
                $shop->is_active = 'true';
                $shop->save();

                return redirect()->back()->with('success', '新增商品成功！');
            }
            catch (Exception $e) {
                return redirect()->back()->with('fail', '請確認上傳檔案為圖檔');
            }
        }
        else
        {
           return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
    }

    //賣場商品總覽(賣家) //finish 20190820
    public function ProductOverview(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            $query = ShopProduct::where('page_id', '=', $page_id)
            ->where('is_active','=', 'true')
            ->get();

            $countAllProduct=ShopProduct::where('page_id', '=', $page_id)
            ->where('is_active','=', 'true')
            ->count();

            //如果是新賣家，顯示假資料
            if(count($query) == 0) {
                $query = ShopProduct::where('page_id', '=', '00000000')->get();
            }

            

            $countOnProduct=ShopProduct::where('page_id', '=', $page_id)
            ->where('goods_num','>',0 )
            ->where('is_active','=', 'true')
            ->count();

            $countOutProduct=ShopProduct::where('page_id', '=', $page_id)
            ->where('goods_num','=',0 )
            ->where('is_active','=', 'true')
            ->count();

            return view('product_overview', ['products' => $query,'countAllProduct' => $countAllProduct,'countOnProduct' => $countOnProduct,'countOutProduct' => $countOutProduct]);
        }
        else
        {
           return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
    }

    //賣場已上架商品總攬 //finish 20190820
    public function ProductOverviewOn(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            $query = ShopProduct::where('page_id', '=', $page_id)
            ->where('goods_num','>',0 )
            ->where('is_active','=', 'true')
            ->get();

            $countAllProduct=ShopProduct::where('page_id', '=', $page_id)
            ->where('is_active','=', 'true')
            ->count();

            $countOnProduct=ShopProduct::where('page_id', '=', $page_id)
            ->where('goods_num','>',0 )
            ->where('is_active','=', 'true')
            ->count();

            $countOutProduct=ShopProduct::where('page_id', '=', $page_id)
            ->where('goods_num','=',0 )
            ->where('is_active','=', 'true')
            ->count();

            return view('product_overview', ['products' => $query,'countAllProduct' => $countAllProduct,'countOnProduct' => $countOnProduct,'countOutProduct' => $countOutProduct]);
        }
        else
        {
           return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
    }

    //賣場已售完商品總攬 //finish 20190820
    public function ProductOverviewOut(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            $query = ShopProduct::where('page_id', '=', $page_id)
            ->where('goods_num','=',0 )
            ->where('is_active','=', 'true')
            ->get();

            $countAllProduct=ShopProduct::where('page_id', '=', $page_id)
            ->where('is_active','=', 'true')
            ->count();

            $countOnProduct=ShopProduct::where('page_id', '=', $page_id)
            ->where('goods_num','>',0 )
            ->where('is_active','=', 'true')
            ->count();

            $countOutProduct=ShopProduct::where('page_id', '=', $page_id)
            ->where('goods_num','=',0 )
            ->where('is_active','=', 'true')
            ->count();

            return view('product_overview', ['products' => $query,'countAllProduct' => $countAllProduct,'countOnProduct' => $countOnProduct,'countOutProduct' => $countOutProduct]);
        }
        else
        {
           return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
    }

    //商城顯示 //finish 20190820
    public function ShowMall(Request $request)
    {
        $page_id = $request->input('page_id');
        $request->session()->put('page_id',$page_id);
        $query = ShopProduct::where('page_id', '=', $page_id)
                            ->where('is_active', '=', 'true')
                            ->where('goods_num', '>', 0)
                            ->get();

        $companyInfo = PageDetail::where('page_id','=',$page_id)
        ->first();

        return view('shopping_mall', ['page_id' => $page_id,'products' => $query,'address' => $companyInfo->company_address,'phone' => $companyInfo->company_phone]);
    }

    //加價購商品詳細資料頁 //finish 20190820
    public function ShowMall_Detail(Request $request)
    {
        $page_id = $request->input('page_id');
        $request->session()->put('page_id',$page_id);
        $product_id = $request->input('key');

        $query = ShopProduct::where('product_id','=',$product_id)
        ->where('page_id','=',$page_id)
        ->first();

        $recommend =  ShopProduct::where('page_id','=',$page_id)
        ->get();

        return view('shopping_mall_detail', ['product' =>  $query , 'recommend' => $recommend,'page_id' => $page_id ]);
    }

    //搜尋商城 //finish 20190820
    public function SearchMall(Request $request)
    {
        $page_id =  $request->input('page_id');
        

        $search_string = $request->input('search_string');

        $query = ShopProduct::where('page_id', '=', $page_id)->where('goods_name', 'LIKE', '%'.$search_string.'%')->get();

        $companyInfo = PageDetail::where('page_id','=',$page_id)
        ->first();


        return view('shopping_mall', ['page_id' => $page_id,'products' => $query,'address' => $companyInfo->company_address,'phone' => $companyInfo->company_phone]);
    }

    //網紅
    public function InternetCelebrityMatch(Request $request)
    {

        return view('InternetCelebrityMatch');
    }

    //商城-加入購物車 //20190820 不懂
    public function ShowMall_Addcart(Request $request)
    {
        $page_id = $request->input('page_id');
        $page =Page::where('page_id','=',$page_id)->first();
        $page_name =  $page->page_name;
        $fb_id = Auth::user()->fb_id;
        $goods_name=$request->input('goods_name');
        $goods_price=$request->input('goods_price');
        $goods_num =$request->input('num');
        $created_time =date('Y-m-d H:i:s');
        $TotalPriceCount = $goods_price*$goods_num;
        $total_price=$TotalPriceCount;
        $pic_url=$request->input('pic_url');
        $product_id = $request->input('product_id');
        

        $goods_counts = $goods_num;
        $if_sold_out = ShopProduct::where('product_id','=',$product_id)
                            ->first();
        $shop_goods_counts = $if_sold_out->goods_num;

        if($goods_counts>$shop_goods_counts){
            return redirect()->back()->with('fail', '加入購物車失敗!。<br><small>商品庫存不足。</small>');
        }else{
            //產生uid
            $time_stamp=time();
            $random_num=rand(100,999);
            $uid=$fb_id.time().$random_num;

            $shop_order = new ShopOrder();
            $shop_order->page_id= $page_id;
            $shop_order->fb_id = $fb_id;
            $shop_order->goods_num = $goods_num;
            $shop_order->uid=$uid;
            $shop_order->created_time = $created_time;
            $shop_order->total_price = $total_price;
            $shop_order->product_id = $product_id;

            $shop_order->save();

            // $query = ShopProduct::where('pic_url','=',$pic_url)
            // ->where('page_id','=',$page_id)
            // ->first();

            // $recommend = ShopProduct::where('page_id','=',$page_id)
            // ->get();

            if($if_sold_out['goods_num'] <= 0 ){
                return redirect()->back()->with('fail', '加入購物車失敗!。<br><small>商品庫存不足。</small>');
            }else{
                return redirect()->back()->with('success', '商品已加入購物車。<br><small>提醒您可善用來福加價購獲取免運費。</small>');
            }
        }
         //



        // return view('shopping_mall_detail', ['product' =>  $query , 'recommend' => $recommend,'page_id' => $page_id ])->with('success', '商品已加入購物車。<br><small>提醒您可善用來福加價購獲取免運費。</small>');
    }

    //使用excel檔新增商城商品
    public function Excel_reader(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            
            try {
                $page = Page::where('fb_id', Auth::user()->fb_id)->first();
    
                $path = $request->file('excelupload');
                $data = Excel::toCollection(new UsersImport, $path);
    
                $json_excel = json_encode($data);
                $json_excel = json_decode($json_excel, true);
    
                
                //計算列
                $Columns = count(
                    $data[0]
                );
                $success_num =0; 
                //excel date[0][列][行] 直行橫列
                for ($Column = 1; $Column < $Columns; $Column++) {
                        //驗證商品圖片、商品名稱、商品數量、商品價格是否有值
                        if ($data[0][$Column][0]!=null and $data[0][$Column][1]!=null and $data[0][$Column][2]!=null and $data[0][$Column][3]!=null){
                            
                            //新增資料庫
                            $ShopProduct = new ShopProduct();
                            $ShopProduct->page_id = $page->page_id;
                            //imgur 網址.png 才能顯示圖檔
                            $ShopProduct->pic_url = $data[0][$Column][0].'.png';
                            $ShopProduct->goods_name = $data[0][$Column][1];
                            $ShopProduct->goods_price = $data[0][$Column][2];
                            $ShopProduct->goods_num =  $data[0][$Column][3];
                            $ShopProduct->description =  $data[0][$Column][5];
                            $ShopProduct->category =  $data[0][$Column][4];
                            $ShopProduct->is_active =  'true';
                            $ShopProduct->save();
                            $success_num++;
                        }else{
                            break;
                        }
                        
                    
                }
                if($Columns-$success_num==1){
                    $alter_text="商品全部新增完成！";
                }else{
                    $alter_text="商品前".$success_num."筆已新增完成，未上傳之商品請確認商品圖片、商品名稱、商品數量、商品價格是否填寫！";
                }
                return redirect()->back()->with('success', "新增商品成功！");
            } catch (\Exception $e) {
                return redirect()->back()->with('fail', '請確認上傳檔案為excel檔，或欄位是否填寫錯誤');
            }

        } else {
            return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }

        


        //  return response()->json($data, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    }
}
