<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Entities\Page;
use App\User;
use App\Entities\UpdateUser;
use App\Entities\StreamingOrder;
use App\Entities\PageDetail;
use App\Entities\StreamingProduct;
use App\Entities\Member;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\ClientException;
use Session;


class StreamingIndexController extends Controller
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

    public function json_comments($video_id, $token)
    {
        $facebook_comment = file_get_contents("https://graph.facebook.com/" . $video_id . "?fields=comments.limit(9999){can_reply_privately,id,from,message,created_time},id%7Bid%7D&access_token=" . $token);
        $facebook_comment = json_decode($facebook_comment, true);

        if (count($facebook_comment) == 1) {
            return "";
        }
        if (count($facebook_comment) >= 2) {
            return $facebook_comment;
        }
    }

    public function psid_to_asid($PSID,$token){
        try{
            $data = file_get_contents("https://graph.facebook.com/" . $PSID . "?fields=ids_for_pages%7Bid%7D&access_token=" . $token);
            $data = json_decode($data, true);
            $data = $data["ids_for_apps"]["data"][0]["id"];
        } catch (\Exception $e) {
            $data = $PSID;
        }
        return $data;
    }

    public function graphtime_to_taiwantime($time){
        $time = str_replace('T', " ", $time);
        $time = substr($time, 0, 19);
        //+8小時是因為時間差
        $time = date("Y-m-d H:i:s", strtotime("$time +8 hour"));
        return $time;
    }


     // function end   ------------------------

     public function index_load ()
     {
         $page = Page::where('fb_id', Auth::user()->fb_id)->first();
         $page_id = $page->page_id;
         $token = $page->page_token;
         $query = "/{$page_id}/live_videos";
         $query2 = "/{$page_id}/videos";
 
         try
         {
             $live_videos    = $this->graphapi($query, $token)->getGraphEdge()->asArray();
             $videos    = $this->graphapi($query2, $token)->getGraphEdge()->asArray();
             $videoInfo = [];
 
             // 有抓到進行中的直播
             foreach ($live_videos as $key)
             {
                 if ($key['status'] === "LIVE")
                 {
                     $video_id                   = $key['id'];
                     $videoInfo['url']           = $key['embed_html'];
                     $videoInfo['post_video_id'] = $videos[0]['id'];
                     
                     return redirect()->action(
                         'StreamingIndexController@index_show',
                         [
                             'page_id'       => $page_id, 
                             'page_token'    => $token, 
                             'video_id'      => $video_id, 
                             'post_video_id' => $videoInfo['post_video_id'], 
                             'url'           => $videoInfo['url']
                         ]
                     );
                 }
             }
             return redirect()->back()->with('fail', '直播尚未開啟！');
         }
         catch (FacebookSDKException $e)
         {
             return redirect()->back(); // handle exception
         }
     }

    public function index_show(Request $request)
    {
        // if (Gate::allows('seller-only',  Auth::user())) {
        Header('X-XSS-Protection: 0');
        try {
            // $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $request->input('page_id');
            //iframe
            $url = $request->input('url');
            //comments
            $video_id = $request->input('video_id');
            $post_video_id = $request->input('post_video_id');
            $token = $request->input('page_token');

            return view('index', ['page_id' => $page_id, 'url' => $url, 'video_id' => $video_id, 'post_video_id' => $post_video_id, 'token' => $token]);
        } catch (FacebookSDKException $e) {
            return redirect()->action(
                'GraphController@index_load'
            );
        }
    }

    public function refresh_drp_product(Request $request)
    {
        //ajax每次點選下拉式商品，更新
        $drp_product = StreamingProduct::select('goods_name','category','page_id','goods_num')
        ->where('page_id', '=', $request->input('page_id'))
        ->where('goods_num', '>', 0)
        ->where('is_active','=','true')
        ->get()->toArray();

        sort($drp_product);

        $check = "";
        $category = "";
        $products_list = [];
        foreach ( $drp_product as $data ){
            if($data['goods_name'] == $check){
                $category = $category ."、". $data['category'];
            }

            if($data['goods_name'] != $check AND $check!="" ){
                array_push($products_list,[$check, $category]);
                $category= $data['category'];
                $check = $data['goods_name'];
            }
            if($check ==""){
                $check = $data['goods_name'];
                $category = $category . $data['category'];
            }
        }
        array_push($products_list,[$check, $category]);
        // $json = json_encode($drp_product, true);

        return $products_list;
    }

    public function update_message(Request $request)
    {

        $page_id =  $request->input('page_id');
        $video_id = $request->input('video_id');
        $token = $request->input('page_token');
        $view_comment_count = $request->input('comment_count');
        $update_button = $request->input('update_button');
        $facebook_comment = $this->json_comments($video_id, $token);

        //查詢是否有新留言
        $video_comment = file_get_contents("https://graph.facebook.com/v4.0/{$video_id}/comments?summary=1&access_token={$token}");
        $video_comment = json_decode($video_comment, true);

        $comment_count = $video_comment['summary']['total_count'];
        //-----------------------------

        if ($facebook_comment != "") {
            $facebook_comment = $facebook_comment['comments']['data'];
            //計算目前為第幾筆array
            $comment_count = 0;
            foreach ($facebook_comment as $comment) {
                $facebook_comment[$comment_count]['created_time'] = $this->graphtime_to_taiwantime($comment['created_time']);
                $comment_id = $comment['id'];
                //can_reply_privately
                // $graph_query = file_get_contents("https://graph.facebook.com/{$comment_id}?fields=can_reply_privately%7Bid%7D&access_token={$token}");
                // $graph_query = json_decode($graph_query, true);
                // $facebook_comment[$comment_count]['can_reply_privately'] = $graph_query["can_reply_privately"];
                //如果為自己粉絲團 seller = true  
                //ID無須轉換 (ASID = PSID)
                if ((string) $comment['from']['id'] == $page_id) {
                    $facebook_comment[$comment_count]['seller'] = 'true';
                } else {
                    $facebook_comment[$comment_count]['seller'] = 'false';
                    // 判斷ASID session 是否存在
                    // $ASID = $comment['from']['id'];
                    // $session_ASPS = Session::get("PStoAS_array");
                    // if (in_array($ASID, $session_ASPS)) {
                    //     // 如存在直接抓取session的PSID值
                    //     $facebook_comment[$comment_count]['from']['id'] = $session_ASPS[$ASID];
                    // } else {
                    //     //轉換留言者 ASID to PSID
                    //     $PSID = $this->asid_to_psid( $comment['from']['id'] , $token);
                    //     $facebook_comment[$comment_count]['from']['id'] = $PSID;
                    //     //如不存在設定 session name = asid  /  value = psid
                    //     //先寫入陣列，再存session
                    //     $session_ASPS[$ASID] = $PSID;
                    //     Session::put("PStoAS_array", $session_ASPS);
                    // }
                }
                $comment_count++;
            }
            if($comment_count>$view_comment_count || $update_button)
            {
                return $facebook_comment;
            }
        } else {
            return "";
        }
    }

    //紀錄開始時間
    public function start_record(Request $request)
    {
        Session::forget('start_time');
        $page_id =  $request->input('page_id');
        $token = $request->input('page_token');
        $post_video_id = $request->input('post_video_id');
        $goods_name = $request->input('goods_name');
        $type = $request->input('type');
        $streaming_products = StreamingProduct::select('category','product_id','goods_price','goods_num')
        ->where('goods_name', '=', $goods_name)
        ->where('page_id', '=', $page_id)
        ->where('goods_num', '>', 0)
        ->where('is_active','=','true')
        ->get();
        
        $product_detail_message = "";
        $example_text ="";
        $products_list =[];
        foreach ( $streaming_products as $product ){
            $example_text = $product->category;
            $product_detail_message = $product_detail_message . str_replace('empty','無屬性', $product->category) . ' / ' .$product->goods_price . '元  、';
            array_push($products_list , [$product->category, $product->product_id , $product->goods_price , $product->goods_num ]);
        }

        //留言拍賣開始----------------------------------------------------------------------
        if($type!=1){
            $addcomment = $goods_name . "  拍賣開始  ---------" ;
        }
        else{
            $addcomment = $goods_name . "  拍賣開始  ---------\n " .rtrim($product_detail_message, "、")."\n 購買範例 [  ". str_replace('empty','',$example_text) ." +1  ]  \n 如需購買多樣商品請分開喊！" ;        
        }
        
        $query = '/' . $post_video_id . '/comments';
        $response = $this->api->post($query, array('message' => $addcomment), $token);
        //---------------------------------------------------------------------------------

        //Session::save();
        return $products_list;
    }

    //結束競標(+1)
    public function end_record(Request $request)
    {
        $video_id = $request->input('video_id');
        $token = $request->input('page_token');
        $goods_name = $request->input('goods_name');
        $page_id =  $request->input('page_id');
        $all_product = $request->input('all_product');
        $start_time = (int)$request->input('start_time');
        // 得標者姓名
        $getter = '';

        //留言結束競標---------------------------------------------------------------------
        $post_video_id = $request->input('post_video_id');
        $comment = $goods_name . " 拍賣結束------------------------------";
        $query = '/' . $post_video_id . '/comments';
        $response = $this->api->post($query, array('message' => $comment), $token);
        //---------------------------------------------------------------------------------
        
        $facebook_comments = $this->json_comments($video_id,$token);

        if($facebook_comments != "")        
            $facebook_comments = $facebook_comments['comments']['data'];
        $temp = array();
        $item = 0;

        //儲存ASID and PSID的陣列
        // Session::put("PStoAS_array", array());

        //處理判斷得標時間 ------------------------------------------------------------------ 
        //$start_time = strtotime(Session::get('start_time'));
        $end_time =  strtotime("now");

        // $facebook_comments_reverse = array_reverse($facebook_comments);
        foreach ($facebook_comments as $key) {
            //抓取賣家留言時間 把 Y-m-d T H:i:s +0000 -> Y-m-d H:i:s
            $time = $this->graphtime_to_taiwantime($key['created_time']);
            // 處理時間比較
            $time = strtotime($time);

            //----------------------------------------------------------------------------------
            if($time >= $start_time AND $time <= $end_time ){
                if($page_id != $key['from']['id']){
                $key['message'] = str_replace(" ","", $key['message']);
                //如果留言contains + 並且在時間內
                if (strpos($key['message'], '+') !== false) {
                    $FBID = $facebook_comments[$item]['from']['id'];
                    $Name = $key['from']['name'];

                    $member = Member::where('fb_id', '=',  $FBID)
                    ->where('page_id', '=', $page_id)
                    ->first();
                    if(isset($member))
                    {
                        $member = $member->is_block;
                    }
                    else
                    {
                        $member = '';
                    }

                    $check_num = preg_match_all('!\d+!', $key['message'], $comment_num);
                    try {
                        if( $check_num ==1){
                            $check_num = $comment_num[0][0];
                        }elseif($check_num ==2){
                            $check_num = $comment_num[0][1];
                        }
                        else{
                            $check_num = 0;
                        }
                    } catch (\Exception $e) {
                        $check_num = 0;
                    }
                    
                    //判斷留言+後面字串是否包含數字並且大於零，並確認買家狀態不為封鎖。
                    if (is_numeric($check_num) AND $check_num >0 AND $member != "封鎖") {

                        // 判斷 + 前面是否有字串 
                        $category_query = explode('+', $key['message']);
                        if ($category_query[0] != null ) {
                            //種類+1 種類+2
                            $category_check = $category_query[0];
                        } else {
                            //+1 +2 
                            $category_check = "empty";
                        }
                        
                        //處理字串最後幾個字是否等於屬性名子，並抓取product_id、goods_num-----------------
                        try{
                            $product_count = count($all_product);
                        }catch (\Exception $e) {
                            break;
                        }
                        $product_id="";
                        $product_category="empty";
                        $product_num =0;
                        $product_price = 0;
                        

                        // 用現有種類判斷 ex 種類 -> 大 字串數為一 所以抓+前一個字去比對 如果相等抓值
                        for($i = 0 ; $i < $product_count ; $i++){
                            $product_name_count = -mb_strlen($all_product[$i][0]);
                            $comment_final_word = mb_substr($category_check,$product_name_count);
                            if($all_product[$i][0]==strtoupper($comment_final_word)){
                                $product_category = strtoupper( $all_product[$i][0]); 
                                $product_id = $all_product[$i][1]; 
                                $product_num = $all_product[$i][3]; 
                                $product_price = $all_product[$i][2];
                                break;
                            }
                            if($all_product[$i][0]=="empty"){
                                $product_category = $all_product[$i][0]; 
                                $product_id = $all_product[$i][1]; 
                                $product_num = $all_product[$i][3]; 
                                $product_price = $all_product[$i][2];

                            }
                            
                        }

                        
                       

                            
                        if ($product_num >= $check_num) {
                            $messenger_text = '';
                            $temp_num = $check_num;
                            $product_num -= $check_num;
                        } else if ($product_num > 0 && $product_num < $check_num) {
                            $messenger_text = 'insufficient';
                            $temp_num = $product_num;
                            $product_num = 0;
                        } else {
                            $messenger_text = 'fail';
                            $product_num = 0;
                            $temp_num = 0;
                        }

                        //array 減去商品數量
                        
                        for($i = 0 ; $i <$product_count ; $i++){
                            
                            if($all_product[$i][0] == $product_category ){
                                $all_product[$i][3] = $product_num;
                            }
                        }




                        // 如果字串已包含得標者 則不列出
                        if (strpos($getter, $Name) != true) {
                            $getter = $getter . ' ' . $Name;
                        }
                        
                        $temp[$item] = array(
                            'name' => $Name,
                            'id' => $key['from']['id'],
                            'num' =>  $temp_num,
                            'message' => strtoupper($key['message']),
                            'message_time' => $time,
                            'message_id' => $key['id'],
                            'messenger_text' => $messenger_text,
                            'live_video_id' => $video_id,
                            'category' => $product_category,
                            'price' => $product_price ,
                            'product_id' => $product_id ,
                        );
                    }
                } 
                }

            }
            // else {
            //     break;
            // }
            $item++;
        }

        if ($getter != '') {
            //留言得標者
            $post_query = '/' . $post_video_id . '/comments';
            $post_response = $this->api->post($post_query, array('message' => '得標者為' . $getter), $token);

            $return_array = array();
            array_push($return_array,$temp,$all_product);

            return json_encode($return_array, true);
        } else {
            return json_encode("", true);
        }
            

    }

    //結束競標(最高價)
    public function end_record_top_price(Request $request)
    {
        $video_id = $request->input('video_id');
        $token = $request->input('page_token');
        $end_time = strtotime(date("Y-m-d H:i:s"));
        $start_time = strtotime(Session::get('start_time'));
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;
        $all_product = $request->input('all_product');
        $product_id = $all_product[0][1]; //看哪裡接收編號
        $product_num = $all_product[0][3];
        //留言結束競標
        $post_video_id = $request->input('post_video_id');
        $goods_name = $request->input('goods_name');

        //留言結束競標--------------------------------------------------------------------
        $addcomment = $goods_name . " 拍賣結束------------------------------";
        $post_query = '/' . $post_video_id . '/comments';
        $post_response = $this->api->post($post_query, array('message' => $addcomment), $token);
        //---------------------------------------------------------------------------------

        
       
        try {
            $facebook_comments = $this->json_comments($video_id,$token);
            if ($facebook_comments!="") {
                $comments = $facebook_comments['comments']['data'];
                $temp = array();
                $top_price = 0;
                $fb_id = "";
                $fb_name = "";
                $message_time = "";
                $message_id = "";

                //自動判斷得標
                foreach ($comments as $key) {    
                    $time = $this->graphtime_to_taiwantime($key['created_time']);
                    // 處理時間比較
                    $time = strtotime($time);
                    
                    $check_num = preg_match_all('!\d+!', $key['message'], $comment_num);
                    try {
                        $check_num = $comment_num[0][0];
                    } catch (\Exception $e) {
                        $check_num = 0;
                    }

                    if ($time >= $start_time && $time <= $end_time && $check_num>0  && $key['from']['id'] != $page_id) {
                       
                        // $ASID= $key['from']['id'];
                        // $session_ASPS = Session::get("PStoAS_array");
                        // if (in_array($ASID, $session_ASPS)) {
                        //     // 如存在直接抓取session的PSID值
                        //     $comments['from']['id'] = $session_ASPS[$ASID];
                        // } else {
                        //     //轉換留言者 ASID to PSID
                        //     $PSID = $this->asid_to_psid( $key['from']['id'] , $token);
                        //     $key['from']['id'] = $PSID;
                        //     //如不存在設定 session name = asid  /  value = psid
                        //     //先寫入陣列，再存session
                        //     $session_ASPS[$ASID] = $PSID;
                        //     Session::put("PStoAS_array", $session_ASPS);
                        // }


                        // call session

                        $member = Member::where('fb_id', '=', $key['from']['id'])->first();
                        if(isset($member)){
                            $member = $member->is_block;
                        }else{
                            $member="";
                        }

                        if($member != '封鎖'){
                            if ( $check_num > $top_price && $key['from']['id'] != $page_id) {
                                $top_price = $check_num;
                                $fb_id = $key['from']['id'];
                                $fb_name = $key['from']['name'];
                                $message_time = $time;
                                $message_id = $key['id'];
                            }
                            

                        }
                    }
                }
               
                if ($product_num > 0 && $fb_name != "") {
                    $temp[0] = array(
                        [
                            'price' => $top_price,
                            'name' => $fb_name,
                            'id' => $key['from']['id'],
                            'message_time' => $message_time,
                            'message_id' => $message_id,
                            'live_video_id' => $video_id,
                            'product_id'  => $product_id,   
                        ],
                    );
                    //留言得標者
                    // $post_query = '/'.$post_video_id.'/comments';
                    // $post_response = $this->api->post($post_query, array('message' => '得標者為 '.$fb_name), $token);
                    return json_encode($temp, true);
                }

                return json_encode("", true);
            } else {
                return "";
            }
        } catch (FacebookSDKException $e) {
            return json_encode($e, true);
        }
    }

    public function store_streaming_order(Request $request)
    {
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;
        $token = $request->input('page_token');
        $buyer = $request->input('buyer');
        $type = $request->input('type');



        $blacklist_time = PageDetail::where('page_id', '=', $page_id)
        ->first();

        if ($type == 2) //最高價制
        {
            $fb_id = $buyer[0]['id'];
            $product_id =  $buyer[0]['product_id'];
            if($product_id != null)
            {
                //產生uid
                // $random_num = rand(100, 999);
                // $uid = $fb_id . time() . $random_num;

                //棄標時間
                $page = Page::where('fb_id', Auth::user()->fb_id)->first();
                $page_id = $page->page_id;

                $if_exist = Member::where('fb_id', '=', $buyer[0]['id'])
                    ->where('page_id', '=', $page_id)
                    ->first();
                //處理PSID ASID -----------------------------------------------------------------
                $PSID =  $buyer[0]['id'];
                //轉換留言者 PSID to ASID
                $ASID = $this->psid_to_asid($PSID,$token);

                //---------------------------------------------------------------------------------
                if ($if_exist == null) {
                    $member_store = new Member();
                    $member_store->page_id = $page_id;
                    $member_store->fb_id = $buyer[0]['id'];
                    $member_store->as_id = $ASID;
                    $member_store->fb_name = $buyer[0]['name'];
                    $member_store->bid_times = 1;
                    $member_store->checkout_times = 0;
                    $member_store->blacklist_times = 0;
                    $member_store->money_spent = 0;
                    $member_store->is_block = "正常";
                    $member_store->save();
                } else {
                    Member::where('fb_id', '=', $buyer[0]['id'])
                        ->where('page_id', '=', $page_id)
                        ->increment('bid_times');
                }

                //存入DB
                $page_store = new StreamingOrder();
                $page_store->page_id = $page_id;
                if($ASID=='')
                {
                    $page_store->fb_id = $PSID;
                }
                else
                {
                    $page_store->fb_id = $ASID;
                }
                $page_store->live_video_id = $buyer[0]['live_video_id'];
                $page_store->goods_num =  1;
                $page_store->single_price =  (string)$buyer[0]['price'];
                $page_store->comment =  $buyer[0]['comment'];
                $page_store->product_id =  $product_id;
                $page_store->deadline =  date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s") . ' +' . (string) ($blacklist_time->deadline_time) . ' hours'));
                // $page_store->uid = $uid;
                $page_store->save();

                //私訊
                try {
                    $reply = "請至  http://livego.com.tw/buyer_index?page_id={$page_id}&uid={$PSID}  結帳，謝謝！";

                    $query = '/' . $buyer[0]['message_id'] . '/private_replies';
                    $response = $this->api->post($query, array('message' => $reply), $token);
                    //parent::SendAPI($buyer[0]['message_id'],$reply);
                    
                } catch (FacebookSDKException $e) {
                    return json_encode($e, true);
                }
            }
        } else { //+1制
            //棄標時間
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            $bid_list=[];
            foreach ($buyer as $buyers) {

                if ($buyers['product_id'] == null) {
                    if(!in_array($buyers['id'],$bid_list)){
                        array_push($bid_list, $buyers['id']);
                        //私訊
                        $reply = "得標失敗，請確認關鍵字！";
                        $query = "/{$buyers['message_id']}/private_replies";
                        $response = $this->api->post($query, array('message' => $reply), $token);
                        //parent::SendAPI($buyers['id'],$private_replies);
                        //--------
                    }
                    break;
                }
                    $left_num_query = StreamingProduct::where('product_id', '=', $buyers['product_id'])
                    ->first();
    
                    $left_num = $left_num_query->goods_num;
                    $fb_id = $buyers['id'];
    
                    //產生uid
                    // $random_num = rand(100, 999);
                    // $uid = $fb_id . time() . $random_num;
    
                    //計算總價格
                    $num = $buyers['num'];
    
                    //處理PSID ASID -----------------------------------------------------------------
                    $PSID =  $buyers['id'];
                    //轉換留言者 PSID to ASID
                    $ASID = $this->psid_to_asid($PSID,$token);
                    //---------------------------------------------------------------------------------
    
                    
                    //是否有庫存不足問題
                    $messenger_text = $buyers['messenger_text'];
                    $private_replies = '';
    
                    if ($messenger_text == 'insufficient') {
                        //剩餘數量扣除
                        $left_num -= $num;
                        $private_replies = "很抱歉！由於商品庫存不足，得標數量改為{$num}";
                        $private_replies .= "。結帳請至  http://livego.com.tw/buyer_index?page_id={$page_id}&uid={$PSID} ，謝謝！";
                    } else if ($messenger_text == 'fail') {
                        $private_replies = '很抱歉！由於商品庫存不足，得標失敗！';
                    } else {
                        //剩餘數量扣除
                        $left_num -= $num;
                        $private_replies .= "結帳請至  http://livego.com.tw/buyer_index?page_id={$page_id}&uid={$PSID} ，謝謝！";
                    }
    
                    $if_exist = Member::where('fb_id', '=', $buyers['id'])
                    ->where('page_id', '=', $page_id)
                    ->first();
    
                    
                    if ($if_exist == null) {
                        $member_store = new Member();
                        $member_store->page_id = $page_id;
                        $member_store->fb_id = $buyers['id'];
                        $member_store->as_id = $ASID;
                        $member_store->fb_name = $buyers['name'];
                        $member_store->bid_times = 1;
                        $member_store->checkout_times = 0;
                        $member_store->blacklist_times = 0;
                        $member_store->money_spent = 0;
                        $member_store->is_block = "正常";
                        $member_store->save();
                    } 
                    if($if_exist != null && $messenger_text != 'fail') {
                        Member::where('fb_id', '=', $buyers['id'])
                            ->where('page_id', '=', $page_id)
                            ->increment('bid_times');
                    }
    
                        //存入資料庫
                        $page_store = new StreamingOrder;
                        $page_store->page_id = $page_id;
                        if($ASID=='')
                        {
                        $page_store->fb_id = $PSID;
                        }
                        else
                        {
                        $page_store->fb_id = $ASID;
                        }
                        $page_store->live_video_id = $buyers['live_video_id'];
                        $page_store->goods_num =  $num;
                        $page_store->single_price =  (string) $buyer[0]['price'];
                        $page_store->comment =  $buyers['comment'];
                        $page_store->deadline =  date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s") . ' +' . (string) ($blacklist_time->deadline_time) . ' hours'));
                        $page_store->product_id =  $buyers['product_id'];
                    //  $page_store->uid = $uid;
                        $page_store->save();
                    // $getter = $getter . ' ' . $buyers['name'];
                    //留言得標者
                    if(!in_array($buyers['id'],$bid_list)){
                        array_push($bid_list, $buyers['id']);
                        //私訊
                        $reply = "請至   http://livego.com.tw/buyer_index?page_id={$page_id}&uid={$PSID}  結帳，謝謝！";
                        $query = "/{$buyers['message_id']}/private_replies";
                        $response = $this->api->post($query, array('message' => $reply), $token);
                        //parent::SendAPI($buyers['id'],$private_replies);
                        //--------
                    }

    
                    StreamingProduct::where('product_id', '=', $buyers['product_id'])
                    ->update(['goods_num' => $left_num]);  
            }
        }
        

        return json_encode(count($buyer), true);
    }

    //影片留言
    public function add_comment(Request $request)
    {
        $token = $request->input('page_token');
        $post_video_id = $request->input('post_video_id');
        $comment = $request->input('comment');
        $query = '/' . $post_video_id . '/comments';
        $response = $this->api->post($query, array('message' => $comment), $token);
        return json_encode("", true);
    }

    //手動得標判斷庫存
    public function check_inventories(Request $request)
    {
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;
        $messenger_text = '';
        $comment_message = $request->input('comment_message');
        $comment_message = str_replace(" ","",$comment_message);
        $fb_id = $request->input('fb_id'); //ps_id
        $token = $request->input('token');
        $all_product = $request->input('all_product');

        $member = Member::where('fb_id', '=',  $fb_id)
        ->where('page_id', '=', $page_id)
        ->first();
        if($member!=null)
        {
            $member = $member->is_block;
        }
        if($member =="封鎖")
            return json_encode("此買家已被封鎖！", true);


        preg_match_all('!\d+!', $comment_message , $comment_num_array);
        if(isset($comment_num_array[0][0]))
        {
            $comment_num = $comment_num_array[0][0];
        }
        else
        {
            $comment_num = 0;
        }

        if(is_numeric($comment_num) AND $comment_num >0 ){
            // 判斷 + 前面是否有字串 
            $category_query = explode('+', $comment_message);
            if ($category_query[0] != null) {
                //種類+1 種類+2
                $category_check = $category_query[0];
            } else {
                //+1 +2 
                $category_check = "empty";
            }
            //處理字串最後幾個字是否等於屬性名子，並抓取product_id、goods_num-----------------
            $product_count = count($all_product);
            $product_id="";
            $product_num =0;
            $product_price = 0;
            for($i = 0 ; $i < $product_count ; $i++){
                $product_name_count = -mb_strlen($all_product[$i][0]);
                $comment_final_word = mb_substr($category_check,$product_name_count);
                if($all_product[$i][0]==$comment_final_word){
                    $category_check = $all_product[$i][0];
                    $product_id = $all_product[$i][1]; 
                    $product_num = $all_product[$i][3]; 
                    $product_price = $all_product[$i][2];
                    break;
                }
                if($all_product[$i][0]=='empty'){
                    $category_check = 'empty';
                    $product_id = $all_product[$i][1]; 
                    $product_num = $all_product[$i][3]; 
                    $product_price = $all_product[$i][2];
                }
            }

            $goods_num = $product_num;
            $num = $comment_num;
    
            // if($goods_num>0 && $comment_num > $goods_num){
            //     $num = $goods_num;
            //     $messenger_text = 'insufficient';
            // }

            if ($comment_num <= $goods_num) {
                $messenger_text = '';
                $num = $comment_num;
            } else if ($goods_num > 0 && $goods_num < $comment_num) {
                $messenger_text = 'insufficient';
                $num = $goods_num;
            } else {
                $messenger_text = 'fail';
                $num = 0;
            }
            
            if($product_num==0){
                $num = 0;
            }
            $temp[0] = array(
                [
                    'id'=>$fb_id,
                    'category' => $category_check,
                    'messenger_text' => $messenger_text,
                    'num' => $num,
                    'price' => $product_price,
                    'product_id' => $product_id,
                    
                ]);

    
            return json_encode($temp, true);
        }
        else
        {
            return json_encode("此買家留言格式錯誤！", true);
        }
    }
}

    // public function get_streaming_productInfo(Request $request)
    // {
    //     $page = Page::where('fb_id', Auth::user()->fb_id)->first();
    //     $page_id = $page->page_id;

    //     $goods_name = $request->input('goods_name');
    //     $query = StreamingProduct::where('page_id', '=', $page_id)
    //         ->where('goods_name', '=', $goods_name)
    //         ->where('goods_num', '>', 0)
    //         ->get();


    //     if ($query->count() > 0) {
    //         $encoded_productinfo = json_encode($query, true);
    //         return $encoded_productinfo;
    //     } else {
    //         return json_encode("", true);
    //     }
    // }
// }
