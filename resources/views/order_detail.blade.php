@extends('layouts.master')

@section('title','直播')

@section('head_extension')

@stop

@section('wrapper')
<div class="wrapper">
@stop
@section('navbar')
    <div id="content">
@stop
        @section('content')
            <div class="row " style="position: relative">
                <div class="container mt-4 mb-4">
                    <div id="order_detail_S1" class="stepwizard mt-4 container-fluid S1 mb-4">
                        <div class="S1_R1">
                            <span style="font-size: 1.5em;">訂單編號：&nbsp;{{ $order_detail->order_id }}</span>
                        </div>
                    </div>
                    <div class="progressbar-wrapper">
                        <ul class="progressbar">
                            <li class=" {{ $order_detail->orderstatus_id >= 10 && $order_detail->orderstatus_id < 15? 'active' : '' }} ">待確定</li>
                            <li class=" {{ $order_detail->orderstatus_id >= 11 && $order_detail->orderstatus_id < 15? 'active' : '' }} ">待付款</li>
                            <li class=" {{ $order_detail->orderstatus_id >= 12 && $order_detail->orderstatus_id < 15? 'active' : '' }} ">待出貨</li>
                            <li class=" {{ $order_detail->orderstatus_id >= 13 && $order_detail->orderstatus_id < 15? 'active' : '' }} ">運送中</li>
                            <li class=" {{ $order_detail->orderstatus_id >= 14 && $order_detail->orderstatus_id < 15? 'active' : '' }} ">已完成</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-12 " style=" background-color: #c4c8cc26;">
                    <div class="card-deck p-4 ">
                        <div class="card rounded-lg" style=" border-color: #6c757d2d;border-width: medium;">
                            <div class="card-body">
                                <h3 class="card-title text-muted text-center">訂單資訊 {{ $order_detail->orderstatus_id}}</h3>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    <hr style=" border-color: #6c757d2d;border-width: medium;">
                                </h6>
                                <p class="card-text font-weight-bold">訂單狀態 <span
                                        class="ml-2 badge badge-pill badge-danger" style="opacity: 0.7">{{ $order_detail->order_status }}</span></p>
                                <p class="card-text font-weight-bold">訂購人&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="ml-2 badge badge-pill  badge-secondary" style="opacity: 0.6">
                                        <img src="https://graph.facebook.com/{{ $order_detail->ps_id}}/picture?type=normal&access_token={{$token}}"
                                            class="rounded-circle mr-1" style="height:1.1rem">{{ $order_detail->fb_name }}</span></p>
                                <p class="card-text font-weight-bold">訂購日期 <span
                                        class="ml-2 badge badge-pill  badge-secondary" style="opacity: 0.6">{{ $order_detail->created_at->format('Y-m-d H:i') }}</span></p>
                            </div>
                        </div>
                        <div class="card rounded-lg" style=" border-color: #6c757d2d;border-width: medium;">
                            <div class="card-body">
                                <h3 class="card-title text-muted text-center">付款資訊</h3>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    <hr style=" border-color: #6c757d2d;border-width: medium;">
                                </h6>
                                <p class="card-text font-weight-bold">付款方式 <span
                                        class="ml-2 badge badge-pill badge-secondary" style="opacity: 0.6">{{ $order_detail->pay_cht }}</span></p>
                                <p class="card-text font-weight-bold">繳款金額<span
                                        class="ml-2 badge badge-pill  badge-secondary currencyField"  style="opacity: 0.6">{{ $total_price }}</span></p>
                                <p class="card-text font-weight-bold">付款狀態 <span
                                        class="ml-2 badge badge-pill  badge-success" style="opacity: 0.6">{{ $order_detail->order_status }}</span></p>
                            </div>
                        </div>
                        <div class="card rounded-lg" style=" border-color: #6c757d2d;border-width: medium;">
                            <div class="card-body ">
                                <h3 class="card-title text-muted text-center">收件資訊</h3>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    <hr style=" border-color: #6c757d2d;border-width: medium;">
                                </h6>
                                <p class="card-text font-weight-bold">付款方式 <span
                                        class="ml-2 badge badge-pill badge-secondary" style="opacity: 0.6">{{ $order_detail->pay_cht }}</span></p>
                                <p class="card-text font-weight-bold">連絡電話 <span
                                        class="ml-2 badge badge-pill  badge-secondary" style="opacity: 0.6">{{ $order_detail->cellphone }}</span></p>
                                <p class="card-text font-weight-bold">寄件地址 
                                    <span class="ml-2 badge badge-pill over-text badge-secondary " style="opacity: 0.6">{{ $order_detail->address }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="card rounded-lg" style=" border-color: #6c757d2d;border-width: medium;">
                            <div class="card-body">
                                <h3 class="card-title text-muted text-center">出貨資訊</h3>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    <hr style=" border-color: #6c757d2d;border-width: medium;">
                                </h6>
                                <p class="card-text font-weight-bold">訂單狀態 <span
                                        class="ml-2 badge badge-pill badge-danger" style="opacity: 0.7">{{ $order_detail->order_status }}</span>
                                </p>
                                <p class="card-text font-weight-bold">物流公司 
                                    <span class="ml-2 badge badge-pill  badge-secondary" style="opacity: 0.6">xx黑貓</span>
                                </p>
                                <p class="card-text font-weight-bold">出貨狀態 
                                    <span class="ml-2 badge badge-pill  badge-secondary" style="opacity: 0.6">xx貨運宅配</span>
                                </p>
                                <p class="card-text font-weight-bold">出貨日期 
                                    <span class="ml-2 badge badge-pill badge-secondary" style="opacity: 0.6">xx2019/10/25 20:50</span>
                                </p>
                                        
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row pt-4 pb-4" style=" background-color: #c4c8cc26;">
                <div class="col-md-8" style="max-height: 50vh;overflow-y: auto;overflow-x: hidden">
                    <table class="table" id="member_order_detail"  >
                        <thead>
                            <th>商品名稱</th>
                            <th>規格</th>
                            <th>售價</th>
                            <th>數量</th>
                            <th>小計</th>
                        </thead>
                        <tbody id="order_table">
                            @foreach($orders as $order)
                                <tr>
                                    <td><img class="product mr-2" src="{{$order->pic_url}}" >{{ $order->goods_name }}</td>
                                    <td>{{ $order->category}}</td>
                                    <td>{{ $order->bid_price }}</td>
                                    <td>{{ $order->bid_num }}</td>
                                    <td>{{ $order->bid_price * $order->bid_num }}</td>
                                </tr>
                            @endforeach
                            @foreach($prize as $prize)
                                <tr>
                                    <td><img class="product mr-2" src="{{$prize->image_url}}" >{{ $prize->product_name }}</td>
                                    <td></td>
                                    <td>贈品</td>
                                    <td>1</td>
                                    <td>贈品</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">
                    <div class="card"  style=" border-color: #6c757d2d;border-width: medium;">
                        <div class="card-body">
                            <h3 class="card-title text-muted text-center" >訂單整理</h3>
                            <ul class="list-group" id="order_arrange">
                                <li class="list-group-item" style="background-color: #c4c8cc26;">共{{ $count }}樣商品</li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">商品總計 <span class="currencyField">{{ $order_detail->goods_total }}</span></li>
                                <li class="list-group-item d-flex justify-content-between align-items-center"> <span>運費 <span class="text-muted">(店到店)</span></span>   <span class="currencyField">{{ $order_detail->freight }}</span></li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">訂單金額 <span class="currencyField">{{ $total_price }}</span></li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">應付金額 <span class="currencyField">{{ $total_price }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @stop 
@section('footer')    
<script>
        $(document).ready(function () {
            $('#member_order_detail').DataTable({
                "paging": false,
                "searching": false,
                "info": false,
            });
        });
</script>
@stop

