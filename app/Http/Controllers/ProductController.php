<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Entities\Page;
use App\Entities\StreamingProduct;
use App\Entities\AuctionList;
use App\Entities\StreamingOrder;
use App\User;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Uploadcare;
use GuzzleHttp\Exception\ClientException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Imgur;
use Yish\Imgur\Upload;
use PhpImap\ConnectionException;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersImport;
use App\Exports\UsersExport;

class ProductController extends Controller
{
    public function Excel_upload(Request $request)
    {

   
        $page = Page::where('as_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;
        $path = $request->file('excelFile');
        $excel_data = Excel::toCollection(new UsersImport, $path);
        $excel_data =  $excel_data[0];

        //第一列title不列入
        unset($excel_data[0]);
        $goods_group = array();

        foreach ($excel_data as $key=>$data) {
            if($data[1]!="" AND $data[3]!="" AND $data[4]!="" ){
                if(!is_numeric($data[3]) OR !is_numeric($data[4]) OR $data[1]==null ){
                    return redirect()->back()->with('fail', '第'.($key+1).'行格式輸入錯誤！請確認格式是否正確。');
                }
                if($data[0]==null){
                    $data[0]='https://imgur.com/jXYwclN';
                }
                $goods_group[$data[1]][$data[2]]=array(
                    'pic_url' => $data[0].'.png',
                    'goods_name' => $data[1],
                    'goods_price' => $data[3],
                    'goods_num' => $data[4],
                    'goods_category' => $data[2],
                    'goods_note' =>$data[5]
                );
            }
        }

        //生成A-Z字符
        for ($i = 65; $i <= 90; $i++) {
            $a[] = chr($i);
        }

        foreach($goods_group as $goods){
            //計算有幾種商品
            $count = StreamingProduct::select('goods_key')
            ->where('page_id', $page_id)
            ->groupBy('goods_key')
            ->get()
            ->count();

            $key_number =  $count % 99;
            $key_count = floor($count / 99);

            foreach($goods as $good_detail){

                $goods_num = $good_detail['goods_num'];
                $description = $good_detail['goods_note'];
                $pic_url = $good_detail['pic_url'];
                $category = $good_detail['goods_category'];
                $category = strtoupper($category);
                if ($category == null)
                    $category = "empty";
                $goods_name = $good_detail['goods_name'];
                $goods_price = $good_detail['goods_price'];
                $goods_key = $a[$key_count] . str_pad($key_number + 1, 2, '0', STR_PAD_LEFT);
                $keyword =  $goods_key.$category ;

                $StreamingProduct = new StreamingProduct();
                $StreamingProduct->page_id = $page_id;
                $StreamingProduct->goods_name = $goods_name;
                $StreamingProduct->goods_price = $goods_price;
                $StreamingProduct->goods_num = $goods_num;
                $StreamingProduct->description =  $description;
                $StreamingProduct->category =  $category;
                $StreamingProduct->pic_url = $pic_url;
                $StreamingProduct->goods_key = $goods_key;
                $StreamingProduct->keyword = $keyword;
                $StreamingProduct->save();
                
            }
        }
        return redirect()->back()->with('success', '新增商品成功！');



    }
    public function ShowPorduct()
    {
        $page = Page::where('as_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;

        $all_product = StreamingProduct::where("page_id", $page_id)->where('is_delete','0')->orderBy('created_at', 'desc')->get()->toArray();
        $name = Auth::user()->name;
        $fb_id = Auth::user()->fb_id;
        $str = "";
        $index = 0;
        $categorys="";
        $all_category ="";
        $diverse = 0;
        $product_id_list ="";
        $goods =[];
        foreach ($all_product as  $V) {
            if($str != $V['goods_key']){
                $str = $V['goods_key'];
                $index = 1;
                $query = StreamingProduct::where("page_id", $page_id)
                ->where('goods_key',$V['goods_key'])
                ->get();
                $diverse =0;
                $product_id_list ="";
                $categorys ="";
                foreach ($query as $value) {
                    $diverse++;
                    $categorys .='('.$value->category.')';
                    $product_id_list .= ','.$value->product_id;
                }

                if($diverse==1){
                    $categorys = $value->category;
                }
            }else{
                $index++;
            }
            $all_category =$categorys;
           //儲存個商品資訊good_information
            $goods[$V['goods_key']][$V['category']] = array(
                'goods_num' => $V['goods_num'],
                'product_id' => $V['product_id'],
                'goods_name' => $V['goods_name'],
                'goods_price' => $V['goods_price'],
                'selling_num' => $V['selling_num'],
                'pre_sale' => $V['pre_sale'],
                'category' => $V['category'],
                'pic_url' => $V['pic_url'],
                'keyword' => $V['keyword'],
                'shop' => $V['shop'],
                'all_category' =>  str_replace("(".$V['category'].")","<b>(".$V['category'].")</b>",$all_category),
                'index' => $index,
                'goods_key' => $V['goods_key'],
                'created_at' => $V['created_at'],
                'diverse' => $diverse,
                'product_id_list' => str_replace( ','.$V['product_id'].',',"",$product_id_list)
            );
        }  
 
        //endtest
        return view('product', ['goods' => $goods,'page_id' =>$page_id,'name' =>$name , 'fb_id' =>$fb_id]); // handle exception
        // return view('product', $array = array('good' => $good)); // handle exception
    }

    public function ProductSalesList(Request $request){

        $page_id = $request->page_id;
        $last_goods_id= -1;
        $counttotal= 0;
        $list= array();
        $query = DB::table('streaming_order')
        ->where("streaming_order.page_id", $page_id)
        ->whereNotNull('streaming_order.order_id')
        ->join('streaming_product','streaming_product.product_id','=','streaming_order.product_id')
        ->select('streaming_order.product_id','streaming_order.goods_num as sell',DB::raw('streaming_order.goods_num * streaming_order.bid_price as total'),'streaming_product.pic_url','streaming_product.goods_name','streaming_product.goods_price','streaming_product.goods_num as stock')
        ->get();

        foreach( $query as $k=>$v){
            if($last_goods_id == $v->product_id){
                $counttotal = $counttotal + $v->total ;
            }else{
                $last_goods_id = $v->product_id;
                $counttotal = $v->total ;
            }
            $list[$v->product_id]=array( 'total' => $counttotal , 'sell' => $v->sell , 'pic_url' => $v->pic_url ,'goods_name' => $v->goods_name , 'goods_price' => $v->goods_price , 'stock'=>$v->stock );
        }

        $keys = array_column($list, 'total');

        array_multisort($keys, SORT_DESC, $list);
        
        return $list; 
        

    }

    public function DeleteProduct(Request $request){
        $page_id = $request->page_id;
        $goodskey= $request->goods_key;
    
        for($i=0;$i<count($goodskey);$i++){
            $goods_key = $goodskey[$i][0];

            // $product_ids =  StreamingProduct::where('page_id', $page_id)
            // ->where('goods_key',$goods_key)
            // ->get();

            // foreach($product_ids as $product_id)
            // {
            //     $delete_product =  AuctionList::where('page_id', $page_id)
            //     ->where('product_id',$product_id)
            //     ->delete();
            // }

            $delete_product =  StreamingProduct::where('page_id', $page_id)
            ->where('goods_key',$goods_key)
            ->update(['is_delete' => 1]);
        }

        return json_encode('success');
    }

    public function EditProduct(Request $request){
        $live_video_id = $request->live_video_id;
        $page_id = $request->page_id;
        $product_id = $request->input("product_id");
        $num = $request->input("product_num");
        $goods_price = $request->input("product_price");
        $category = $request->input("product_category");

        //改商品名
        $goods_name = $request->input("goods_name");
        $goods_key = $request->input("goods_key");
        StreamingProduct::where('page_id', $page_id)
                        ->where('goods_key',$goods_key)
                        ->update(['goods_name' => $goods_name]);

        
        $Streaming_Product = StreamingProduct::where('page_id', $page_id)
        ->where('product_id',$product_id[0])
        ->first();


        $index = 0;
        foreach($product_id as $product_id)
        {
            if($product_id == 'add')
            {
                //重複
                $duplicate = StreamingProduct::where('page_id', $page_id)->where('goods_key',$goods_key)->where('category', $category[$index])->first();

                if($duplicate == null){
                    $StreamingProduct = new StreamingProduct();
                    $StreamingProduct->page_id = $page_id;
                    $StreamingProduct->goods_name = $Streaming_Product->goods_name;
                    $StreamingProduct->goods_price = $goods_price[$index];
                    $StreamingProduct->goods_num = $num[$index];
                    $StreamingProduct->category =  $category[$index];
                    $StreamingProduct->pic_url = $Streaming_Product->pic_url;
                    $StreamingProduct->goods_key = $Streaming_Product->goods_key;
                    $StreamingProduct->keyword = $Streaming_Product->goods_key.$category[$index];
                    $StreamingProduct->save();

                    $max_product_id = StreamingProduct::whereRaw('product_id = (select max(`product_id`) from streaming_product)')->first();
                    $max_product_id = $max_product_id['product_id'];

                    $auction_list = AuctionList::updateOrCreate(
                        ['live_video_id' => $live_video_id, 'product_id' => $max_product_id,'page_id' => $page_id],
                        ['is_active' => 'true']
                    );
                }
            }
            else
            {
                $update = StreamingProduct::where('page_id', $page_id)
                ->where('product_id',$product_id)
                ->update(['goods_num' => $num[$index]]);
            }

            $index++;
        }

        return "true";
    }

    public function EditProductShow(Request $request){
        $page_id = $request->page_id;
        $goods_key= $request->goods_key;

        $product =  StreamingProduct::where('page_id', $page_id)
        ->where('goods_key',$goods_key)
        ->get();

        return $product;
    }
    
    public function collapseProduct(Request $request){
        $product_ids= $request->product_ids;

        $product_id = explode(",",$product_ids);
        $page = Page::where('as_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;

        $product = array();
        foreach( $product_id as $product_id ){
            $query = DB::table('streaming_product')
            ->where('product_id',$product_id)
            ->where('page_id',$page_id)
            ->first();
            
            array_push($product, $query);
        }

        return json_encode($product) ;
    }

    public function ProductOnOf(Request $request){

        $page = Page::where('as_id', Auth::user()->fb_id)->first();
        $page_id = $page->page_id;
    
        $query = StreamingProduct::where('page_id', $page_id)
                                ->where('goods_key', $request->goods_key)
                                ->update(['shop' => $request->on_off]);
        

        return json_encode($query) ;
    }
}
