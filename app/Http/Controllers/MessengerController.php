<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use App\Entities\Page;
use App\Entities\StreamingOrder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;


class MessengerController extends Controller
{
    public function curl($url, $params = false, $ispost = 0, $https = 0)
    {
        $httpInfo = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        if ($https) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        }
        if ($ispost) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_URL, $url);
        } else {
            if ($params) {
                if (is_array($params)) {
                    $params = http_build_query($params);
                }
                curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
            } else {
                curl_setopt($ch, CURLOPT_URL, $url);
            }
        }

        $response = curl_exec($ch);

        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
        curl_close($ch);
        return $response;
    }

    public function send(Request $request)
    {
        $video_comment = file_get_contents("https://graph.facebook.com/v4.0/2298417493804397/comments?summary=1&access_token=EAAISZAHxUdOoBAN9gYVGGPlrvC32ApH2ZAaemXX9OPnr1YQoC53gYRPQjZC7rlupayGuKn8yZBqqvrS1PDkoWAXm28UmVQQbyb6PPjCL7SMNiuZCMbRcrInDXbAyC1HurYbamfMalrm2P1S1U2ZAzVZCWIJZApaFjR2Ht3CdIQzCZAXjM7YJYSPINnuE3bXk16eKSiiAdvByoDQZDZD");
        $video_comment = json_decode($video_comment, true);

        dd($video_comment['summary']);
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            $page_token = $page->page_token;
    
    
            $url = "https://graph.facebook.com/v4.0/me/messages?access_token=".$page_token;    
    
            $recipient = array(
                "id"=>"2402777343153289"
            );
            $message = array(
                "text"=>"fuck"
            );
            
           
            $data = json_encode([
                                "recipient" => $recipient,
                                "message" => $message,
                                ]);

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_exec($curl);
            curl_close($curl);
        
    }
    


    
    public function codeToSymbol($em) {
        if($em > 0x10000) {
            $first = (($em - 0x10000) >> 10) + 0xD800;
            $second = (($em - 0x10000) % 0x400) + 0xDC00;
            return json_decode('"' . sprintf("\\u%X\\u%X", $first, $second) . '"');
        } else {
            return json_decode('"' . sprintf("\\u%X", $em) . '"');
        }
    }

    public function mystrtoupper($a){  
        $b = str_split($a, 1);  
        $r = '';  
        foreach($b as $v){  
            $v = ord($v);  
            if($v >= 97 && $v<= 122){  
                $v -= 32;  
            }  
            $r .= chr($v);  
        }  
        return $r;  
    } 


}
