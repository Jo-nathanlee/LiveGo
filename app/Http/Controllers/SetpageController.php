<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use DB;
use App\Entities\PageDetail;
use App\Entities\Page;
use App\Entities\StreamingOrder;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

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

    public function show()
    {
        // if (Gate::allows('seller-only',  Auth::user())) {
            $query = '/me/accounts';
            $token = Auth::user()->token;

            try {
                $response = $this->graphapi($query, $token);
                //manage_page
                $item = 0;
                $pages = $response->getGraphEdge()->asArray();
                foreach ($pages as $key) {

                    for ($i = 0; $i < count($key['perms']); $i++) {
                        if ($key['perms'][$i] == 'ADMINISTER') {

                            $query = '/' . $key['id'] . '?fields=picture'; //page's pic
                            $response2 = $this->graphapi($query, $token);
                            $graphNode = $response2->getGraphNode();
                            $pic_url = $graphNode['picture']['url'];
                            $page_token = $key['access_token'];

                            $page[$item][0] = $key['name'];
                            $page[$item][1] = $key['id'];
                            $page[$item][2] = $pic_url;
                            $page[$item][3] = $page_token;

                        }
                    }
                    $item++;
                }

                return view('set_page', ['page' => $page]);
            } catch (FacebookSDKException $e) {
                dd($e); // handle exception
            }
        // }
        // else
        // {
        //    return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
        // }
    }
    //存入資料庫
    public function CreateOrUpdatePage(Request $request)
    {
        // if (Gate::allows('seller-only',  Auth::user())) {
            if($request->has('id')){
                $page = $request->input('id');
                $id_name_token = preg_split("/[,]+/", $page);
                $page_id = $id_name_token[0];
                $request->session()->put('page_id', $page_id);
                $page_name = $id_name_token[1];
                $page_token = $id_name_token[2];
                $page_pic = $id_name_token[3];
                $page_store = Page::updateOrCreate(
                    ['fb_id' => Auth::user()->fb_id],
                    [
                        'name' => Auth::user()->name,
                        'page_id' => $page_id,
                        'page_name' => $page_name,
                        'page_pic' => $page_pic,
                        'page_token' => $page_token,
                    ]
                );

                DB::table('page_detail')
                ->updateOrCreate(
                    ['page_id' => $page_id],
                    [
                        'deadline_time' => 24,
                        'freight' => 60,
                    ]
                );



                return redirect()->back()->with('alert', '綁定成功！');
            }
            else
            {
                return redirect()->back()->with('alert', '請選擇粉絲團！');
            }
        // }
        // else
        // {
        //    return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
        // }
    }

    //公司地址、電話設定
    public function CompanyInfoSetting(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;

            $company_info = PageDetail::where('page_id', '=', $page_id)
            ->first();


            return view('set_company_info', ['address' => $company_info->company_address,'phone' => $company_info->company_phone]);
        }
        else
        {
            return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
        }
    }

    public function Set_CompanyInfo(Request $request)
    {
        $address =  $request->input('address');
        $phone = $request->input('phone');

        
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;

        DB::table('page_detail')
        ->where('page_id', '=', $page_id)
        ->update(['company_address' => $address,'company_phone' => $phone]);

        return redirect()->back()->with('alert', '成功!');
    }

    public function DeliverySetting(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
     


            return view('set_delivery');
        }
        else
        {
            return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
        }
    }
    

}