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


class StreamingProductController extends Controller
{
    //設定直播商品頁面讀取
    public function SetStreamingProduct_show(Request $request)
    {
        
        return view('set_streaming_product');
    }
 
     //設定直播商品
    public function SetStreamingProduct(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
    
            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,dng,png,jpg,gif,svg|max:10000',
            ]);
            
            if($request->hasFile('image'))
            {
                $image=Imgur::upload($request->image);
    
                $goods_name=$request->input("name");
                $description=$request->input("description");
                $price=$request->input("price");
                $num=$request->input("num");
                //存入資料庫
               
                $StreamingProduct = new StreamingProduct();
                $StreamingProduct->page_id = $page_id;
                $StreamingProduct->goods_name = $goods_name;
                $StreamingProduct->goods_price = $price;
                $StreamingProduct->goods_num =  $num;
                $StreamingProduct->description =  $description;
                $StreamingProduct->pic_url = $image->link();
                $StreamingProduct->save();
    
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

    //直播商品總覽
    public function ProductOverview(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            $query = StreamingProduct::where('page_id', '=', $page_id)->get();

            $countAllProduct=StreamingProduct::where('page_id', '=', $page_id)
            ->count();

            $countOnProduct=StreamingProduct::where('page_id', '=', $page_id)
            ->where('goods_num','>',0 )
            ->count();

            $countOutProduct=StreamingProduct::where('page_id', '=', $page_id)
            ->where('goods_num','=',0 )
            ->count();
            
            return view('streaming_product_overview', ['products' => $query ,'countAllProduct' => $countAllProduct,'countOnProduct' => $countOnProduct,'countOutProduct' => $countOutProduct]);
        }
        else
        {
           return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
        }
    }

    //直播商品編輯頁面顯示
    public function EditStreamingProduct_show(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;


            $pic_url=$request->input('key');

            $query = StreamingProduct::where('pic_url', '=', $pic_url)
                    ->first();
            
            return view('streaming_product_edit', ['product' => $query]);
        }
        else
        {
           return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
        }
    }

    
    //直播商品編輯
    public function EditProduct(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $pic_url=$request->input('primary_key');
            $goods_name=$request->input('name');
            $description=$request->input('description');
            $goods_price=$request->input('price');
            $goods_num=$request->input('num');

            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,dng,png,jpg,gif,svg|max:10000',
            ]);
            
            if($request->hasFile('image'))
            {
                $image=Imgur::upload($request->image);
                StreamingProduct::where('pic_url', '=', $pic_url)->update(['pic_url' => $image->link() ]);
            }

            StreamingProduct::where('pic_url', '=', $pic_url)->update([
            'goods_name' => $goods_name,
            'description' => $description,
            'goods_price' => $goods_price,
            'goods_num' => $goods_num ]);
 
            return redirect()->back()->with('alert', '成功!');
        }
        else
        {
           return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
        }
    }

    //直播商品刪除
    public function DeleteProduct(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $pic_url=$request->input('primary_key');
            

            StreamingProduct::where('pic_url', '=', $pic_url)->delete();
 
            return redirect()->route('StreamingProductOverview')->with('alert', '成功!');
        }
        else
        {
           return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
        }
    }
    


}