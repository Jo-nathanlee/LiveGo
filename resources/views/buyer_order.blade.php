@extends('layouts.master_mall')

@section('title','我的訂單')
@section('heads')

@stop

@section('wrapper')
<div class="wrapper">
@stop   
    @section('navbar')
    <div id="content" style="background-color: #F5F5F5	">
        <div class="container">
            <div class="card rounded-0">
                <div class="card-body p-0">
                    @stop
                    @section('content')  
                    <div class="row justify-content-center mb-4" >
                        <div class="col-md-10">
                            <ul class="nav nav-tabs" id="buyer_order_nav">
                                <li class="nav-item">
                                    <a class="nav-link active" id="buyer_order" href="{{ route('buyer_order',['page_id' => $page_id]) }}">全部</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-muted" id="buyer_order_unpaid" href="{{ route('buyer_order_unpaid',['page_id' => $page_id]) }}">未付款
                                        <sub class="text-danger ml-1">{{$countUnpaidOrder}}</sub>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-muted" id="buyer_order_undelivered" href="{{ route('buyer_order_undelivered',['page_id' => $page_id]) }}">等待出貨
                                        <sub class="text-danger ml-1">{{$countUndeliveredOrder}}</sub>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-muted" id="buyer_order_delivered" href="{{ route('buyer_order_delivered',['page_id' => $page_id]) }}">運送中
                                        <sub class="text-danger ml-1">{{$countDeliveredOrder}}</sub>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-muted" id="buyer_order_finished" href="{{ route('buyer_order_finished',['page_id' => $page_id]) }}">已完成
                                        <sub class="text-danger ml-1">{{$countFinishedOrder}}</sub>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-muted" id="buyer_order_canceled" href="{{ route('buyer_order_canceled',['page_id' => $page_id]) }}">已取消
                                        <sub class="text-danger ml-1">{{$countCanceledOrder}}</sub>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row justify-content-center" style="min-height: 100vh ; max-width:100%">
                        <div class="col-md-10">
                            <table class="table table-hover " >
                                <thead>
                                    <tr>
                                        <th>粉絲專頁名稱</th>
                                        <th>訂單編號</th>
                                        <th>消費總金額</th>
                                        <th>狀態</th>
                                        <th>訂單成立時間</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order as $order_detail)
                                    <tr>
                                        <th>{{$order_detail->page_name}}</th>
                                        <td style="word-break: break-all;">{{$order_detail->order_id}}</td>
                                        <td class="currencyField">{{$order_detail->all_total}}</td>
                                        <td>{{$order_detail->order_status}}<br>
                                            {{$order_detail->message}}
                                        </td>
                                        <td>{{$order_detail->created_at}}</td>
                                        <td><a href="{{ route('buyer_order_detail',['order_id' => $order_detail->order_id,'page_id'=>$page_id]) }}"><button  type="button" class="btn btn-outline-dark">查看詳情</button></a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  

        <!-- main end -->
    </div>
    <!-- Cotent end-->
</div>
<!-- jQuery CDN - Slim version (=without AJAX) -->
@stop
@section('footer')

@stop