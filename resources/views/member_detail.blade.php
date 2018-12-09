@extends('layouts.master')

@section('title','會員資料')

   
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
        <div class="container-fluid mt-3 mb-3 ">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="media">
                        <img class="d-flex mr-3 rounded-circle user_pic" src="https://graph.facebook.com/{{  $member->fb_id }}/picture">
                        <div class="media-body">
                            <h5 class="mt-0">
                                <font class="text-secondary">
                                    <b>{{ $member->fb_name }}</b>
                                </font>
                            </h5>
                        </div>
                    </div>
                    <div class="media mt-3 border-top pt-3">
                        <div class="media-body">
                            <div class="mb-2">
                                <i class="icofont icofont-skull-face h5"></i>
                                <b>棄標次數</b>
                                <font class="text-secondary">{{ $member->blacklist_times }}</font>
                            </div>
                            <div class="mb-2">
                                <i class="icofont icofont-hand-thunder h5"></i>
                                <b>購物次數</b>
                                <font class="text-secondary">{{ $member->checkout_times }}</font>
                            </div>
                            <div class="mb-2">
                                <i class="icofont icofont-bill h5"></i>
                                <b>購物總金額</b>
                                <font class="text-secondary">{{ $member->money_spent }}</font>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-body">
                    <table id="table_member_bid_list_detail" class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>訂單編號</th>
                                <th>訂單總金額</th>
                                <th>訂單產生時間</th>
                                <th>狀態</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $no=1;
                        ?>
                        @foreach($order as $order)
                            <tr id="order_item">
                                <td>{{ $no }}</td>
                                <td>{{ $order->order_id }}</td>
                                <td>{{ $order->all_total }}</td>
                                <td>{{ $order->created_at }}</td>
                                <td>{{ $order->status_cht }}</td>
                                <td><a href="{{ route('seller_order_detail',['order_id' => json_encode($order->order_id)]) }}"><button type="button" class="btn btn-outline-dark">查看詳情</button></a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- main end -->
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
        <!-- <script src="js/jquery-tablepage-1.0.js"></script> -->
        <!-- <script src="js/moment.js"></script> -->
        <!-- DataTable + Bootstrap 4  cdn引用-->
        <script defer src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script defer src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@stop