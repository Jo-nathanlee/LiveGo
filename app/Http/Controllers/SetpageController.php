<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use DB;
use App\Entities\PageDetail;
use App\Entities\Page;
use App\Entities\StreamingOrder;
use App\Entities\ShipSet;
use App\Entities\PayMethod;
use App\Entities\ShippingFee;
use App\User;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Validator;

class SetpageController extends Controller//設定粉絲團
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

    public function Setting()
    {
        $user      = Auth::user();
        $token     = $user->token;
        $queryPage = '/me/accounts';
        $fanPage  = [];


        $pages = $this->graphapi($queryPage, $token)->getGraphEdge()->asArray();
        
        $myPage = Page::where('as_id', $user->fb_id)->first();

        $fb_id = $myPage->as_id;
        $name = $myPage->fb_name;
        $token = $myPage->page_token;
        $page_id = $myPage->page_id;

        $if_pageid_exsist = PageDetail::where('page_id', $page_id)->first();

            if ($if_pageid_exsist == null) {
                $data = array(
                    'page_id' => $page_id,
                    'sender_address' =>  '' ,
                    'sender_address_forever' => '' , 
                    'sender_name' => '' ,
                    'sender_phone' =>  '09xx' ,
                    'sender_email' =>  '' ,
                    'sender_id' =>  'F1234' ,
                    'bank_code' =>  '' ,
                    'bank_name' =>  '' ,
                    'bank_account' =>  '',
                    'bank_account_name' => '',
                    'home_delivery' =>  1,
                    'seven_eleven' =>  1,
                    'ok_mart' =>  1,
                    'family_mart' =>  1,
                    'hi_life' =>  1
                );
                DB::table('page_detail')->insert($data);
            }

        $if_fee_exsist = DB::table('shipping_fee')->where('page_id', $page_id)->first();

            if ($if_fee_exsist == null) {
                $data = array(
                    array('page_id' => $page_id, 'ship_id' => '13', 'fee' => '120', 'free_shipping' => '1000', 'sender_name' => '', 'sender_phone' => '', 'sender_address' =>''),
                    array('page_id' => $page_id, 'ship_id' => '14', 'fee' => '60', 'free_shipping' => '1000', 'sender_name' => '', 'sender_phone' => '', 'sender_address' =>''),
                    array('page_id' => $page_id, 'ship_id' => '16', 'fee' => '60', 'free_shipping' => '1000', 'sender_name' => '', 'sender_phone' => '', 'sender_address' =>''),
                    array('page_id' => $page_id, 'ship_id' => '15', 'fee' => '60', 'free_shipping' => '1000', 'sender_name' => '', 'sender_phone' => '', 'sender_address' =>''),
                    array('page_id' => $page_id, 'ship_id' => '17', 'fee' => '60', 'free_shipping' => '1000', 'sender_name' => '', 'sender_phone' => '', 'sender_address' =>'')
                );
                DB::table('shipping_fee')->insert($data);

            }

        $page_detail = DB::table('page_detail')
        ->where('page_id',$page_id)
        ->first();

        if($page_detail != null){
            foreach ($pages as $key => $accessToken)
            {
                // 儲存粉絲專頁物件
                $fanPage[$key]['page_name'] = $accessToken['name'];
                $fanPage[$key]['page_id'] = $accessToken['id'];
                $fanPage[$key]['access_token'] = $accessToken['access_token'];
            }


            

            return view('setting', [ 'myPage' => $myPage ,'fanPage' => $fanPage , 'page_detail' => $page_detail , 'fb_id' => $fb_id,'name' => $name,'page_id' => $page_id, 'token' => $token]);
        }

        

    }
    
    public function manager(Request $request){
        if (Gate::allows('seller-only',  Auth::user())) {
            $manager = Page::where('fb_id', Auth::user()->fb_id)->first();
            if($manager->fb_id=="1846704858682156" OR $manager->fb_id=="2571535889539984" ){
                $user = DB::table('user')->get();
                $page = DB::table('page')->get();
                return view('manager', ['user' => $user , 'page'=>$page , 'manager' => $manager]);
            }else{
                return redirect('/')->with('fail', '想幹嘛?');
            }
        }
        else
        {
            return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
        }


    }

    public function UpdatePage(Request $request){
        $page = Page::where('as_id', Auth::user()->fb_id)->first();

        $update =  Page::updateOrCreate(
            ['page_id' => $page->page_id, 'as_id' => $page->as_id],
            ['page_name' =>  $request->page_name , 'page_id' => $request->page_id , 'page_token' => $request->page_token ]
        );

        $if_pageid_exsist = PageDetail::where('page_id', $request->page_id)->first();

            if ($if_pageid_exsist == null) {
                $data = array(
                    'page_id' => $request->page_id,
                    'sender_address' =>  '' ,
                    'sender_address_forever' => '' , 
                    'sender_name' => '' ,
                    'sender_phone' =>  '09xx' ,
                    'sender_email' =>  '' ,
                    'sender_id' =>  'F1234' ,
                    'bank_code' =>  '' ,
                    'bank_name' =>  '' ,
                    'bank_account' =>  '',
                    'bank_account_name' => '',
                    'home_delivery' =>  1,
                    'seven_eleven' =>  1,
                    'ok_mart' =>  1,
                    'family_mart' =>  1,
                    'hi_life' =>  1
                );
                DB::table('page_detail')->insert($data);
            }

        $if_fee_exsist = DB::table('shipping_fee')->where('page_id', $request->page_id)->first();

            if ($if_fee_exsist == null) {
                $data = array(
                    array('page_id' => $request->page_id, 'ship_id' => '13', 'fee' => '120', 'free_shipping' => '1000', 'sender_name' => '', 'sender_phone' => '', 'sender_address' =>''),
                    array('page_id' => $request->page_id, 'ship_id' => '14', 'fee' => '60', 'free_shipping' => '1000', 'sender_name' => '', 'sender_phone' => '', 'sender_address' =>''),
                    array('page_id' => $request->page_id, 'ship_id' => '16', 'fee' => '60', 'free_shipping' => '1000', 'sender_name' => '', 'sender_phone' => '', 'sender_address' =>''),
                    array('page_id' => $request->page_id, 'ship_id' => '15', 'fee' => '60', 'free_shipping' => '1000', 'sender_name' => '', 'sender_phone' => '', 'sender_address' =>''),
                    array('page_id' => $request->page_id, 'ship_id' => '17', 'fee' => '60', 'free_shipping' => '1000', 'sender_name' => '', 'sender_phone' => '', 'sender_address' =>'')
                );
                DB::table('shipping_fee')->insert($data);

            }

        $query = DB::table('page_detail')->where('page_id',$request->page_id)->first();

        return json_encode($query, true);
    }

    public function UpdatePagedeatil(Request $request){
        $query = PageDetail::updateOrCreate(
                ['page_id' => $request->page_id],
                [
                    'sender_address' => $request->sender_address,
                    'sender_address_forever' => $request->sender_address_forever,
                    'sender_name'=> $request->sender_name,
                    'sender_phone'=> $request->sender_phone,
                    'sender_email'=> $request->sender_email,
                    'sender_id'=> $request->sender_id,
                    'bank_code'=> $request->bank_code,
                    'bank_name'=> $request->bank_name,
                    'bank_account'=> $request->bank_account,
                    'bank_account_name'=> $request->bank_account_name,
                    'home_delivery'=> $request->home_delivery,
                    'seven_eleven'=> $request->seven_eleven,
                    'ok_mart'=> $request->ok_mart,
                    'family_mart'=> $request->family_mart,
                    'hi_life'=> $request->hi_life
                ]
            );
        
        return json_encode($query, true);
    }
    
    public function UpdateShippingFee(Request $request){
        
        $query = ShippingFee::updateOrCreate(
            ['page_id' => $request->page_id, 'ship_id' => $request->ship_id],
            [
                'fee'=> $request->fee,
                'free_shipping'=> $request->free_shipping,
                'sender_name'=> $request->sender_name,
                'sender_phone'=> $request->sender_phone,
                'sender_address'=> $request->sender_address
            ]
        );
    
        return json_encode($query, true);
    }

    public function GetShipSet(Request $request){
        
        $query = ShippingFee::where('page_id', $request->page_id)
                            ->where('ship_id', $request->ship_id)
                            ->first();
    
        return json_encode($query, true);
    }
}