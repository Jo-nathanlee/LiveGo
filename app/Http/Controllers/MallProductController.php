<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use App\Entities\Page;
use App\Entities\Shop;
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


class MallProductController extends Controller
{
    //新增商城商品頁面讀取
    public function AddProduct_show(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;

            $query = ProductCategories::where('page_id', '=', $page_id)
                    ->get();
            return view('add_product', ['categories' => $query]);
        }
        else
        {
           return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
        }
    }


    //編輯商城商品頁面讀取
    public function EditProduct_show(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;

            $categories = ProductCategories::where('page_id', '=', $page_id)
            ->get();

            $pic_url=$request->input('key');

            $query = Shop::where('pic_url', '=', $pic_url)
                    ->get();
            
            return view('edit_product', ['product' => $query,'categories' => $categories]);
        }
        else
        {
           return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
        }
    }
    
    //Edit商城商品
    public function EditProduct(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $pic_url=$request->input('primary_key');

            $query = Shop::where('pic_url', '=', $pic_url)
                    ->get();
 
            return redirect()->back()->with('alert', '成功!');
        }
        else
        {
           return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
        }
    }

    //Insert商城商品
    public function AddNewProduct(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
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
        else
        {
           return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
        }
    }

    //賣場商品總覽(賣家)
    public function ProductOverview(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            $query = Shop::where('page_id', '=', $page_id)->get();
            
            return view('product_overview', ['products' => $query]);
        }
        else
        {
           return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
        }
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