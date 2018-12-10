@extends('layouts.master')

@section('title','我的訂單')

   
@section('heads')
    <!-- 我新增的 CSS -->
    <link rel="stylesheet" href="css/list_mgnt.css">
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
    <div id="content" class="Microsoft">
        <div id="navbar_page"></div>
        <!--Nav bar end-->
@stop
@section('content')
@if (session('alert'))
<script>
    message_danger();
</script>
@endif
        <div class="container-fluid mt-3 mb-3 ">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="media">
                        <img class="d-flex mr-3 rounded-circle user_pic" src="https://graph.facebook.com/{{ $order_detail->buyer_fbid }}/picture">
                        <div class="media-body">
                            <h5 class="mt-0">
                                <font class="text-secondary"><b>{{ $order_detail->buyer_fbname }}</b></font>
                            </h5>
                            <font class="text-secondary">{{ $order_detail->buyer_fbid }}</font>
                        </div>
                    </div>
                    <div class="media mt-3 border-top pt-3">
                        <div class="media-body">
                            <h5 class="mt-0">
                                <i class="icofont icofont-numbered"></i> 
                                <b>訂單編號</b>
                                <font id="order_id" class="text-secondary">{{ $order_detail->order_id }}</font>
                                <font class="float-right mr-2">訂單狀態：
                                <font id="order_status" class="float-right mr-2"> {{ $order_detail->status_cht }}</font>
                                </font>
                            </h5>
                            <i class="icofont icofont-map h5"></i> 
                            <b>買家電話/收件地址</b>
                            <font class="text-secondary">{{ $order_detail->buyer_name }}   {{ $order_detail->buyer_phone }}<br>
                            {{ $order_detail->buyer_address }}</font>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-body">
                    <table id="table_bid_list_detail" class="table">
                        <thead>
                            <tr>
                                <th>編號</th>
                                <th>商品圖片</th>
                                <th>商品名稱</th>
                                <th>單價</th>
                                <th>數量</th>
                                <th>總金額</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no=1;
                            ?>
                            @foreach($order_goods as $goods)
                            <tr id="order_item">
                                <td>{{ $no }}</td>
                                <!-- 流水號 -->
                                <td scope="row">
                                    <img id="order_img" src="{{ $goods->pic_path }}" class="img-fluid img" alt="Responsive image">
                                </td>
                                <td>{{ $goods->goods_name }}</td>
                                <td>{{ $goods->goods_price }}</td>
                                <td>{{ $goods->goods_num }}</td>
                                <td>{{ $goods->total_price }}</td>
                            </tr>
                            <?php
                            $no+=1;
                            ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- main end -->
            </div>
        </div>
        <div class="container-fluid mt-3 mb-3 ">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="media " data-toggle="collapse" href="#pirce_detail" role="button" aria-expanded="false" aria-controls="pirce_detail">
                        <i class="icofont icofont-bill d-flex mr-3 text-success" style="font-size: 40px"></i>
                        <div class="align-self-center">
                            <b>總金額 : </b> {{ $order_detail->all_total }}</div>
                        <div class="media-body text-secondary">
                            <small class="float-right mt-2">查看詳情
                                <i class="icofont icofont-rounded-expand"></i>
                            </small>
                        </div>
                    </div>
                    <div class="collapse mt-3" id="pirce_detail">
                        <div class=" p-3  border-top">
                            <div class="media text-secondary">
                                <i class="icofont icofont-truck-loaded d-flex mr-3" style="font-size: 20px"></i>
                                <div class="align-self-center">
                                    <small>
                                        <b>訂單金額 : </b> {{ $order_detail->goods_total }}</div>
                                </small>
                            </div>
                        </div>
                        <div class="p-3  border-top">
                            <div class="media mt-3 text-secondary">
                                <i class="icofont icofont-truck-loaded d-flex mr-3" style="font-size: 20px"></i>
                                <div class="align-self-center">
                                    <small>
                                        <b>運費 : </b>{{ $order_detail->freight }}</div>
                                </small>
                            </div>
                        </div>
                        <div class=" p-3  border-top">
                            <div class="media mt-3 text-secondary">
                                <i class="icofont icofont-card d-flex mr-3" style="font-size: 20px"></i>
                                <div class="align-self-center">
                                    <small>
                                        <b>優惠折扣 : </b> 0</div>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cotent end-->
    </div>
@stop
@section('footer')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
            crossorigin="anonymous"></script>
        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
            crossorigin="anonymous"></script>
        <!-- My JS -->
        <script src="js/Live_go.js"></script>
        <!-- 我新增的JS -->
        <script src="js/list_mgnt.js"></script>
        <!-- DataTable + Bootstrap 4  cdn引用-->
        <script defer src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script defer src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@stop