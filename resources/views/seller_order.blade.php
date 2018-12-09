@extends('layouts.master')

@section('title','我的訂單')

   
@section('heads')
    <!-- 我新增的 CSS -->
    <link rel="stylesheet" href="css/list_mgnt.css">
     <!-- datatable + bootstrap 4  -->
     <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script>
        $(function () {
            $('#order .row .col-md-12 .nav a').on('click', function () {
                $('.nav a').removeClass('selected');
                $(this).addClass('selected');
            });
            @if($click=='canceled')
                $('#all').removeClass('selected');
                $('#canceled').addClass('selected');
            @endif
            @if($click=='finished')
                $('#all').removeClass('selected');
                $('#finished').addClass('selected');
            @endif
            @if($click=='delivered')
                $('#all').removeClass('selected');
                $('#delivered').addClass('selected');
            @endif
            @if($click=='undelivered')
                $('#all').removeClass('selected');
                $('#undelivered').addClass('selected');
            @endif
            @if($click=='unpaid')
                $('#all').removeClass('selected');
                $('#unpaid').addClass('selected');
            @endif
        });
    </script>
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
<script>
    message_danger();
</script>
@endif
            <div id="order" class="container-fluid main">
                <div class="row">
                    <div class="col-md-12">
                        <!-- 狀態列 -->
                        <div id="order_st_nav " class="container-fluid st_nav">
                            <div class="row">
                                <div class="col-md-12">
                                    <nav class="nav nav-tabs">
                                        <a class="nav-link selected" id="all"  href="{{ route('seller_order') }}">全部</a>
                                        <a class="nav-link tip" id="unpaid" href="{{ route('seller_order_unpaid') }}">
                                            <span data-tooltip="{{$countUnpaidOrder}}筆新訂單"> 未付款
                                                <sub>{{$countUnpaidOrder}}</sub>
                                        </a>
                                        <a class="nav-link tip" id="undelivered"  href="{{ route('seller_order_undelivered') }}">
                                            <span data-tooltip="{{$countUndeliveredOrder}}筆新訂單">等待出貨
                                                <sub>{{$countUndeliveredOrder}}</sub>
                                        </a>
                                        <a class="nav-link tip" id="delivered" href="{{ route('seller_order_delivered') }}">
                                            <span data-tooltip="{{$countDeliveredOrder}}筆新訂單">運送中
                                                <sub>{{$countDeliveredOrder}}</sub>
                                        </a>
                                        <a class="nav-link tip" id="finished"  href="{{ route('seller_order_finished') }}">
                                            <span data-tooltip="{{$countFinishedOrder}}筆新訂單">已完成
                                                <sub>{{$countFinishedOrder}}</sub>
                                        </a>
                                        <a class="nav-link tip" id="canceled" href="{{ route('seller_order_canceled') }}">
                                            <span data-tooltip="{{$countCanceledOrder}}筆新訂單">已取消
                                                <sub>{{$countCanceledOrder}}</sub>
                                        </a>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <!-- 手機板狀態列 -->
                        <div id="order_st_nav_md" class="container-fluid st_nav_md">
                            <div class="row">
                                <div class="col-md-12">
                                    <a class="btn-block btn st_nav_md_picker" data-toggle="collapse" data-target="#order_st_nav_md_list" aria-expanded="false"
                                        aria-controls="order_st_nav_md_list">訂單狀態</a>
                                    <div id="order_st_nav_md_list" class="collapse multi-collapse st_nav_md_list">
                                        <nav class="nav flex-column">
                                            <a class="btn btn-block btn-light"  href="{{ route('seller_order') }}">全部</a>
                                            <a class="btn btn-block btn-light"  href="{{ route('seller_order_unpaid') }}">未付款
                                                <sub>{{$countUnpaidOrder}}</sub>
                                            </a>
                                            <a class="btn btn-block btn-light"  href="{{ route('seller_order_undelivered') }}">等待出貨
                                                <sub>{{$countUndeliveredOrder}}</sub>
                                            </a>
                                            <a class="btn btn-block btn-light"  href="{{ route('seller_order_delivered') }}">運送中
                                                <sub>{{$countDeliveredOrder}}</sub>
                                            </a>
                                            <a class="btn btn-block btn-light"  href="{{ route('seller_order_finished') }}">已完成 </a>
                                            <a class="btn btn-block btn-light"  href="{{ route('seller_order_canceled') }}">已取消
                                                <sub>{{$countCanceledOrder}}</sub>
                                            </a>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 手機板狀態列end -->
                        <!-- 狀態列end -->

                    </div>
                    <!-- 訂單列表 -->
                    <div id="order_list" class="container-fluid">
                        <div class="row">
                            <div class="col-md-12" id="table_div">
                            @if(count($order)==0)
                                <table id="table_nocontroler" class="table">
                                    <thead>
                                        <tr>
                                            <th>得標者圖片</th>
                                            <th>得標者姓名</th>
                                            <th>訂單編號</th>
                                            <th>總金額</th>
                                            <th>狀態</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td align="center" colspan="6">無資料</td>
                                        </tr>
                                    </tbody>
                                </table>
                            @else
                                <table id="table_nocontroler" class="table">
                                    <thead>
                                        <tr>
                                            <th>得標者圖片</th>
                                            <th>得標者姓名</th>
                                            <th>訂單編號</th>
                                            <th>總金額</th>
                                            <th>狀態</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                @foreach($order as $order_detail)
                                        <tr id="order_item">
                                            <td scope="row">
                                                <img id="order_img" src="https://graph.facebook.com/{{ $order_detail->buyer_fbid }}/picture" class="img-fluid img" alt="Responsive image">
                                            </td>
                                            <td>{{$order_detail->buyer_fbname}}</td>
                                            <td>{{$order_detail->order_id}}</td>
                                            <td>{{$order_detail->all_total}}</td>
                                            <td>{{$order_detail->status_cht}}</td>
                                            <td><a href="{{ route('seller_order_detail',['order_id' => json_encode($order_detail->order_id)]) }}"><button  type="button" class="btn btn-outline-dark">查看詳情</button></a></td>
                                        </tr>
                                @endforeach
                                    </tbody>
                                </table>
                               
                                    
                            <!-- 頁碼 -->
                            <span id="list_table_page" class="list_table_page"></span>   
                            <!-- 頁碼end -->
                            <!-- <center><a class="btn btn-secondary"  href="{{ route('download',['pdf_order' => json_encode($order)]) }}">PDF下載</a></center>                   -->
                            @endif
                            </div>
                        </div>
                    </div>
                    <!-- 訂單列表end -->
                </div>
            </div>
            <!-- main end -->
        </div>
        <!-- Cotent end-->
    </div>
    <!-- jQuery CDN - Slim version (=without AJAX) -->
@stop
@section('footer')
    <!--   -->
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