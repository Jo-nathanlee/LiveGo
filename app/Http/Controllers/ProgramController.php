<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use DB;
use App\Entities\PageDetail;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;


class ProgramController extends Controller
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

    public function index(Request $request)
    {
        $query =  DB::table('page_detail')->distinct()->get();

        $arr = array();
        $item = 0;
        $page_id = '';
        foreach($query as $page)
        {
            $page_id = $page->page_id;

            $page_name = $page->page_name;
            $page_token = $page->page_token;
            //graph api 查詢
            $graph_query = '/' . $page_id . '/live_videos';
            
            try {
                $response = $this->graphapi($graph_query, $page_token);
               
               
                $videos = $response->getGraphEdge()->asArray();
               
                $temp = 0;
                $url = '';
                foreach ($videos as $video) {
                    if ($video['status'] == 'LIVE') {
                        $temp++;
                       
                        $url = $video['embed_html'];
                    }
                }

                if($temp>0)
                {
                    $arr[$item] = array(
                        'page_name' => $page_name,
                        'page_id' => $page_id,
                        'url' => $url,
                    );
                    $item++;
                }
                
            } catch (FacebookSDKException $e) {
                dd($e);
                //return view('program'); // handle exception
            }


        }

        dd(json_encode($arr,true)  );

        if ($item>0) {
            return view(
                'program', ['arr' => json_encode($arr,true),'page_id' => $page_id]
            );
        }
        else
        {
            return view('program',['page_id' => $page_id]);
        }
    }
}
