@extends('layouts.master')

@section('title','會員詳細資料')

@section('head_extension')


@stop

@section('wrapper')
<div class="wrapper">
@stop
@section('navbar')
    <div id="content">
@stop
        @section('content')


        <div id="order_detail_S1" class="stepwizard mt-4 container-fluid S1">
                <div class="S1_L ">
                    <img src="https://graph.facebook.com/{{$member->ps_id}}/picture?type=large&access_token={{$page_token}}" alt="photo">
                </div>
                <div class="col-10 S1_R">
                    <div class="S1_R1">
                        <span class="R1_name">{{$member->fb_name}}</span>
                        <div class="mb_lev lv_VIP"><i class="fas fa-thumbs-up"></i>&nbsp;{{$member->type_cht}}</div>
                        <div class="R1_time">訂單取消次數&nbsp;<span>{{$member->cancel_times}}</span>&nbsp;次</div>
                    </div>
                    <div class="S1_R2">
                        <i class="fab fa-facebook-square"></i><span>{{$member->fb_name}}</span>
                    </div>
                    <div class="S1_R3">
                        <div class="R3_time">於&nbsp;<u>{{$member->created_at}}</u>&nbsp;加入</div>
                        <div class="R3_d">
                            總消費金額$&nbsp;&nbsp;<span>{{$member->money_spent}}</span>&emsp;
                            @if( $member->checkout_times > 0)
                                每次平均消費金額$&nbsp;&nbsp;<span>{{ceil($member->money_spent / $member->checkout_times)}}</span>&emsp;
                            @else
                                每次平均消費金額$&nbsp;&nbsp;<span>0</span>&emsp;
                            @endif
                            {{-- 當日最高排名No.&nbsp;&nbsp;<span>1</span> --}}
                        </div>
                    </div>
                </div>
            </div>


        <div class="row " style="position: relative;">
            <div class="col-md-12">
                
                    <div class="card-body">
                        <table class="table " id="order_detail" >
                            <thead>
                                <tr>
                                    <th>訂單日期</th>
                                    <th>訂單編號</th>
                                    <th>訂單金額</th>
                                    <th>訂單狀態</th>
                                    <th>訂單詳情</th>
                                </tr>
                            </thead>

                            <tbody >
                            @foreach ($order as $order)
                                <tr>
                                    <th>{{$order->created_at}}</th>
                                    <td>{{$order->order_id}}</td>
                                    <td>{{$order->goods_total}}</td>
                                    <td>{{$order->order_status}}</td>
                                    <td><a href="{{ route('order_detail', ['order_id' => $order->order_id]) }}"><i class="fas fa-info-circle"></i></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

               
            </div>
            <!-- <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            共計 1 樣商品
                        </div>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                商品總計
                                <span class="currencyField">124</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                運費 ( 店到店 )
                                <span class="currencyField">222</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                訂單金額
                                <span class="currencyField">333</span>
                            </li>
                        </ul>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            應付金額  <span class="currencyField">333</span>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
        @stop 
@section('footer')    


<script>
        $('#order_detail').DataTable({
            "pagingType": "full_numbers",
            "oLanguage": {
                "sInfo": "共 _TOTAL_ 筆資料",
                "oPaginate": {
                    "sFirst":" ",
                    "sPrevious": " ",
                    "sNext":" ",
                    "sLast":" "
                }
            }
        });
    </script>
@stop

