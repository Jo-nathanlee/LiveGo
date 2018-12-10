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



class AnalysisController extends Controller
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
        $page = Page::where('fb_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;
        $page_token = $page->page_token;
        $query = '/' . $page_id . '/live_videos';
        try {
            $response = $this->graphapi($query, $token);
            $item = 0;
            $videos = $response->getGraphEdge()->asArray();
            if(count($videos)>0)
            {
                $video_id = $videos[0]['id'];

                $arr= array();
                $query2 = '/' . $video_id . '?fields=comments.limit(999999)';
                try {
                    $response = $this->graphapi($query2, $token);
                    $comments = $response->getGraphNode();
                    if (isset($comments['comments'])) {
                        $comments = $comments['comments'];
                        foreach ($comments as $key) {
                            if( strpos($comments['comments'], '+' )===false)
                            {
                                array_push( $arr,$comments['comments']);
                            }
                        }
                    }

                    if(count($arr)>0)
                    {
                        $StreamingOrderQuery = StreamingOrder::where('live_video_id','=',$video_id)
                        ->get();

                        foreach($StreamingOrderQuery as $query)
                        {
                            array_push( $arr,$query->goods_name );
                        }

                        $all_comments = '';
                        for($i=0;$i<count($arr);$i++)
                        {
                            $all_comments .= $arr[$i];

                        }

                        return view('analysis',[ 'comments' => json_encode($all_comments, true)]);



                    }


                    

                } catch (FacebookSDKException $e) {
                    dd($e);
                }
            }
            else
            {
                return redirect()->back()->with('alert', '尚未有資料！');
            }
        } catch (FacebookSDKException $e) {
            return redirect()->back(); // handle exception
        }

        return view('analysis');
    }
}