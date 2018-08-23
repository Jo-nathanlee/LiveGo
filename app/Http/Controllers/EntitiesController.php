<?php

namespace App\Http\Controllers;

use App\Entities\Page;
use App\Entities\StreamingOrder;
use App\Entities\ShopOrder;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntitiesController extends Controller
{
    public function CreateOrUpdatePage(Request $request)
    {
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
        return redirect('/home');
    }

    public function BuyerIndexShow(Request $request)
    {
       try
        {
            $fb_id=Auth::user()->fb_id;
            $query = StreamingOrder::where('fb_id', '=', $fb_id)
                    ->whereNull('streaming_order.order_id')
                    ->select('page_name','fb_id','name','goods_name','goods_price','goods_num','total_price')
                    ->get();
                     
    
            $query2 = ShopOrder::where('fb_id', '=', $fb_id) 
                      ->select('page_name','fb_id','name','goods_name','goods_price','goods_num','total_price')
                      ->get();
    
            $cart=$query->union($query2);
            $cart=$cart->groupBy('page_name');

            return view('buyer_index', ['shopping_cart' => $cart]);
        }
        catch(Exception $e)
        {
            return view('buyer_index', ['nothing' => '']);
        }
    }
}
