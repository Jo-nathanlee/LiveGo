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
use DB;
use DateTime;


class myController extends Controller
{
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
    public function FunctionName(Request $request)
    {

        $prize_img = "";
        $prize_name = "";
        $prize_count = "";
        $keyword = "抽抽";

        $video_id = '485853275476665';
        $token = 'EAAISZAHxUdOoBACoZBNruQKrDdD5Sl4RIQLkdvgwdAeXNPZBOCgctmRQ26BDvbB3063FCq8L0ZASJ21SQrj6XVj5IaLh6BzFkdilO2VW6DZBwlGgUA59rEi7kDxCaiWIwUWb4h2KEZC3jCkWnxNpZAGaAcf7f5Elkhlaj8WBm6X2AZDZD';
        $page_id = '1775801842732634';

        $facebook_comment = $this->GetFacebookComment($video_id, $token);

        $compliance = array();
        $memberlist = array();
        foreach ($facebook_comment as $accomplish) {
            if (strpos($accomplish['message'], $keyword) !== false) {
                if (!in_array($accomplish['from']['name'], $compliance)) {
                    $compliance[$accomplish['from']['name']][0] = $accomplish['message'];
                    $compliance[$accomplish['from']['name']][1] = $accomplish['id'];
                    $compliance[$accomplish['from']['name']][2] = $accomplish['from']['id'];
                }
            }
        }

        //如果有開啟限定會員抽獎
        //但是前面資格還是會顯示所有人
        foreach ($compliance as $query) {
            $member = Member::where('page_id', $page_id)
                ->where('ps_id', $query[2])
                ->first();

            if ($member) {
                $memberlist[$member->fb_name][0] = $query[0];
                $memberlist[$member->fb_name][1] = $query[1];
                $memberlist[$member->fb_name][2] = $query[2];
            }
        }

        dd($memberlist);
    }

    public function TopFiveShoper()
    {
        $today = new DateTime('today');
        $page_id = '1775801842732634';
        $query = StreamingOrder::whereDate('streaming_order.created_time', $today)
            ->where('streaming_order.page_id', $page_id)
            ->where('member.page_id', $page_id)
            ->Join('member', 'streaming_order.ps_id', '=', 'member.ps_id')
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

    public function CommoditySalesList()
    {
        $today = new DateTime('today');
        $page_id = '1775801842732634';
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
            $goods_list[] = array('goods_name' => $array_date[0], 'category' => $array_date[1], 'goods_key' => $array_date[2], 'pic_url' => $array_date[3],  'category' => array_sum($value));
        }
        return $goods_list;
    }

    public function GetShopThreeDaysCustomer()
    {
        $tomorrow = new DateTime('today +1 day');
        $the_first_threedays = new DateTime('today -3 day');
        $query = DB::table('streaming_order')->whereBetween('streaming_order.created_at', [$the_first_threedays, $tomorrow])
            ->join('member', 'streaming_order.ps_id', '=', 'member.ps_id')
            ->select('member.fb_name')
            ->groupBy('member.fb_name')
            ->get();

        return $query;
    }
    
    public function ShowProduct2(Request $request)
	{
		$page_id="10444221";
		$good = array();
		
		$all_product = StreamingProduct::where("page_id",$page_id)->get()->toArray();
		foreach($all_product as $K => $V)
		{
			/*-----------------------------------*///儲存個商品資訊good_information
			$good_info = array();
			
			$good[$V['keyword']]['good_info'][$V['goods_key']] = array('goods_num' => $V['goods_num'],
			'product_id' => $V['product_id'],
			'goods_name' => $V['goods_name'],
			'goods_price' => $V['goods_price'],
			'category' => $V['category']);
			
			/*-----------------------------------*///keyword->商品資訊->各商品資訊
			
			//$good[$V['keyword']]['good_info'][$V['goods_key']] = $good_info;	

			/*-----------------------------------*/

			unset($good_info);
		}
		
		
		dd($good);
	}

	public function ShowProduct(Request $request)
	{

        $page_id="10444221";
		$good = array();
		
		$all_product = StreamingProduct::where("page_id",$page_id)->get()->toArray();
		foreach($all_product as $K => $V)
		{
			/*-----------------------------------*///儲存個商品資訊good_information
			// $good_info = array();
			
			$good[$V['keyword']]['good_info'][$V['goods_key']] = array('goods_num' => $V['goods_num'],
			'product_id' => $V['product_id'],
			'goods_name' => $V['goods_name'],
			'goods_price' => $V['goods_price'],
			'category' => $V['category']);
			
			/*-----------------------------------*///keyword->商品資訊->各商品資訊
			
			//$good[$V['keyword']]['good_info'][$V['goods_key']] = $good_info;	

			/*-----------------------------------*/

			// unset($good_info);
		}
		
		
		dd($good);
		// return view('test');
	}
}


?>




