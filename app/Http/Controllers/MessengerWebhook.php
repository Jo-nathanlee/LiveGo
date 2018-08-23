<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class MessengerWebhook extends Controller
{
public function index(Request $request)
{
// 與FB及Wit.ai 界接的參數
$hubVerifyToken = 'AccessToken'; // 這裏寫的字串，後面我們設定 webhooks 時要一致
$accessToken = 'EAAG68eMy2QgBAC7t11ZBsaL7PB1UD0MX9hLAQb5xhIdW90ASHDZCmNrjNypEAgSLhmOfR04dSddYRe9alQM9tZCXZA5KEmdxGUdyZAYZARFKNeb5BgpE1O8kHKlzYEAv0ZBdA2HiZB8b29uaPvWTN9wuQsdC5VRMde2He3Od4jAPRHvLaVL0drB0okgqmAqZAvpNbbqBXZAcduYgZDZD';


// check token at setup
if (!empty($_REQUEST['hub_mode']) && $_REQUEST['hub_mode'] == 'subscribe') {
    if($_REQUEST['hub_verify_token'] == $hubVerifyToken) {
        echo $_REQUEST['hu_challenge'];
        exit;
    }
}

// 接收來自 Facebook 的 input
$input = json_decode(file_get_contents('php://input'), true);
$senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
$messageText = $input['entry'][0]['messaging'][0]['message']['text'];

// 收到什麼就回傳什麼

$answer = $messageText;

$response = [
    'recipient' => [ 'id' => $senderId ],
    'message' => [ 'text' => $answer ]
];

$ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_exec($ch);
curl_close($ch);
}
}