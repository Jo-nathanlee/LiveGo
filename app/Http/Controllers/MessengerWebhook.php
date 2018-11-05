<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entities\ChatbotPage;

class MessengerWebhook extends Controller
{
    public function index(Request $request)
    {
        $this->verifyAccess();
    	$input   = json_decode(file_get_contents('php://input'), true);
    	$id 	 = $input['entry'][0]['messaging'][0]['sender']['id'];
    	$message = $input['entry'][0]['messaging'][0]['message']['text'];
		$reply='';
		if(stripos($message, 'live go')!==false||stripos($message, 'livego')!==false||stripos($message, '來福')!==false||stripos($message, '來福狗')!==false||stripos($message, '介紹')!==false||stripos($message, '影片')!==false)
		{
			$reply='想知道什麼是LIVE GO嗎？回覆 觀看影片
					想知道LIVE GO能解決什麼問題嗎？回覆 什麼問題
					想知道如何操作LIVE GO嗎？回覆 怎麼用';
		}
		if($message=='觀看影片')
		{
			$reply='點擊 https://www.youtube.com/watch?v=xYv2DRMK84A&feature=youtu.be 觀看影片';
		}
		if($message=='什麼問題')
		{
			$reply='LIVE GO能幫您解決
			(1) 購物流程過於繁雜 
			(2) 訂單資訊模糊不明確
			(3) 訂單填寫錯誤
			(4) 電商人力需求過多 
			(5) 買家惡意棄標';
		}
		if($message=='怎麼用')
		{
			$reply='點擊 https://www.youtube.com/watch?v=Br54KQ8Jjyc&feature=youtu.be 觀看影片';
		}
    	$response = [
    		'recipient'		=>	['id'   => $id ],
			'message'		=>	['text' => '點選你想知道關於LIVE GO什麼吧！',
								 'quick_replies =>']
		];
		
		if($reply!='')
		{
			$this->sendMessage($response);
		}
		
    }

    protected function sendMessage($response)
    {
    	// set our post
    	$ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token=' . env('PAGE_ACCESS_TOKEN'));
    	curl_setopt($ch, CURLOPT_POST, 1);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
    	curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    	curl_exec($ch);
    	curl_close($ch);
    }

	protected function verifyAccess()
    {
    	// FACEBOOK_MESSENGER_WEBHOOK_TOKEN is not exist yet.
    	// we can set that up in our .env file
    	$local_token = env('FACEBOOK_MESSENGER_WEBHOOK_TOKEN');
    	$hub_verify_token = request('hub_verify_token');
    	// condition if our local token is equal to hub_verify_token
    	if ($hub_verify_token === $local_token) {
    		// echo the hub_challenge in able to verify.
    		echo request('hub_challenge');
    		exit;
    	}
    }

}