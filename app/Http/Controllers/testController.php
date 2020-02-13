<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Entities\Page;
use App\User;
use App\Entities\UpdateUser;
use App\Entities\StreamingOrder;
use App\Entities\PageDetail;
use App\Entities\AuctionList;
use App\Entities\Prize;
use App\Entities\StreamingProduct;
use App\Entities\Member;
use DB;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\ClientException;
use Session;
use DateTime;
use Imgur;
use Yish\Imgur\Upload;
use App\Exports\OrderExport_streaming;
use Maatwebsite\Excel\Facades\Excel;

class testController extends Controller
{
    private $api;
    public function __construct(Facebook $fb)
    {

        $this->middleware(function ($request, $next) use ($fb) {
            $fb->setDefaultAccessToken(Auth::user()->token);
            $this->api = $fb;
            return $next($request);
        });
    }

    public function graphapi($query, $token)
    {
        $response = $this->api->get($query, $token);
        return $response;
    }


    public function GetFacebookComment($video_id, $token)
    {

        $facebook_comment = file_get_contents("https://graph.facebook.com/" . $video_id . "/comments?order=reverse_chronological&limit=9999&fields=can_reply_privately,id,from,message,created_time&access_token=" . $token);
        $facebook_comment = json_decode($facebook_comment, true);
        if (count($facebook_comment) == 1) {
            return "";
        }
        if (count($facebook_comment) >= 2) {
            $facebook_comment = $facebook_comment['data'];

            return $facebook_comment;
        }
    }

    public function graphtime_to_taiwantime($time)
    {
        $time = str_replace('T', " ", $time);
        $time = substr($time, 0, 19);
        //+8小時是因為時間差
        $time = date("Y-m-d H:i:s", strtotime("$time +8 hour"));
        return $time;
    }

    public function index_load()
    {
        $page = Page::where('as_id', Auth::user()->fb_id)->first();
        $fb_id = Auth::user()->fb_id;
        $name = Auth::user()->name;
        $page_id = $page->page_id;
        
        $token = $page->page_token;
        $goods_key = "";
        $index = 0;
        $diverse = 0;

        try {
            $live_video = $this->LiveVideo($page_id, $token);
            if($live_video == null)
            {
                return back();
            }
            $live_video_url =  explode("\"", $live_video['embed_html']);
    
            $goods_list = [];

            $auction_product = StreamingProduct::where('streaming_product.page_id', '=', $page_id)
            ->where('streaming_product.is_delete','0')
            ->join('auction_list', 'streaming_product.product_id', '=', 'auction_list.product_id')
            ->where('auction_list.is_active','true')
            ->where('auction_list.live_video_id', '=', $live_video['id'])
            ->select('streaming_product.*')
            ->get();

            foreach ($auction_product as $data) {
                $bid_num = StreamingOrder::where('page_id', '=', $page_id)
                ->where('product_id',$data->product_id)
                ->where('live_video_id',$live_video['id'])
                ->sum('goods_num');

                $goods_num = ($data->goods_num  - $data->pre_sale) > 0 ?($data->goods_num  - $data->pre_sale):0;

                if($goods_key!=$data->goods_key){
                    $goods_key =$data->goods_key;
                    $index = 1;
                    $diverse = 0;
                    $StreamingProduct = StreamingProduct::where('page_id', '=', $page_id)
                    ->where('is_delete','0')
                    ->where('goods_key', '=', $data->goods_key)
                    ->get();
                    $category = '';
                    foreach($StreamingProduct as $query)
                    {
                        $diverse++;
                        $category .= '('.$query->category . ') ';
                    }
                    if($diverse==1){
                        $category = '<b>'.$query->category. '</b>';
                    }
                }else{
                    $index++;
                }

                $all_category =  $category;

                $goods_list[ $data->keyword ]=array(
                    'pic_url' => $data->pic_url,
                    'goods_key' => $data->goods_key,
                    'goods_name' => $data->goods_name,
                    'keyword' => $data->keyword,
                    'goods_price' => $data->goods_price,
                    'goods_num' => $goods_num,
                    'goods_category' => $data->category,
                    'goods_note' => $data->description,
                    'product_id' => $data->product_id,
                    'bid_times' => $bid_num,
                    'index' => $index,
                    'all_category' => str_replace("(".$data->category.")","<b>(".$data->category.")</b>",$all_category),
                    'diverse' =>$diverse
                );
                
            
            }

            $goods_key = StreamingProduct::where('streaming_product.page_id', '=', $page_id)
            ->where('streaming_product.is_delete','0')
            ->join('auction_list', 'streaming_product.product_id', '=', 'auction_list.product_id')
            ->where('auction_list.live_video_id', '=', $live_video['id'])
            ->select('streaming_product.goods_key')
            ->distinct()
            ->get();

            //陣列3 = width 陣列5 = height  使用這判斷直播裝置
            if ($live_video_url[3] > $live_video_url[5]) {
                $device = 'computer';
            } else {
                $device = 'cellphone';
            }
            return view('streaming_index', ['fb_id' => $fb_id,'name' => $name,'page_id' => $page_id,'goods_key' => $goods_key, 'auction_list' => $goods_list, 'device' => $device, 'url' => $live_video_url[1],'video_id' => $live_video['video']['id'], 'live_video_id' => $live_video['id'], 'token' => $token]);
        } catch (Exception $e) {
            return redirect()->back(); // handle exception
        }
    }

    //直播Main Function
    public function StreamingComment(Request $request)
    {
        $video_id = $request->input('live_video_id');
        $token = $request->input('page_token');
        $page_id = $request->input('page_id');
        $keyword =  DB::table('auction_list')
                    ->where('auction_list.page_id',$page_id)
                    ->where('auction_list.live_video_id',$video_id)
                    ->join('streaming_product','auction_list.product_id','streaming_product.product_id')
                    ->select('streaming_product.keyword')
                    ->get();

        $facebook_comment = $this->GetFacebookComment($video_id, $token);
        if ($facebook_comment != '') {
            $comment_count = 0;
            foreach ($facebook_comment as $comment) {
                //判斷是否封鎖
                $member = Member::where('ps_id', '=',  $comment['from']['id'])
                    ->join('member_type', 'member.member_type', '=', 'member_type.member_type')
                    ->where('page_id', '=', $page_id)
                    ->first();
                if (isset($member)) {
                    $member_type = $member->type_cht;
                } else {
                    $member_type = '';
                }
                $facebook_comment[$comment_count]['member_type'] = $member_type;
                $facebook_comment[$comment_count]['created_time'] = $this->graphtime_to_taiwantime($facebook_comment[$comment_count]['created_time']);

                //判斷是否為回頭客
                $lastday = new DateTime('today -3 day');
                $today = new DateTime('today');
                $streaming_order = StreamingOrder::where('ps_id', '=',  $comment['from']['id'])
                ->whereBetween('streaming_order.created_at', [$lastday, $today])
                ->first();
                if($streaming_order!=null){
                    $facebook_comment[$comment_count]['old_customer'] = true;
                } else {
                    $facebook_comment[$comment_count]['old_customer'] = false;
                }

                //如果為新留言
                if ($comment['from']['id'] != $page_id && $comment['can_reply_privately'] == true && $member_type != '已封鎖' && empty($keyword) == false) {
                    //解析留言
                    $new_comment = $comment['message'];
                    $new_comment = $this->make_semiangle($new_comment);
                    $stack = array();
                    $str = explode("+", $new_comment);
                    foreach ($keyword as $key) {
                        
                        foreach ($str as $i => $eachstr) {
                            try{
                                if (strpos($eachstr, $key->keyword) !== false ) {
                                    try {
                                        $filteredNumbers = array_filter(preg_split("/\D+/", $str[$i + 1]));
                                        $firstOccurence = reset($filteredNumbers);
    
                                        $value = array('key' => $key->keyword, 'num' => $firstOccurence);
                                        array_push($stack, $value);
                                    } catch (Exception $e) { }
                                   
                                }
                               }catch (\Exception $e){
                            
                               
                               }

                        }
                    }
                    //----------------------------
                    for($i=0;$i<count($stack);$i++){
                        if(is_numeric($stack[$i]['num'])){
                            list($Code, $bid_num, $single_price, $product_id) = $this->ProductValidation($stack[$i]['key'], $stack[$i]['num']);
                    

                            $if_exist = Member::where('ps_id', '=', $comment['from']['id'])
                            ->where('page_id', '=', $page_id)
                            ->first();
    
                            if ($if_exist == null) {
                                $member_store = new Member();
                                $member_store->page_id = $page_id;
                                $member_store->ps_id = $comment['from']['id'];
                                $member_store->as_id = '';
                                $member_store->fb_name = $comment['from']['name'];
                                $member_store->bid_times = 1;
                                $member_store->checkout_times = 0;
                                $member_store->money_spent = 0;
                                $member_store->member_type = 1;
                                $member_store->save();
                            } else {
                                Member::where('ps_id', '=', $comment['from']['id'])
                                    ->where('page_id', '=', $page_id)
                                    ->increment('bid_times');
                            }
    
                            
                            if($Code != 'soldout')
                            {
                                    DB::table('streaming_product')->where('page_id' , $page_id)->where('product_id',$product_id)->increment('pre_sale', $bid_num);
                                    //存入DB
                                    $StreamingOrder = new StreamingOrder();
                                    $StreamingOrder->page_id = $page_id;
                                    $StreamingOrder->ps_id = $comment['from']['id'];
                                    $StreamingOrder->live_video_id = $video_id;
                                    $StreamingOrder->goods_num =  $bid_num;
                                    $StreamingOrder->bid_price = $single_price;
                                    $StreamingOrder->comment =  $comment['message'];
                                    $StreamingOrder->product_id =  $product_id;
                                    $StreamingOrder->save();

                                    
                                
                            }
                                $this->PrivateMessage( $Code , $comment['id'], $comment['from']['id'], $page_id, $token, $bid_num);
                                $facebook_comment[$comment_count]['can_reply_privately'] = false;

                        }
                    }
                }
                
                $comment_count++;


                
            }
            return $facebook_comment;
        }
    }

    //手動得標商品 
    public function NanuallyAwarded(Request $request){
        $live_video_id = $request->input('live_video_id');
        $page_id = $request->input('page_id');
        $bid_list = $request->input('bid_list');
        $messageid = $request->input('messageid');
        $psid = $request->input('psid');
        $token = $request->input('page_token');
        $Code ="";
        $num=0;

        foreach($bid_list as $data){
            $query = StreamingProduct::where('page_id',$page_id)
            ->where('keyword',$data['keyword'])
            ->where('is_delete','0')
            ->first();

            $goods_num = StreamingOrder::where('page_id', '=', $request->page_id)
            ->whereNull('order_id')
            ->where('product_id',$query->product_id)
            ->sum('goods_num');

            if( ($query->goods_num - $goods_num)<=0){
                $Code ='soldout';
                $num =0;
                break;
            }

            $streaming_order = new StreamingOrder();

            if( ($query->goods_num - $goods_num)>$data['num'] ){
                $num = $data['num'];
                $Code ='success';
            }else{
                $num = ($query->goods_num - $goods_num);
                $Code ='insufficient';
            }
            
            $streaming_order = new StreamingOrder();
            $streaming_order->page_id = $page_id;
            $streaming_order->ps_id = $psid;
            $streaming_order->live_video_id = $live_video_id;
            $streaming_order->product_id =  $query->product_id;
            $streaming_order->bid_price =  $query->goods_price;
            $streaming_order->goods_num = $num;
            $streaming_order->comment =  '直播ID'.$live_video_id.'中由賣家手動新增';
            $streaming_order->save();
        }
        $this->PrivateMessage($Code, $messageid, $psid, $page_id, $token, $num);
        return json_encode(  $messageid );

    }

    //挑選拍賣商品
    public function RefreshDrpProduct(Request $request)
    {
        $live_video_id = $request->live_video_id;
        //ajax每次點選下拉式商品，更新

        $aution_product = StreamingProduct::where('streaming_product.page_id', '=', $request->page_id)
        ->where('is_delete','0')
        ->where('streaming_product.goods_num', '>', 0)
        ->where('auction_list.live_video_id', '=', $live_video_id)
        ->Join('auction_list','streaming_product.product_id', '=', 'auction_list.product_id')
        ->select('auction_list.product_id')
        ->get()
        ->toArray();

        $drp_product = StreamingProduct::where('streaming_product.page_id', '=', $request->page_id)
        ->where('is_delete','0')
        ->where('streaming_product.goods_num', '>', 0)
        ->leftJoin('auction_list','streaming_product.product_id', '=', 'auction_list.product_id')
        ->whereNotIn('streaming_product.product_id',$aution_product)
        ->get();

        $goods_list = [];
        $check = "";
        $index = 0;
        foreach ($drp_product as $data) {
            if($data)
            $goods_num = StreamingOrder::where('page_id', '=', $request->page_id)
            ->whereNull('order_id')
            ->where('product_id',$data->product_id)
            ->where('live_video_id',$live_video_id)
            ->sum('goods_num');

            if($check!=$data->goods_key){
                $check=$data->goods_key;
                $index=1;
            }else{
                $index++;
            }

            $goods_list[ $data->goods_key ][$data->category]=array(
                'pic_url' => $data->pic_url,
                'goods_name' => $data->goods_name,
                'goods_price' => $data->goods_price,
                'goods_num' => $data->goods_num,
                'goods_category' => $data->category,
                'goods_note' => $data->description,
                'product_id' => $data->product_id,
                'bid_times' => $goods_num,
                'goods_key' => $data->goods_key,
                'index' => $index
            );
        }

        return $goods_list;
    }

    //存拍賣商品
    public function StoreSelectedProduct(Request $request)
    {
        $live_video_id = $request->input("live_video_id");
        $goods_key = $request->input("goods_key");
        $page_id = $request->input('page_id');

        for($i=0;$i<count($goods_key);$i++){
            $StreamingProduct = StreamingProduct::where('page_id', '=', $page_id)
            ->where('is_delete','0')
            ->where('goods_key', '=', $goods_key[$i])
            ->get();

            foreach($StreamingProduct as $query)
            {
                
                $auction_list = AuctionList::updateOrCreate(
                    ['live_video_id' => $live_video_id, 'product_id' => (int)$query->product_id,'page_id' => $page_id],
                    ['is_active' => 'true']
                );
            }
        
        }

        return json_encode("success");

    }


    //刪除拍賣商品
    public function DeleteAuctionProduct(Request $request){
        $live_video_id = $request->input("live_video_id");
        $goods_key = $request->input("goods_key");
        $page_id = $request->input('page_id');

        $StreamingProduct = StreamingProduct::where('goods_key',$goods_key)->get();

        foreach($StreamingProduct as $product)
        {
            AuctionList::where('page_id',$page_id)
            ->where('live_video_id',$live_video_id)
            ->where('product_id',$product->product_id)
            ->delete();
        }

        return "";
    }

    public function ShowAuctionProduct(Request $request){
        $live_video_id = $request->input("live_video_id");
        $page_id = $request->input('page_id');

        $goods_list = [];
        $goods_key = "";
        $index = 0 ;
        $diverse = 0 ;
        $auction_product = StreamingProduct::where('streaming_product.page_id', '=', $page_id)
        ->where('streaming_product.is_delete','0')
        ->join('auction_list', 'streaming_product.product_id', '=', 'auction_list.product_id')
        ->where('auction_list.is_active','true')
        ->where('auction_list.live_video_id', '=', $live_video_id)
        ->select('streaming_product.*')
        ->get();

        foreach ($auction_product as $data) {

            

            $bid_num = StreamingOrder::where('page_id', '=', $page_id)
            ->where('product_id',$data->product_id)
            ->where('live_video_id',$live_video_id)
            ->sum('goods_num');
            
            $goods_num = ($data->goods_num  - $data->pre_sale ) > 0 ?($data->goods_num  - $data->pre_sale):0;
            if($goods_num !=0){
                if($goods_key!=$data->goods_key){
                    $diverse = 0 ;
                    $goods_key =$data->goods_key;
                    $index = 1;
                    $StreamingProduct = StreamingProduct::where('page_id', '=', $page_id)
                    ->where('is_delete','0')
                    ->where('goods_key', '=', $data->goods_key)
                    ->get();
                    $category = '';
                    foreach($StreamingProduct as $query)
                    {
                        $category .= '('.$query->category . ') ';
                        $diverse ++;
                    }
                    if($diverse==1){
                        $category = '<b>'.$query->category. '</b>';
                    }
    
                }else{
                    $index++;
                }
    
                $all_category =  $category;
    
    
                $goods_list[ $data->keyword ]=array(
                    'pic_url' => $data->pic_url,
                    'goods_key' => $data->goods_key,
                    'goods_name' => $data->goods_name,
                    'keyword' => $data->keyword,
                    'goods_price' => $data->goods_price,
                    'goods_num' => $goods_num,
                    'goods_category' => $data->category,
                    'goods_note' => $data->description,
                    'product_id' => $data->product_id,
                    'bid_times' => $bid_num,
                    'index' => $index,
                    'all_category' => str_replace("(".$data->category.")","<b>(".$data->category.")</b>",$all_category),
                    'diverse'=> $diverse
                );
            }
            
        }

        return $goods_list;
    }
	
	//原本的CreateProduxt先放這裡
	public function create_product(Request $request)
	{
		$page = Page::where('as_id', Auth::user()->fb_id)->first();
        $page_id = $request->page_id;
        $img_url = "";
        $validatedData = $request->validate([
            'product_name' => 'required|string',
        ]);

        try {
            if($request->upload_image != null){
                $image = Imgur::upload($request->upload_image);
                $img_url = $image->link();
            }else{
                $img_url ='https://imgur.com/5bq0mYg.jpg';
            }
            
            $goods_name = $request->input("product_name");
            $category = $request->input("product_category");
            $price = $request->input("product_price");
            $num = $request->input("product_num");

            //計算有幾種商品
            $count = StreamingProduct::select('goods_key')
            ->where('page_id', $page_id)
            ->groupBy('goods_key')
            ->get()
            ->count();

            //生成A-Z字符
            for ($i = 65; $i <= 90; $i++) {
                $a[] = chr($i);
            }

            $key_number =  $count % 99;
            $key_count = floor($count / 99);
            $goods_key = $a[$key_count] . str_pad($key_number+1, 2, '0', STR_PAD_LEFT);
            $index = 0;
            $arr_goodskey = [];
            foreach($category as $category)
            {
                //存入資料庫
                if ($category == null) {
                    $category = "";
                }
                //query商品名稱&商品屬性是否重複
                $if_repeat = StreamingProduct::where('page_id', $page_id)
                ->where('goods_key',$goods_key)
                ->where('category',$category)
                ->get()
                ->count();

                if($if_repeat == 0)
                {
                    $keyword = $goods_key.$category;

                    $StreamingProduct = new StreamingProduct();
                    $StreamingProduct->page_id = $page_id;
                    $StreamingProduct->goods_name = $goods_name;
                    $StreamingProduct->goods_price = $price[$index];
                    $StreamingProduct->goods_num =  $num[$index];
                    $StreamingProduct->category =  $category;
                    $StreamingProduct->pic_url = $img_url;
                    $StreamingProduct->goods_key = $goods_key;
                    $StreamingProduct->keyword = $keyword;
                    $StreamingProduct->save();

                    array_push($arr_goodskey, $goods_key);
                } 
                $index++;
            }

            
            Session::put('success', '新增成功！');
            return $arr_goodskey;
        } catch (\Exception $e) {
            return "false";
        }
	}

    public function PrivateMessage($Code, $message_id, $PSID, $page_id, $token, $num)
    {
        //$Code -> 成功得標、商品完售、數量不足    
        //$message_id -> 留言私訊ID
        //$PSID -> 留言者ID
        //$page_id -> 粉絲團ID
        //$token -> 粉絲團權限
        //$num -> 商品數量
        $url = "https://livego.com.tw/buyer_cart?page_id=".$page_id."&uid=".$PSID;
        if($Code =='success'){
            $reply = urlencode("請至".$url." 結帳，謝謝！");
        }else if($Code =='insufficient'){
            $reply = urlencode("很抱歉！由於商品庫存不足，得標數量改為".$num."。結帳請至".$url." ，謝謝！");
        }else if($Code =='soldout'){
            $reply = urlencode("很抱歉！由於商品庫存不足，得標失敗！");
        }else{
            $reply =urlencode("恭喜抽重大獎！！獎品記得至結帳頁面中確認唷！".$url);
        }
        // switch ($Code) {
        //     case 'success':
        //         $reply = urlencode("請至".$url." 結帳，謝謝！");
        //         break;
        //     case 'insufficient':
        //         $reply = "很抱歉！由於商品庫存不足，得標數量改為{$num}。結帳請至".urlencode($url)." ，謝謝！";
        //         break;
        //     case 'soldout':
        //         $reply = "很抱歉！由於商品庫存不足，得標失敗！";
        //         break;
        //     case 'prize':
        //         $reply ="恭喜抽重大獎！！獎品記得至結帳頁面中確認唷！".urlencode($url);
        //         break;
        // }
        try{
            $post_url = "https://graph.facebook.com/v2.12/{$message_id}/private_replies?message={$reply}&access_token={$token}";
            $this->request_post($post_url);
        }catch (\Exception $e) { }   
    }

    public function LiveVideo($page_id, $token)
    {
        $live_video = file_get_contents("https://graph.facebook.com/" . $page_id . "?fields=live_videos.order(chronological).limit(1){video,status,embed_html},id%7Bid%7D&access_token=" . $token);
        $live_video = json_decode($live_video, true);

        if (!isset($live_video['live_videos'])) {
            // count = 1 從未開啟直播  count =2 有開啟直播過
            return null;
        } else {
            foreach ($live_video['live_videos']['data'] as $live_video) {
                // if ($live_video['status'] == 'LIVE') {
                //     return $live_video;
                // }
                return $live_video;
            }
        }
        //return redirect()->back()->with('fail', '直播尚未開啟！');

    }

    public function ProductValidation($keyword, $message_num)
    {
        //$goodkey -> 商品key值
        //$message_count ->留言數量

        //查詢商品庫存
        //這邊驗證使用關鍵字驗證
        $page = Page::where('as_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;
        $product = StreamingProduct::where('keyword', '=', $keyword)->where('is_delete','0')->where('page_id',$page_id)->first();
        $product_id = $product->product_id;
        $product_num = $product->goods_num;
        $pre_sale = $product->pre_sale;
        $single_price = $product->goods_price;
        $bid_num = 0;
        if ( ($product_num-$pre_sale) <= 0) {
            //無商品庫存
            $Code = 'soldout';
        } else if ( ($product_num-$pre_sale) < $message_num) {
            //買家留言數量大於庫存數量
            $Code = 'insufficient';
            $bid_num =  ($product_num-$pre_sale);
        } else {
            //正常得標
            $Code = 'success';
            $bid_num = $message_num;
        }


        return [$Code, $bid_num, $single_price, $product_id];
    }

    public function ShareAuctionProduct(Request $request){


        $live_video_id = $request->input('live_video_id');
        $page_id = $request->input('page_id');
        $goods_key = $request->input('goods_key');

        $query = DB::table('streaming_product')
        ->where('page_id',$page_id)
        ->where('is_delete','0')
        ->where('goods_key',$goods_key)
        ->get();

        

        $comment = "";
        $categorys = "";
        $price = "";
        $keyword ="";
        foreach($query as $data){

                        
            $less_goods_num = StreamingOrder::where('page_id', '=', $page_id)
            ->where('product_id',$data->product_id)
            ->where('live_video_id' ,'!=' ,$live_video_id)
            ->whereNull('order_id')
            ->sum('goods_num');
            $goods_num = ($data->goods_num - $data->pre_sale  - $less_goods_num) > 0 ?($data->goods_num - $data->pre_sale - $less_goods_num):0;

            if($goods_num>0){
                $comment = $data->goods_name.' %0A ';
                if($categorys ==""){
                    $categorys = ' 尺寸　'.$data->category;
                }else{
                    $categorys .= ' / '.$data->category;
                }
    
                if($price==""){
                    $price =' 價錢　'.$data->goods_price;
                }else{
                    $price .= ' / '.$data->goods_price;
                }
    
                if($keyword==""){
                    $keyword = '關鍵字 '.$data->keyword;
                }else{
                    $keyword .=" / ".$data->keyword;
                }
            }
        }
        
        $comment .=  $categorys.'%0A'.$price.'%0A'.$keyword;

        return $comment;
    }

    public function UpdateSaleTime(Request $request){
        $live_video_id = $request->input("live_video_id");
        $page_id = $request->input('page_id');

        $goods_list = [];

        $auction_product = StreamingProduct::where('streaming_product.page_id', '=', $page_id)
        ->where('streaming_product.is_delete','0')
        ->join('auction_list', 'streaming_product.product_id', '=', 'auction_list.product_id')
        ->where('auction_list.is_active','true')
        ->where('auction_list.live_video_id', '=', $live_video_id)
        ->select('streaming_product.*')
        ->get();

        foreach ($auction_product as $data) {
            $goods_num = StreamingOrder::where('page_id', '=', $page_id)
            ->where('product_id',$data->product_id)
            ->where('live_video_id',$live_video_id)
            ->sum('goods_num');
            array_push($goods_list, array(
                'keyword' => $data->keyword,
                'bid_times' => $goods_num,
                'stock_num' => $data->goods_num - $data->pre_sale
            ));

        }

        return $goods_list;
    }

    public function SendComment(Request $request)
    {
        $video_id = $request->input('video_id');
        $page_token = $request->input('page_token');
        $comment = $request->input('comment');

        $this->Comment($video_id,$page_token,$comment);

        return json_encode("");
    }

    public function GetWinner(Request $request)
    {
        $image_url = '';
        if($request->prize_image != null)
        {
            $image = Imgur::upload($request->prize_image);
            $image_url = $image->link();
        }else{
            $image_url ='https://imgur.com/5bq0mYg.jpg';
        }
        $prize_name = $request->input('prize_name');
        $prize_num = (int)$request->input('prize_num');
        $page_id = $request->input('page_id');
        $video_id = $request->input('video_id');
        $page_token = $request->input('page_token');

        $arr_lucky =(array) $request->input('arr_lucky');
        $arr_lucky_keys = $request->input('arr_lucky_keys');
        
        try{
            $arr_temp=array_rand($arr_lucky,$prize_num);
        } catch (\Exception $e) {
            $arr_temp=array_rand($arr_lucky,count($arr_lucky));
        }
        //如果陣列子有1型態會變成integer
        $arr_temp = (array)$arr_temp;
        $winner_comment = '恭喜 ';
        foreach($arr_temp as $data){
            $prize_store = new Prize();
            $prize_store->page_id = $page_id;
            $prize_store->ps_id = $arr_lucky[$data]['ps_id'];
            $prize_store->product_name = $prize_name;
            $prize_store->image_url = $image_url;
            $prize_store->save();
            $winner_comment .= $arr_lucky[$data]['name'].' ';
            $this->PrivateMessage('prize',$arr_lucky[$data]['message_id'],$arr_lucky[$data]['ps_id'],$page_id,$page_token,1);
        }
        $winner_comment .= '從萬人之中成為天選之人，獲得'.$prize_name.'！！';
        $this->Comment($video_id,$page_token,$winner_comment);
       
        return json_encode($winner_comment);
    }

    public function LuckyDraw(Request $request)
    {
        $validatedData = $request->validate([
            'prize_name' => 'required|string',
            'prize_keyword' => 'required|string',
            'prize_num' => 'required|regex:/^[0-9]+$/|max:11',
            // 'getprize_image' => 'is_pngORjpeg',
        ]);

        // try {
        

        $prize_name = $request->input('prize_name');
        $prize_num = $request->input('prize_num');
        $keyword = $request->input('prize_keyword');

        $video_id = $request->input('live_video_id');
        $token = $request->input('page_token');
        $page_id = $request->input('page_id');

        $facebook_comment = $this->GetFacebookComment($video_id, $token);

        $compliance = array();
        $memberlist = array();

        if($prize_num > 0 && $facebook_comment != "")
        {
            for($i=0;$i<$prize_num;$i++){
                foreach ($facebook_comment as $accomplish) {
                    if (strpos($accomplish['message'], $keyword) !== false) {
                        if (!in_array($accomplish['from']['name'], $compliance)) {
                            $compliance[$accomplish['from']['name']]['message'] = $accomplish['message'];
                            $compliance[$accomplish['from']['name']]['message_id'] = $accomplish['id'];
                            $compliance[$accomplish['from']['name']]['ps_id'] = $accomplish['from']['id'];
                            $compliance[$accomplish['from']['name']]['name'] = $accomplish['from']['name'];
                            $time = date("Y/m/d H:i",strtotime($this->graphtime_to_taiwantime($accomplish['created_time'])));
                            $compliance[$accomplish['from']['name']]['time'] = $time;
                        }
                    }
                }
            }
        }

        return $compliance;
    }

    public function TopFiveShoper(Request $request)
    {
        $live_video_id = $request->input('live_video_id');
        $page_id =  $request->input('page_id');
        $query = StreamingOrder::where('streaming_order.live_video_id',  $live_video_id)
            ->where('streaming_order.page_id', $page_id)
            ->where('member.page_id', $page_id)
            ->join('member', 'streaming_order.ps_id', '=', 'member.ps_id')
            ->select('streaming_order.ps_id', 'member.fb_name', 'streaming_order.bid_price', 'streaming_order.goods_num')
            ->get();

        // 將資料相同的筆數儲存唯一筆
        // ex [金城武,10444221] = array(100,200,300)  array為每筆的總和
        $result = array();
        foreach ($query as $k => $v) {
            $total = $v->bid_price * $v->goods_num;
            $result[$v->fb_name . ',' . $v->ps_id][] =  $total;
        }

        // 將上面陣列後面總和數相加
        $shoper_list = array();
        foreach ($result as $key => $value) {
            $array_date = explode(",", $key);
            $shoper_list[] = array('ps_id' => $array_date[1], 'total' => array_sum($value), 'fb_name' => $array_date[0]);
        }
        
        $total = array();
        foreach ($shoper_list as $key => $row) {
            $total[$key]  = $row['total'];
        }
        array_multisort($total, SORT_DESC,$shoper_list);
        // $shoper_list = collect($shoper_list)->sortBy('total');

        // $shoper_list= collect($shoper_list)->sortByDesc('total', SORT_NUMERIC , true);

    

        return $shoper_list;
    }



    public function CommoditySalesList(Request $request)
    {
        $page_id = $request->input('page_id');
        $live_video_id = $request->input('live_video_id');
        $query = StreamingOrder::where('streaming_order.live_video_id', $live_video_id)
            ->where('streaming_order.page_id', $page_id)
            ->Join('streaming_product', 'streaming_order.product_id', '=', 'streaming_product.product_id')
            ->select('streaming_order.bid_price', 'streaming_order.goods_num', 'streaming_product.pic_url', 'streaming_product.goods_name', 'streaming_product.category', 'streaming_product.goods_key')
            ->get();

        // 將資料相同的筆數儲存唯一筆
        // ex [商品名稱,種類,goods_key,圖片網址] = array(100,200,300)  array為每筆的總和
        $result = array();
        foreach ($query as $k => $v) {
            $total = $v->bid_price * $v->goods_num;
            $result[$v->goods_name . ',' . $v->category . ',' . $v->goods_key . ',' . $v->pic_url]['total'][] =  $total;
            $result[$v->goods_name . ',' . $v->category . ',' . $v->goods_key . ',' . $v->pic_url]['bid_times'][] =  $v->goods_num;
        }

        // 將上面陣列後面總和數相加
        $goods_list = array();
        foreach ($result as $key => $value) {
            $array_date = explode(",", $key);
            $goods_list[] = array('goods_name' => $array_date[0], 'category' => $array_date[1], 'goods_key' => $array_date[2], 'pic_url' => $array_date[3],  'total' => array_sum($value['total']) ,  'bid_time' => array_sum($value['bid_times']));
        }
        return $goods_list;
    }

    public function GetShopThreeDaysCustomer(Request $request)
    {
        $page_id = $request->input('page_id');
        $tomorrow = new DateTime('today +1 day');
        $the_first_threedays = new DateTime('today -3 day');
        $query = DB::table('streaming_order')->whereBetween('streaming_order.created_at', [$the_first_threedays, $tomorrow])
            ->where('streaming_order.page_id',$page_id)
            ->join('member', 'streaming_order.ps_id', '=', 'member.ps_id')
            ->select('member.fb_name', 'member.ps_id')
            ->groupBy('fb_name')
            ->get();

        return $query;
    }

    public function Comment($video_id,$access_token,$comment)
    {
       
        $comment = str_replace(" ","%20",$comment);
        $url = "https://graph.facebook.com/{$video_id}/comments/?access_token={$access_token}&message={$comment}";
        $data = json_encode([]);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_exec($curl);
        curl_close($curl);
    }

    //全形轉半形
    function make_semiangle($str)
    {
        $arr = array(
            '０' => '0', '１' => '1', '２' => '2', '３' => '3', '４' => '4',
            '５' => '5', '６' => '6', '７' => '7', '８' => '8', '９' => '9',
            'Ａ' => 'A', 'Ｂ' => 'B', 'Ｃ' => 'C', 'Ｄ' => 'D', 'Ｅ' => 'E',
            'Ｆ' => 'F', 'Ｇ' => 'G', 'Ｈ' => 'H', 'Ｉ' => 'I', 'Ｊ' => 'J',
            'Ｋ' => 'K', 'Ｌ' => 'L', 'Ｍ' => 'M', 'Ｎ' => 'N', 'Ｏ' => 'O',
            'Ｐ' => 'P', 'Ｑ' => 'Q', 'Ｒ' => 'R', 'Ｓ' => 'S', 'Ｔ' => 'T',
            'Ｕ' => 'U', 'Ｖ' => 'V', 'Ｗ' => 'W', 'Ｘ' => 'X', 'Ｙ' => 'Y',
            'Ｚ' => 'Z', 'ａ' => 'a', 'ｂ' => 'b', 'ｃ' => 'c', 'ｄ' => 'd',
            'ｅ' => 'e', 'ｆ' => 'f', 'ｇ' => 'g', 'ｈ' => 'h', 'ｉ' => 'i',
            'ｊ' => 'j', 'ｋ' => 'k', 'ｌ' => 'l', 'ｍ' => 'm', 'ｎ' => 'n',
            'ｏ' => 'o', 'ｐ' => 'p', 'ｑ' => 'q', 'ｒ' => 'r', 'ｓ' => 's',
            'ｔ' => 't', 'ｕ' => 'u', 'ｖ' => 'v', 'ｗ' => 'w', 'ｘ' => 'x',
            'ｙ' => 'y', 'ｚ' => 'z', '＋' => '+', '　' => '',' '=>''
        );
        return strtr($str, $arr);
    }

    function request_post($url='') {//url為必傳  如果該地址不需要引數就不傳
        if (empty($url)) {
            return false;
        }
        
        // $ch = curl_init();//初始化curl
        // curl_setopt($ch, CURLOPT_URL,$url);//抓取指定網頁
        // curl_setopt($ch, CURLOPT_HEADER, 0);//設定header
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求結果為字串且輸出到螢幕上
        // if(!empty($post_data))curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        // $data = curl_exec($ch);//執行curl
        // curl_close($ch);
        // return $data;


        $data = json_encode([]);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_exec($curl);
        curl_close($curl);
   }

   function streaming_sells_excle(Request $request){
        $page_id= $request->page_id;
        $live_video_id= $request->live_video_id;
        $page = Page::where('as_id', Auth::user()->fb_id)->first();
        $page_name = $page->page_name;
        $list=[];

        $query = DB::table('streaming_order')
            ->where('streaming_order.page_id',$page_id)
            ->where('streaming_order.live_video_id',$live_video_id)
            ->where('member.page_id',$page_id)
            ->where('streaming_product.page_id',$page_id)
            ->join('streaming_product','streaming_order.product_id','streaming_product.product_id')
            ->join('member','streaming_order.ps_id','member.ps_id')
            ->join('member_type','member.member_type','member_type.member_type')
            ->select('member.ps_id','member.fb_name','member_type.type_cht','streaming_order.goods_num','streaming_order.bid_price','streaming_order.id','streaming_product.goods_name','streaming_product.category')
            ->get();
        
        foreach( $query as $data){
            try{
                $list[$data->ps_id]['data']=array(
                    'ps_id' => $data->ps_id,
                    'fb_name' => $data->fb_name,
                    'type' => $data->type_cht,
                    'total' => $list[$data->ps_id]['data']['total']+ ($data->bid_price * $data->goods_num)
                );
            } catch (\Exception $e) {
                $list[$data->ps_id]['data']=array(
                    'ps_id' => $data->ps_id,
                    'fb_name' => $data->fb_name,
                    'type' => $data->type_cht,
                    'total' =>  ($data->bid_price * $data->goods_num)
                );
            }

            $list[$data->ps_id]['goods'][$data->id] =array(
                'goods_name' =>  $data->goods_name,
                'category' =>  $data->category,
                'goods_num' =>  $data->goods_num,
                'bid_price' =>  $data->bid_price,
            );

        }
        

        $file_name = $page_name."得標者清單".date('Y-m-d H:i:s');

        $new_excel = new OrderExport_streaming($list);

        return Excel::download($new_excel , $file_name.".xlsx");


   }
}
