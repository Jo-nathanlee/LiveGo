<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use DB;
use App\Entities\Page;
use App\Entities\PageDetail;
use App\Entities\StreamingProduct;
use App\Entities\StreamingOrder;
use App\Entities\Member;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;

class ShopController extends Controller
{
    public function ShowShop(Request $request)//商城顯示
    {
        $page_id = $request->input('page_id');
        $page_name = Page::where('page_id', '=', $page_id)->first();
        $page_name = $page_name['page_name'];
        $page_token = Page::where('page_id', '=', $page_id)->first();
        $page_token = $page_token['page_token'];

        $if_streaming = $this->LiveVideo($page_id, $page_token);
        $query = StreamingProduct::where('page_id', '=', $page_id)
                ->where('shop', '=', 'true')
                ->where('goods_num', '>', 0)
                ->where('is_delete', 0)
                ->select('goods_key','goods_name','pic_url','updated_at','goods_num','goods_price',
                         DB::raw('sum(goods_num) as total_num'),DB::raw('sum(pre_sale) as pre_sale'))
                ->groupBy('goods_key')
                ->get();

        $product_count = DB::table('streaming_product')->where('page_id', '=', $page_id)
                ->where('shop', '=', 'true')
                ->where('goods_num', '>', 0)
                ->where('is_delete', 0)
                ->select('goods_key','goods_name',DB::raw('sum(goods_num) as total_num'))
                ->distinct()
                ->groupBy('goods_key')
                ->count();

        $ps_id = Member::where('as_id', Auth::user()->fb_id)->where('page_id',$page_id)->first();
        $ps_id = $ps_id['ps_id'];


        return view('shop', ['page_id' => $page_id, 'ps_id' => $ps_id,'products' => $query, 'product_count' => $product_count,'page_name' => $page_name, 'if_streaming' => $if_streaming]);
    }

    public function ShopProduct(Request $request)//商品詳細資訊
    {
        $page_id = $request->input('page_id');
        $goods_key = $request->input('goods_key');
        $query = StreamingProduct::where('page_id', '=', $page_id)
                ->where('goods_key', '=', $goods_key)
                ->get();

        return $query;
    }

    public function LiveVideo($page_id, $token)
    {
        ini_set("allow_url_fopen", 1);
        $live_video = file_get_contents("https://graph.facebook.com/".$page_id."?fields=live_videos.limit(1){video,status,embed_html},id%7Bid%7D&access_token=".$token);
        $live_video = json_decode($live_video, true);

        //判斷粉專是否正在直播
        if (isset($live_video['live_videos']) && $live_video['live_videos']['data'][0]['status']=='LIVE') {
            return true;
        } else {
            return false;
        }
    }

    public function AddToCart(Request $request)
    {
        $page_id = $request->input('page_id');
        $as_id = Auth::user()->fb_id;
        $goods_num = $request->input('goods_num');
        $bid_price = $request->input('bid_price');
        $product_id = $request->input('product_id');

        $member = Member::where('as_id',$as_id)
        ->where('page_id',$page_id)
        ->first();

        $ps_id = $member->ps_id;

        if(isset($page_id, $goods_num, $bid_price, $product_id)){

            $StreamingProduct = StreamingProduct::where('page_id',$page_id)
            ->where('product_id',$product_id)
            ->first();

            if($goods_num <= ($StreamingProduct->goods_num-$StreamingProduct->pre_sale))
            {
                //存入DB
                $cart_save = new StreamingOrder();
                $cart_save->page_id = $page_id;
                $cart_save->ps_id = $ps_id;
                $cart_save->goods_num = $goods_num;
                $cart_save->bid_price = $bid_price;
                $cart_save->product_id = $product_id;
                $cart_save->save();

                $update = StreamingProduct::where('page_id',$page_id)
                ->where('product_id',$product_id)
                ->increment('pre_sale',$goods_num);

                return '1';
            }
            else
            {
                return '0';
            }   
        }
        
    }

    public function getMart_area(Request $request){

        $contry = $request->input('contry');
        $mart =  $request->input('sel_wh_cart');
        $list=[];

        if($mart =='7-11'){
            $query = DB::table('store_711' )
            ->where( 'store_address','LIKE',$contry.'%')
            ->get();
            foreach( $query as $area){
                $list[ mb_substr($area->store_address, 3, 3,"utf-8")]= array(
                    'area' => mb_substr($area->store_address, 3, 3,"utf-8"),
                );
            }
        }else if($mart =="全家"){
            $query = DB::table('store_family' )
            ->where( 'store_address','LIKE',$contry.'%')
            ->get();
            foreach( $query as $area){
                $list[ mb_substr($area->store_address, 3, 3,"utf-8")]= array(
                    'area' => mb_substr($area->store_address, 3, 3,"utf-8"),
                );
            }
        }elseif ($mart =="OK") {
            $query = DB::table('store_ok' )
            ->where( 'store_address','LIKE',$contry.'%')
            ->get();
            foreach( $query as $area){
                $list[ mb_substr($area->store_address, 3, 3,"utf-8")]= array(
                    'area' => mb_substr($area->store_address, 3, 3,"utf-8"),
                );
            }
        }else{
            $query = DB::table('store_hilife' )
            ->where( 'store_address','LIKE','%'.$contry.'%')
            ->get();
            foreach( $query as $area){
                $list[ mb_substr($area->store_address, 6, 3,"utf-8")]= array(
                    'area' => mb_substr($area->store_address, 6, 3,"utf-8"),
                );
            }
        }

        



        return json_encode($list);

    }

    public function getMart_address(Request $request){

        $contry = $request->input('contry');
        $area = $request->input('area');
        $mart =  $request->input('sel_wh_cart');

        if($mart =='7-11'){
            $query = DB::table('store_711' )
            ->where( 'store_address','LIKE',$contry.$area.'%')
            ->get();
        }else if($mart =="全家"){
            $query = DB::table('store_family' )
            ->where( 'store_address','LIKE',$contry.$area.'%')
            ->get();
        }elseif ($mart =="OK") {
            $query = DB::table('store_ok' )
            ->where( 'store_address','LIKE',$contry.$area.'%')
            ->get();
        }else{
            $query = DB::table('store_hilife' )
            ->where( 'store_address','LIKE','%'.$contry.$area.'%')
            ->get();
        }
        return json_encode($query);

    }


    public function Remittance(Request $request){
        $page_id = $request->input('page_id');

        $ps_id = Member::where('as_id', Auth::user()->fb_id)->first();
        $ps_id = $ps_id['ps_id'];

        $data = PageDetail::where('page_id', $page_id)->first();
        $page = Page::where('page_id', $page_id)->first();

        return view('remittance',['bank_data' => $data,'page_name' => $page['page_name'], 'page_id' => $page_id, 'ps_id' => $ps_id]);

    }

    public function show_BuyerDefault(Request $request){
        $page_id = $request->input('page_id');

        return view('buyer_default',['page_id' => $page_id]);

    }
}