<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use App\Entities\Page;
use App\Entities\StreamingOrder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use App\User;



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
        $token = $page->page_token;
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
                            if( strpos($key['message'], '+' )===false)
                            {
                                array_push( $arr,$key['message']);
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
                            $new = str_replace("/n","",(string)($arr[$i]));
                            $new2 = str_replace("\n","", $new);
                            $all_comments .= $new2;
                        }

                       
                        return view('analysis',[ 'comments' => $all_comments]);



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

    public function index_show(Request $request)
    {
        return view('analysis_index');
    }

    public function Seller_FeedBack(Request $request)
    {
        
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            //$page_id = $page->page_id;
            $page_name = $page->page_name;
            //$user_id = Auth::user()->fb_id;
            $user_name = Auth::user()->name;
            

            return view('seller_feedback',['user_name' => $user_name, 'page_name' => $page_name]);
       }
       else
       {
          return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
       }
 
    }

    public function Sent_FeedBackEmail(Request $request)
    {
        
        if (Gate::allows('seller-only',  Auth::user())) {
            $page = Page::where('fb_id', Auth::user()->fb_id)->first();
            $page_id = $page->page_id;
            $page_name = $page->page_name;
            $user_id = Auth::user()->fb_id;
            $user_name = Auth::user()->name;

            $mail_title = $request->input('mail_title');
            $mail_content = $request->input('mail_content');

            //寄件人
            $from = ['email'=>'s10444221@gmail.com',
                    'name'=>'LiveGo意見回饋系統',
                    'subject'=>'LiveGo：'.$mail_title
            ];

            //填寫收信人信箱
            $to = ['email'=>'jerrychen.livego@gmail.com',
                    'name'=>'xxx'];

            //信件的內容
            $data = ['page_id'=>$page_id,
                    'page_name'=>$page_name,
                    'user_id'=>$user_id,
                    'user_name'=>$user_name,
                    'subject'=>'LiveGo：'.$mail_title,
                    'mail_content'=>$mail_content
            ];

            //寄出信件
            Mail::send('emails.feedback', $data, function($message) use ($from, $to) {
            $message->from($from['email'], $from['name']);
            $message->to($to['email'])->subject($from['subject']);
            });
            
            return redirect()->back()->with('success', '傳送成功！');
            
       }
       else
       {
          return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
       }
 
    }
}