<?php

namespace App\Http\Controllers;

use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Support\Facades\Auth;

class GraphController extends Controller
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
        try {
            // Get the \Facebook\GraphNodes\GraphUser object for the current user.
            // If you provided a 'default_access_token', the '{access-token}' is optional.
            $response = $this->api->get($query, $token);
            return $response;
        } catch (FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    public function retrieveUserProfile()
    {

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

                        $page[$item][0] = $key['name'];
                        $page[$item][1] = $key['id'];
                        $page[$item][2] = $pic_url;

                    }
                }
                $item++;
            }

            return view('set_page', ['page' => $page]);
        } catch (FacebookSDKException $e) {
            dd($e); // handle exception
        }

    }
}
