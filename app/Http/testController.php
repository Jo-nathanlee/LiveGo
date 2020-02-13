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
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\ClientException;
use Session;
use DateTime;
use Imgur;
use Yish\Imgur\Upload;


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

        $facebook_comment = file_get_contents("https://graph.facebook.com/" . $video_id . "?fields=comments.limit(9999){can_reply_privately,id,from,message,created_time},id%7Bid%7D&access_token=" . $token);
        $facebook_comment = json_decode($facebook_comment, true);
        if (count($facebook_comment) == 1) {
            return "";
        }
        if (count($facebook_comment) >= 2) {
            $facebook_comment = $facebook_comment['comments']['data'];

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
        $page = Page::where('ps_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;
        $token = $page->page_token;

        try {
            $live_video = $this->LiveVideo($page_id, $token);
            $live_video_url =  explode("\"", $live_video['embed_html']);
    
            $goods_list = [];

            $auction_product = StreamingProduct::where('streaming_product.page_id', '=', $page_id)
            ->join('auction_list', 'streaming_product.product_id', '=', 'auction_list.product_id')
            ->where('auction_list.live_video_id', '=', $live_video['id'])
            ->select('streaming_product.*')
            ->get();

            foreach ($auction_product as $data) {
                $goods_num = StreamingOrder::where('page_id', '=', $page_id)
                ->where('product_id',$data->product_id)
                ->where('live_video_id',$live_video_id)
                ->sum('goods_num');
    
                $goods_list[ $data->keyword ]=array(
                    'pic_url' => $data->pic_url,
                    'goods_name' => $data->goods_name,
                    'keyword' => $data->keyword,
                    'goods_price' => $data->goods_price,
                    'goods_num' => $data->goods_num,
                    'goods_category' => $data->category,
                    'goods_note' => $data->description,
                    'product_id' => $data->product_id,
                    'bid_times' => $goods_num
                );
            }

            $goods_key = StreamingProduct::where('streaming_product.page_id', '=', $page_id)
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
            return view('streaming_index', ['page_id' => $page_id,'goods_key' => $goods_key, 'auction_list' => $goods_list, 'device' => $device, 'url' => $live_video_url[1],'video_id' => $live_video['video']['id'], 'live_video_id' => $live_video['id'], 'token' => $token]);
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
        $keyword = $request->input('goods_key');
        //$keyword = ['K01','K01H'];
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
                if ($comment['from']['id'] != $page_id && $comment['can_reply_privately'] == true && $member_type != '已封鎖' && count($keyword) > 0) {
                    //解析留言
                    $new_comment = $comment['message'];
                    $new_comment = $this->make_semiangle($new_comment);
                    $stack = array();
                    $str = explode("+", $new_comment);

                    foreach ($keyword as $key) {

                        foreach ($str as $i => $eachstr) {

                            if (strpos($eachstr, $key) !== false) {
                                $filteredNumbers = array_filter(preg_split("/\D+/", $str[$i + 1]));
                                $firstOccurence = reset($filteredNumbers);

                                $value = array('key' => $key, 'num' => $firstOccurence);
                                array_push($stack, $value);
                            }
                        }
                    }
                    //----------------------------
                    if(isset($stack[0]))
                    {
                        list($Code, $bid_num, $single_price, $product_id) = $this->ProductValidation($stack[0]['key'], $stack[0]['num']);

                         //存Member
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
                            $member_store->blacklist_times = 0;
                            $member_store->money_spent = 0;
                            $member_store->member_type = 1;
                            $member_store->save();
                        } else {
                            Member::where('ps_id', '=', $comment['from']['id'])
                                ->where('page_id', '=', $page_id)
                                ->increment('bid_times');
                        }

                        //存入DB
                        $page_store = new StreamingOrder();
                        $page_store->page_id = $page_id;
                        $page_store->ps_id = $comment['from']['id'];
                        $page_store->video_id = $video_id;
                        $page_store->goods_num =  $bid_num;
                        $page_store->single_price = $single_price;
                        $page_store->comment =  $comment['message'];
                        $page_store->product_id =  $product_id;
                        // $page_store->uid = $uid;
                        $page_store->save();


                        try {
                            $this->PrivateMessage($Code, $comment['id'], $comment['from']['id'], $page_id, $token, $bid_num);
                            $facebook_comment[$comment_count]['can_reply_privately'] = false;
                        } catch (Exception $e) { }
                    }
                }
                
                $comment_count++;


                
            }
            return $facebook_comment;
        }
    }

    //挑選拍賣商品
    public function RefreshDrpProduct(Request $request)
    {
        $live_video_id = $request->live_video_id;
        //ajax每次點選下拉式商品，更新
        $drp_product = StreamingProduct::where('page_id', '=', $request->page_id)
        ->leftJoin('auction_list', 'streaming_product.product_id', '=', 'auction_list.product_id')
        ->where('streaming_product.goods_num', '>', 0)
        ->whereNull('auction_list.product_id')
        ->select('streaming_product.*')
        ->get();


        $goods_list = [];

        foreach ($drp_product as $data) {

            $goods_num = StreamingOrder::where('page_id', '=', $request->page_id)
            ->whereNull('order_id')
            ->where('product_id',$data->product_id)
            ->where('live_video_id',$live_video_id)
            ->sum('goods_num');

            $goods_list[ $data->keyword ]=array(
                'pic_url' => $data->pic_url,
                'goods_name' => $data->goods_name,
                'goods_price' => $data->goods_price,
                'goods_num' => $data->goods_num,
                'goods_category' => $data->category,
                'goods_note' => $data->description,
                'product_id' => $data->product_id,
                'bid_times' => $goods_num
            );
        }


        // foreach ($drp_product as $data) {
        //     if ($data['goods_name'] == $check) {
        //         $category = $category . "、" . $data['category'];
        //     }

        //     if ($data['goods_name'] != $check and $check != "") {
        //         array_push($products_list, [$check, $category, $data['goods_key']]);
        //         $category = $data['category'];
        //         $check = $data['goods_name'];
        //     }

        //     if ($check == "") {
        //         $check = $data['goods_name'];
        //         $category = $category . $data['category'];
        //     }
        // }
        // array_push($products_list, [$check, $category]);
        // // $json = json_encode($drp_product, true);
        // dd($products_list);
        return $goods_list;
    }

    //存拍賣商品
    public function StoreSelectedProduct(Request $request)
    {
        $live_video_id = $request->input("live_videos_id");
        $goods_key = $request->input("goods_key");
        $page_id = $request->input('page_id');

        $goods_list = [];

        for($i=0;$i<count($goods_key);$i++){
            $StreamingProduct = StreamingProduct::where('page_id', '=', $page_id)
            ->where('goods_key', '=', $goods_key[$i])
            ->get();

            foreach($StreamingProduct as $query)
            {
                $auction_list = new AuctionList();
                $auction_list->page_id = $page_id;
                $auction_list->live_video_id = $live_video_id;
                $auction_list->product_id =  $query->product_id;
                $auction_list->save();

                $goods_num = StreamingOrder::where('page_id', '=', $request->page_id)
                ->where('product_id',$query->product_id)
                ->where('live_video_id',$live_video_id)
                ->sum('goods_num');

                $goods_list[ $query->keyword ]=array(
                    'pic_url' => $query->pic_url,
                    'goods_name' => $query->goods_name,
                    'keyword' => $query->keyword,
                    'goods_price' => $query->goods_price,
                    'goods_num' => $query->goods_num,
                    'goods_category' => $query->category,
                    'goods_note' => $query->description,
                    'product_id' => $query->product_id,
                    'bid_times' => $goods_num
                );
            }
        }

        return $goods_list;

    }

    //新增拍賣商品
    public function CreateProduct(Request $request)
    {
        $page = Page::where('ps_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;

        $validatedData = $request->validate([
            'product_name' => 'required|string',
            // 'product_category' => 'string|max:255|nullable', //備註可null
            // 'product_price' => 'required|regex:/^[0-9]+$/|max:20',
            // 'product_num' => 'required|regex:/^[0-9]+$/|max:11',
            // 'upload_image' => 'is_pngORjpeg',
        ]);

        try {
            $image = Imgur::upload($request->upload_image);

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
            foreach($category as $category)
            {
                //存入資料庫
                if ($category == null) {
                    $category = "";
                }
                $keyword = $goods_key.$category;

                $StreamingProduct = new StreamingProduct();
                $StreamingProduct->page_id = $page_id;
                $StreamingProduct->goods_name = $goods_name;
                $StreamingProduct->goods_price = $price[$index];
                $StreamingProduct->goods_num =  $num[$index];
                $StreamingProduct->category =  $category;
                $StreamingProduct->pic_url = $image->link();
                $StreamingProduct->goods_key = $goods_key;
                $StreamingProduct->keyword = $keyword;
                $StreamingProduct->save();

                $index++;
            }

           

           

            return "true";
        } catch (\Exception $e) {
            return "false";
        }
    }

    //手動得標
    public function CheckInventory()
    {
        $page = Page::where('ps_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;

        $fb_id = $request->input('fb_id'); //ps_id
        $fb_name = $request->input('fb_name');
        $token = $request->input('token');
        $message_id = $request->input('message_id');


        //解析留言
        $comment_message = $request->input('comment_message');
        $comment = $this->make_semiangle($comment);
        str_replace(" ", "", $comment);
        $stack = array();
        $str = explode("+", $comment);

        foreach ($keyword as $key) {

            foreach ($str as $i => $eachstr) {

                if (strpos($eachstr, $key) !== false) {
                    $filteredNumbers = array_filter(preg_split("/\D+/", $str[$i + 1]));
                    $firstOccurence = reset($filteredNumbers);

                    $value = array('key' => $key, 'num' => $firstOccurence);
                    array_push($stack, $value);
                }
            }
        }
        //-----------------

        list($Code, $bid_num, $single_price) = $this->ProductValidation($stack['key'], $stack['num']);
        //存Member
        $if_exist = Member::where('ps_id', '=', $fb_id)
            ->where('page_id', '=', $page_id)
            ->first();

        if ($if_exist == null) {
            $member_store = new Member();
            $member_store->page_id = $page_id;
            $member_store->ps_id = $fb_id;
            $member_store->as_id = '';
            $member_store->fb_name = $fb_name;
            $member_store->bid_times = 1;
            $member_store->checkout_times = 0;
            $member_store->blacklist_times = 0;
            $member_store->money_spent = 0;
            $member_store->member_type = 1;
            $member_store->save();
        } else {
            Member::where('ps_id', '=', $fb_id)
                ->where('page_id', '=', $page_id)
                ->increment('bid_times');
        }

        //存入DB
        $page_store = new StreamingOrder();
        $page_store->page_id = $page_id;
        $page_store->live_video_id = $live_video_id;
        $page_store->goods_num =  $bid_num;
        $page_store->single_price = $single_price;
        $page_store->comment =  $comment_content;
        $page_store->product_id =  $product_id;
        // $page_store->uid = $uid;
        $page_store->save();


        try {
            PrivateMessage($Code, $message_id, $fb_id, $page_id, $token, $bid_num);
            $facebook_comment[$comment_count]['can_reply_privately'] = false;
        } catch (Exception $e) { }
    }

    public function PrivateMessage($Code, $message_id, $PSID, $page_id, $token, $num)
    {
        //$Code -> 成功得標、商品完售、數量不足    
        //$message_id -> 留言私訊ID
        //$PSID -> 留言者ID
        //$page_id -> 粉絲團ID
        //$token -> 粉絲團權限
        //$num -> 商品數量

        switch ($Code) {
            case 'success':
                $reply = "請至http://livego.com.tw/buyer_index?page_id={$page_id}&uid={$PSID}結帳，謝謝！";
                break;
            case 'insufficient':
                $reply = "很抱歉！由於商品庫存不足，得標數量改為{$num}。結帳請至http://livego.com.tw/buyer_index?page_id={$page_id}&uid={$PSID}，謝謝！";
                break;
            case 'soldout':
                $reply = "很抱歉！由於商品庫存不足，得標失敗！";
                break;
        }


        $post_url = "https://graph.facebook.com/v4.0/{$message_id}/private_replies?message={$reply}&access_token={$token}";
        $this->request_post($post_url);

        // $query = '/' . $message_id . '/private_replies';
        // $response = $this->api->post($query, array('message' => $reply), $token);
    }

    public function LiveVideo($page_id, $token)
    {

        $live_video = file_get_contents("https://graph.facebook.com/" . $page_id . "?fields=live_videos.limit(1){video,status,embed_html},id%7Bid%7D&access_token=" . $token);
        $live_video = json_decode($live_video, true);

        if (!isset($live_video['live_videos'])) {
            // count = 1 從未開啟直播  count =2 有開啟直播過
            //return redirect()->back()->with('fail', '直播尚未開啟！');
        } else {
            foreach ($live_video['live_videos']['data'] as $live_video) {
                if ($live_video['status'] == 'LIVE') {
                    return $live_video;
                }
            }
        }
        //return redirect()->back()->with('fail', '直播尚未開啟！');

    }

    public function ProductValidation($goodkey, $message_num)
    {
        //$goodkey -> 商品key值
        //$message_count ->留言數量

        //查詢商品庫存
        //這邊驗證使用關鍵字驗證
        $product = StreamingProduct::where('goods_key', '=', $goodkey)->first();
        $product_id = $product->product_id;
        $product_num = $product->goods_num;
        $single_price = $product->goods_price;
        $bid_num = 0;
        if ($product_num == 0) {
            //無商品庫存
            $Code = 'soldout';
        } else if ($product_num < $message_num) {
            //買家留言數量大於庫存數量
            $Code = 'insufficient';
            $bid_num = $product_num;
        } else {
            //正常得標
            $Code = 'success';
            $bid_num = $message_num;
        }

        return [$Code, $bid_num, $single_price, $product_id];
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
            $image = Imgur::upload();
            $image_url = $image->link();
        }
        $prize_name = $request->input('prize_name');
        $prize_num = (int)$request->input('prize_num');
        $page_id = $request->input('page_id');
        $video_id = $request->input('video_id');
        $page_token = $request->input('page_token');

        $arr_lucky = $request->input('arr_lucky');
        $arr_lucky_keys = $request->input('arr_lucky_keys');
        

        
        //產生0~count($arr)-1的陣列
        $tmp = range(0,(count($arr_lucky)-1));
        if(count($arr_lucky) >= $prize_num)
        {
            //從此陣列取$prize_num個rand
            $arr_temp = array_rand($tmp,$prize_num);
        }
        else
        {
            //從此陣列取count($arr_lucky)個rand
            $arr_temp = array_rand($tmp,count($arr_lucky));
        }

        $winner_comment = '恭喜 ';
        for($i=0;$i<$prize_num;$i++)
        {
            if($prize_num == 1)
            {
                $key = $arr_lucky_keys[(int)$arr_temp];
            }
            else
            {
                $key = $arr_lucky_keys[(int)($arr_temp[$i])];
            }
            
            $prize_store = new Prize();
            $prize_store->page_id = $page_id;
            $prize_store->ps_id = $arr_lucky[$key]['ps_id'];
            $prize_store->product_name = $prize_name;
            $prize_store->image_url = $image_url;
            $prize_store->save();

            $winner_comment .= $arr_lucky[$key]['name'].' ';
        }
        $winner_comment .= '中獎！';
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
        

        //如果有開啟限定會員抽獎
        //但是前面資格還是會顯示所有人
        // foreach ($compliance as $query) {
        //     $member = Member::where('page_id', $page_id)
        //         ->where('ps_id', $query[2])
        //         ->first();

        //     if ($member) {
        //         $memberlist[$member->fb_name][0] = $query[0];
        //         $memberlist[$member->fb_name][1] = $query[1];
        //         $memberlist[$member->fb_name][2] = $query[2];
        //     }
        // }

        return $compliance;
    }

    public function TopFiveShoper(Request $request)
    {
        $today = new DateTime('today');
        $page_id =  $request->input('page_id');
        $query = StreamingOrder::whereDate('streaming_order.created_time', $today)
            ->where('streaming_order.page_id', $page_id)
            ->where('member.page_id', $page_id)
            ->join('member', 'streaming_order.ps_id', '=', 'member.ps_id')
            ->select('streaming_order.ps_id', 'member.fb_name', 'streaming_order.single_price', 'streaming_order.goods_num')
            ->get();

        // 將資料相同的筆數儲存唯一筆
        // ex [金城武,10444221] = array(100,200,300)  array為每筆的總和
        $result = array();
        foreach ($query as $k => $v) {
            $total = $v->single_price * $v->goods_num;
            $result[$v->fb_name . ',' . $v->ps_id][] =  $total;
        }

        // 將上面陣列後面總和數相加
        $shoper_list = array();
        foreach ($result as $key => $value) {
            $array_date = explode(",", $key);
            $shoper_list[] = array('ps_id' => $array_date[1], 'total' => array_sum($value), 'fb_name' => $array_date[0]);
        }

        return $shoper_list;
    }

    public function CommoditySalesList(Request $request)
    {
        $today = new DateTime('today');
        $page_id = $request->input('page_id');
        $query = StreamingOrder::whereDate('streaming_order.created_time', $today)
            ->where('streaming_order.page_id', $page_id)
            ->Join('streaming_product', 'streaming_order.product_id', '=', 'streaming_product.product_id')
            ->select('streaming_order.single_price', 'streaming_order.goods_num', 'streaming_product.pic_url', 'streaming_product.goods_name', 'streaming_product.category', 'streaming_product.goods_key')
            ->get();

        // 將資料相同的筆數儲存唯一筆
        // ex [商品名稱,種類,goods_key,圖片網址] = array(100,200,300)  array為每筆的總和
        $result = array();
        foreach ($query as $k => $v) {
            $total = $v->single_price * $v->goods_num;
            $result[$v->goods_name . ',' . $v->category . ',' . $v->goods_key . ',' . $v->pic_url][] =  $total;
        }

        // 將上面陣列後面總和數相加
        $goods_list = array();
        foreach ($result as $key => $value) {
            $array_date = explode(",", $key);
            $goods_list[] = array('goods_name' => $array_date[0], 'category' => $array_date[1], 'goods_key' => $array_date[2], 'pic_url' => $array_date[3],  'total' => array_sum($value));
        }
        return $goods_list;
    }

    public function GetShopThreeDaysCustomer(Request $request)
    {
        $tomorrow = new DateTime('today +1 day');
        $the_first_threedays = new DateTime('today -3 day');
        $query = DB::table('streaming_order')->whereBetween('streaming_order.created_at', [$the_first_threedays, $tomorrow])
            ->join('member', 'streaming_order.ps_id', '=', 'member.ps_id')
            ->select('member.fb_name', 'member.ps_id')
            ->groupBy('member.fb_name')
            ->get();

        return $query;
    }

    public function Comment($video_id,$access_token,$comment)
    {
        $comment = urlEncode($comment);
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

    public function PickedGoods()
    {
        $page_id = '10444221';
        $keywords = ['A01', 'A02', 'A03'];
        $video_id = "123";

        $live_product = array();
        $live_product_show = array();
        foreach ($keywords as $keyword) {
            $query = StreamingProduct::where('page_id', $page_id)
                ->where('keyword', $keyword)
                ->get()->toArray();
            array_push($live_product, $query);
        }



        foreach ($live_product as $key => $data) {
            $count = count($data);
            $category = '';
            for ($i = 0; $i < $count; $i++) {
                $query = StreamingOrder::where('page_id', $page_id)
                    ->where('live_video_id', $video_id)
                    ->where('product_id', $data[$i]['product_id'])
                    ->select('goods_num')
                    ->get()
                    ->toArray();

                //計算得標次數
                $bid_times = 0;
                foreach ($query as $time) {
                    $bid_times = $bid_times + $time['goods_num'];
                }

                if ($data[$i]['product_id'] != "無屬性") {
                    if ($live_product[$key][$i]['product_id'] = $data[$i]['product_id']) {
                        $category =  $category . '<b>(' . $live_product[$key][$i]['category'] . ')</b>&nbsp;&nbsp;';
                    } else {
                        $category =  $category . '(' . $live_product[$key][$i]['category'] . ')&nbsp;&nbsp;';
                    }
                }

                $live_product_show[] = array('bid_times' => $bid_times, 'goods_num' => $data[$i]['goods_num'], 'pic_url' => $data[$i]['pic_url'], 'goods_name' => $data[$i]['goods_name'], 'goods_price' => $data[$i]['goods_price'], 'category' => $data[$i]['category'], 'goods_key' => $data[$i]['goods_key'], 'categorys' => $category);
            }



            // $category ='';
            // for($i=0;$i<$count;$i++){
            //     if($live_product[$key]['product_id']=$data[$i]['product_id']){
            //         $category =  $category.'<b>('.$live_product[$key][$i]['category'].')</b>&nbsp;&nbsp;' ;
            //     }else{
            //         $category =  $category.'('.$live_product[$key][$i]['category'].')&nbsp;&nbsp;' ;
            //     }
            // }

            // $live_product_show[]=array('bid_times'=>array_sum($query),'goods_num'=>$data->goods_num,'pic_url'=>$data->pic_url,'goods_name'=>$data->goods_name,'goods_price'=>$data->goods_price,'category'=>$data->category,'goods_key'=>$data->goods_key,'categorys'=>$category);


        }

        dd($live_product_show);
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
}
