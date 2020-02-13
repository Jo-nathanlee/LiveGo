<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Entities\Page;
use App\Entities\StreamingProduct;
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
use PhpImap\ConnectionException;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersImport;
use App\Exports\UsersExport;

class StreamingProductController extends Controller
{
    //設定直播商品頁面讀取
    public function SetStreamingProduct_show(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {

            return view('set_streaming_product');
        }
        else
        {
           return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }

        
    }

    //Add直播商品
    public function SetStreamingProduct(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;

            $validatedData = $request->validate([
                'name' => 'required|string|max:10',
                'description' => 'string|max:255|nullable', //備註可null
                'category' => 'string|max:255|nullable',    //規格可null
                'price' => 'required|regex:/^[0-9]+$/|max:20',
                'num' => 'required|regex:/^[0-9]+$/|max:11',
                'image' => 'is_pngORjpeg',
            ]);

            try {
                $image = Imgur::upload($request->image);

                $goods_name = $request->input("name");
                $description = $request->input("description");
                $price = $request->input("price");
                $num = $request->input("num");
                $category = $request->input("category");
                //存入資料庫
                if ($category == null) {
                    $category = "empty";
                }
                $StreamingProduct = new StreamingProduct();
                $StreamingProduct->page_id = $page_id;
                $StreamingProduct->goods_name = $goods_name;
                $StreamingProduct->goods_price = $price;
                $StreamingProduct->goods_num =  $num;
                $StreamingProduct->description =  $description;
                $StreamingProduct->category =  $category;
                $StreamingProduct->pic_url = $image->link();
                $StreamingProduct->is_active = 'true';
                $StreamingProduct->save();

                return redirect()->back()->with('success', '新增商品成功！');
            } catch (\Exception $e) {
                return redirect()->back()->with('fail', '請確認上傳檔案為圖檔');
            }
        } else {
            return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
    }

    //直播商品總覽
    public function ProductOverview(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;

            //商品總數
            $countAllProduct = StreamingProduct::where('page_id', '=', $page_id)
                ->where('is_active', '=', 'true')
                ->count();
            
            if($countAllProduct == 0){
                //新增假資料
                $StreamingProduct = new StreamingProduct();
                $StreamingProduct->page_id = $page_id;
                $StreamingProduct->goods_name = 'Live_Go';
                $StreamingProduct->goods_price = '100';
                $StreamingProduct->goods_num = 10;
                $StreamingProduct->description = '教學用，新增一樣商品即可自行刪除';
                $StreamingProduct->category =  '大';
                $StreamingProduct->pic_url = 'https://graph.facebook.com/321923508505733/picture';
                $StreamingProduct->is_active = 'true';
                $StreamingProduct->save();

                $query = StreamingProduct::where('page_id', '=', $page_id)->where('is_active', '=', 'true')->get();
            }else{
                $query = StreamingProduct::where('page_id', '=', $page_id)->where('is_active', '=', 'true')->get();
            }
            
            $countOnProduct = StreamingProduct::where('page_id', '=', $page_id)
                ->where('goods_num', '>', 0)
                ->where('is_active', '=', 'true')
                ->count();

            $countOutProduct = StreamingProduct::where('page_id', '=', $page_id)
                ->where('goods_num', '=', 0)
                ->where('is_active', '=', 'true')
                ->count();

            return view('streaming_product_overview', ['products' => $query, 'countAllProduct' => $countAllProduct, 'countOnProduct' => $countOnProduct, 'countOutProduct' => $countOutProduct]);
        } else {
            return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
    }

    public function ProductOverviewOn(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            $query = StreamingProduct::where('page_id', '=', $page_id)
                ->where('is_active', '=', 'true')
                ->where('goods_num', '>', 0)
                ->get();

            $countAllProduct = StreamingProduct::where('page_id', '=', $page_id)
                ->where('is_active', '=', 'true')
                ->count();

            $countOnProduct = StreamingProduct::where('page_id', '=', $page_id)
                ->where('is_active', '=', 'true')
                ->where('goods_num', '>', 0)
                ->count();

            $countOutProduct = StreamingProduct::where('page_id', '=', $page_id)
                ->where('is_active', '=', 'true')
                ->where('goods_num', '=', 0)
                ->count();

            return view('streaming_product_overview', ['products' => $query, 'countAllProduct' => $countAllProduct, 'countOnProduct' => $countOnProduct, 'countOutProduct' => $countOutProduct]);
        } else {
            return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
    }

    public function ProductOverviewOut(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            $query = StreamingProduct::where('page_id', '=', $page_id)
                ->where('is_active', '=', 'true')
                ->where('goods_num', '=', 0)
                ->get();

            $countAllProduct = StreamingProduct::where('page_id', '=', $page_id)
                ->where('is_active', '=', 'true')
                ->count();

            $countOnProduct = StreamingProduct::where('page_id', '=', $page_id)
                ->where('is_active', '=', 'true')
                ->where('goods_num', '>', 0)
                ->count();

            $countOutProduct = StreamingProduct::where('page_id', '=', $page_id)
                ->where('is_active', '=', 'true')
                ->where('goods_num', '=', 0)
                ->count();

            return view('streaming_product_overview', ['products' => $query, 'countAllProduct' => $countAllProduct, 'countOnProduct' => $countOnProduct, 'countOutProduct' => $countOutProduct]);
        } else {
            return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
    }


    //直播商品編輯頁面顯示
    public function EditStreamingProduct_show(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {

            $validatedData = $request->validate([
                'product_id' => 'required|regex:/^[0-9]+$/|max:10',
            ]);

            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;

            $product_id = $request->input('product_id');

            $query = StreamingProduct::where('product_id', '=', $product_id)
                    ->where('page_id', '=', $page_id)
                    ->first();

            if(!$query){
                //查無此product_id
                return redirect()->route('StreamingProductOverview')->with('fail', '查無此商品！');
            }

            if ($query->category == "empty") {
                $category = "";
            } else {
                $category = $query->category; 
            }
            return view('streaming_product_edit', ['product' => $query, 'category' => $category]);
        } else {
            return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
    }


    //直播商品編輯
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
                    StreamingProduct::where('product_id', '=', $product_id)->update([
                        'goods_name' => $goods_name,
                        'description' => $description,
                        'goods_price' => $goods_price,
                        'goods_num' => $goods_num,
                        'category' => $category,
                        'pic_url' => $pic_url
                    ]);
                    return redirect()->back()->with('success', '修改圖片成功!'); //不再使用pic_url當key，所以route()改成back()，不然success會跑不出來
                } else {
                    StreamingProduct::where('product_id', '=', $product_id)->update([
                        'goods_name' => $goods_name,
                        'description' => $description,
                        'goods_price' => $goods_price,
                        'category' => $category,
                        'goods_num' => $goods_num
                    ]);
                }

                return redirect()->back()->with('success', '修改商品成功！');
            } catch (\Exception $e) {
                return redirect()->back()->with('fail', '請確認上傳檔案為圖檔');
            }
        } else {
            return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
    }

    //直播商品刪除
    public function DeleteProduct(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            
            $validatedData = $request->validate([
                'primary_key' => 'required|regex:/^[0-9]+$/|max:10',
            ]);

            $product_id = $request->input('primary_key');

            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;

            $delete = StreamingProduct::where('product_id', '=', $product_id)->where('page_id', '=', $page_id)->update([
                        'is_active' => 'false'
                    ]);

            if($delete){
                return redirect()->route('StreamingProductOverview')->with('success', '刪除商品成功！');
            }else{
                return redirect()->route('StreamingProductOverview')->with('fail', '刪除商品失敗！');
            }

        } else {
            return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }
    }


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
                            $StreamingProduct = new StreamingProduct();
                            $StreamingProduct->page_id = $page->page_id;
                            //imgur 網址.png 才能顯示圖檔
                            $StreamingProduct->pic_url = $data[0][$Column][0].'.png';
                            $StreamingProduct->goods_name = $data[0][$Column][1];
                            $StreamingProduct->goods_price = $data[0][$Column][2];
                            $StreamingProduct->goods_num =  $data[0][$Column][3];
                            $StreamingProduct->description =  $data[0][$Column][5];
                            $StreamingProduct->category =  $data[0][$Column][4];
                            $StreamingProduct->is_active =  'true';
                            $StreamingProduct->save();
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
