@extends('layouts.master_mall')

@section('title','我的訂單')

   
@section('heads')
@stop

@section('wrapper')
<div class="wrapper">
@stop
@section('navbar')
    <!-- Page Content  -->
        <div id="content" style="background-color: #F5F5F5	">
            <div class="container">
                <div class="card rounded-0">
                    <div class="card-body p-0">
                    @stop
                        @section('content')
                        <div class="row justify-content-center" style="min-height: 100vh ">
                            <div class="col-md-10">
                                <div class="card">
                                    <div class="media card-body">
                                        <img class="d-flex mr-3 rounded" style="width: 4.5rem;height: 4.5rem;" src="https://graph.facebook.com/{{ $order_detail->buyer_fbid }}/picture">
                                        <div class="media-body">
                                            <h5 class="mt-0 text-truncate">{{ $order_detail->buyer_name }}</h5>
                                            <small class="text-truncate">
                                                <i class='fas mr-2'>&#xf3c5;</i>聯絡電話 / 寄件地址：{{ $order_detail->buyer_phone }} / {{ $order_detail->buyer_address }}</small>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="card">
                                    <div class="media card-body">
                                        <div class="media-body">
                                            <h6>
                                                <i class='fas mr-2'>&#xf0d1;</i>訂單狀態：
                                                <span id="List_statue" class="badge badge-pill">訂單完成</span>
                                            </h6>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>商品圖片</th>
                                                    <th>商品名稱</th>
                                                    <th>單價</th>
                                                    <th>數量</th>
                                                    <th>總金額</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($StreamingProducts as $goods)
                                                <tr>
                                                    <td>
                                                        <img src="{{ $goods->pic_url }}">
                                                    </td>
                                                    <td>{{ $goods->goods_name }} 
                                                        @if( $goods->category !="empty" )
                                                            ， {{ $goods->category }} 
                                                        @endif
                                                    </td>
                                                    <td class="currencyField">{{ $goods->single_price }}</td>
                                                    <td>{{ $goods->order_num }}</td>
                                                    <td class="currencyField">{{ ((int)$goods->order_num)*((int)$goods->single_price) }}</td>
                                                </tr>
                                                @endforeach
                                                @foreach($ShopProducts as $goods)
                                                <tr>
                                                    <td>
                                                        <img src="{{ $goods->pic_url }}">
                                                    </td>
                                                    <td>{{ $goods->goods_name }} 
                                                        @if( $goods->category !="empty" )
                                                            ， {{ $goods->category }} 
                                                        @endif
                                                    </td>
                                                    <td class="currencyField">{{ $goods->goods_price }}</td>
                                                    <td>{{ $goods->order_num }}</td>
                                                    <td class="currencyField">{{  $goods->total_price }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="media card-body" data-toggle="collapse" data-target="#collapseDetail" aria-expanded="false" aria-controls="collapseDetail">
                                        <div class="media-body">
                                            <h5>
                                                <i class='far'>&#xf3d1;</i>
                                                <small class="text-truncate">總金額： <span class="currencyField">{{ $order_detail->all_total }}</span></small>
                                            </h5>
                                        </div>
                                        <div class="m-auto">
                                            <small class="text-black-50"> 點選查看詳情
                                                <i class='fas'>&#xf0dc;</i>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="collapse text-black-50" id="collapseDetail">
                                        <div class="media card-body">
                                            <div class="media-body">
                                                <h6>
                                                    <i class='fas mr-2'>&#xf0c5;</i>
                                                    <small class="text-truncate">訂單總金額： <span class="currencyField">{{ $order_detail->goods_total }}</span></small>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="media card-body">
                                            <div class="media-body">
                                                <h6>
                                                    <i class='fas mr-2'>&#xf4df;</i>
                                                    <small class="text-truncate">運費： <span class="currencyField">{{ $order_detail->freight }}</span></small>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="media card-body">
                                            <div class="media-body">
                                                <h6>
                                                    <i class='fas mr-2'>&#xf53c;</i>
                                                    <small class="text-truncate">折扣優惠： <span class="currencyField">0</span></small>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

@stop