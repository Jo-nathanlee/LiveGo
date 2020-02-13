<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Entities\Page;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function ContainPage_ID($page_id)
    {
        if($page_id==null || $page_id=='')
            return false;
        else
            return true;
    }

    //私訊
    protected function SendAPI($psid,$text)
    {
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;
        $page_token = $page->page_token;

        $url = "https://graph.facebook.com/v4.0/me/messages?access_token=".$page_token;    

        $recipient = array(
            "id"=>$psid
        );
        $message = array(
            "text"=>$text
        );
        // "messaging_type" => "MESSAGE_TAG",
        // "tag" => "Order Status Update"
        $data = json_encode(["recipient" => $recipient,
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
}
