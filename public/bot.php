<?php
$access_token = "EAAG68eMy2QgBAJ3ZAoge1XWpCwsttmNEMbgQuE5ZBRgAhAZBh6M38hSdtqQQlIKClZBb5dallgmsKrpnOKbntPzQSsZAjHgZCZAPlsDxyAi7L3zCBfwzHv3g9QbeFZC83Tps7kp3TgFpzGDcepm7aqky77iNUZAsGVJ9LCX4wg5McftmZBx8yCXgKXkCkiT90ZCYCruAEZBu1iwrYwZDZD";
$verify_token = "my_token";
$hub_verify_token = null;
 
if(isset($_REQUEST['hub_challenge'])) {
    $challenge = $_REQUEST['hub_challenge'];
    $hub_verify_token = $_REQUEST['hub_verify_token'];
}
 
 
if ($hub_verify_token === $verify_token) {
    echo $challenge;
}




$input = json_decode(file_get_contents('php://input'), true);
 $commentID = $input['entry'][0]['changes'][0]['value']['comment_id'];
$mess = $input['entry'][0]['changes'][0]['value']['message'];
$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
$message = $input['entry'][0]['messaging'][0]['message']['text'];




$url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$access_token;
 
 
//Initiate cURL.
$ch = curl_init($url);
 
//The JSON data.
$jsonData = '{
    "recipient":{
        "id":"'.$commentID.'"
    },
    "message":{
        "text":"hi"
    }
}';
 
//Encode the array into JSON.
$jsonDataEncoded = $jsonData;
 
//Tell cURL that we want to send a POST request.
curl_setopt($ch, CURLOPT_POST, 1);
 
//Attach our encoded JSON string to the POST fields.
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
 
//Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
 
//Execute the request
if(!empty($mess)){
    $result = curl_exec($ch);
}


?>