@extends('layouts.master_mall')

@section('title','Live GO 購物車')
@section('heads')
    <!-- datatable + bootstrap 4  -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
   
@stop

@section('wrapper')
<div class="wrapper">
    <div id="sidebar_page"></div>
@stop
@section('navbar')
    <!-- Page Content  -->
    <div id="content">
        <div id="navbar_page"></div>
        <!--Nav bar end-->
@stop
@section('content')    
@if (session('alert'))
    <div class="alert alert-success">
        {{ session('alert') }}
    </div>
@endif          
        <div id="main" class="row">
            <div class="col-md-12">
            @if(count($shopping_cart)==0)

                <table class="table table-striped " id="table_cart">
                    <thead>
                            <tr>
                                <th></th>
                                <th>商品圖片</th>
                                <th>商品名稱</th>
                                <th>商品價格</th>
                                <th>商品數量</th>
                                <th>總金額</th>
                                <th>得標時間</th>
                            </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="7">無資料</td>
                        </tr>
                    </tbody>
                </table>


            @else
            <?php $item=1;?>
            @foreach($shopping_cart as $page => $collection)
                {{$page}}<hr>
                <form action="{{ route('checkout_form') }}" method="POST">       
                            {{ csrf_field() }}
                <table class="table table-striped tablecart" id="table_cart">  
                <thead>
                    <tr>
                        <tr>
                            <th></th>
                            <th>商品圖片</th>
                            <th>商品名稱</th>
                            <th>商品價格</th>
                            <th>商品數量</th>
                            <th>總金額</th>
                        </tr>
                </thead>
                <tbody>
                            @foreach($collection as $cart)
                            <?php $item++;?>
                                <tr>
                                <td>
                                    <div class="custom-control custom-checkbox ml-4">
                                        <input type="checkbox" class="custom-control-input" id="{{$item}}" name="goods[]" value="{{$cart->page_name}},{{$cart->fb_id}},{{$cart->name}},{{$cart->goods_name}},{{$cart->goods_price}},{{$cart->goods_num}},{{$cart->total_price}},{{$cart->page_id}},{{$cart->uid}},{{$cart->pic_path}}">
                                        <label class="custom-control-label" for="{{$item}}"></label>
                                    </div>
                                </td>
                                <td>
                                    <img src="{{$cart->pic_path}}"
                                    />
                                </td>
                                <td>{{$cart->goods_name}}</td>
                                <td>{{$cart->goods_price}}</td>
                                <td>{{$cart->goods_num}}</td>
                                <td>{{$cart->total_price}}</td>
                                </tr>
                            @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7">
                        <input type="submit" value="結帳" class="btn btn-secondary">
                        </form>
                        </td>
                    </tr>
                </tfoot>
                </table>
            @endforeach                          
            @endif
            </div>
        </div>
    </div>
    <!-- Cotent end-->
</div>
@stop

@section('footer')
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
        crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
        crossorigin="anonymous"></script>
    <!-- My JS -->
    <script src="js/Live_go.js"></script>
    <!-- DataTable + Bootstrap 4  cdn引用-->
    <script defer src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@stop