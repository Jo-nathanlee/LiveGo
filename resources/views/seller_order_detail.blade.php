@extends('layouts.master')

@section('title','我的訂單')

   
@section('heads')

@stop


@section('wrapper')
<div class="wrapper">
@stop
@section('navbar')
    <!-- Page Content  -->
    <div id="content" class="Microsoft">
        @stop
        @section('content')
        <div class="container-fluid all_content overflow-auto" id="List_Manage_Detail">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card" id="memberinformation">
                        <div class="media card-body">
                            <img class="d-flex mr-3" src="https://graph.facebook.com/{{ $order_detail->buyer_fbid }}/picture">
                            <div class="media-body">
                                <h5 class="mt-0 text-truncate">{{ $order_detail->buyer_name }}</h5>
                                <small class="text-truncate">
                                    <i class='fas mr-2'>&#xf3c5;</i>買家電話/收件地址：{{ $order_detail->buyer_phone }}/{{ $order_detail->buyer_address }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="card" id="liststatue">
                        <div class="media card-body">
                            <div class="media-body">
                                <h6 class="text-truncate"><i class='fas mr-3'>&#xf15c;</i>訂單編號：{{ $order_detail->order_id }}</h6>
                                <h6 class="text-truncate"><i class='fas mr-2'>&#xf0d1;</i>訂單狀態：<span id="List_state" class="badge badge-pill">{{ $order_detail->order_status }}<br>{{$order_detail->message}}</span></h6>
                            </div>
                            <div class="m-auto">
                            @if( $order_detail->order_status == '等待出貨中')
                                <input type="button" class="btn btn-secondary btn-sm" value="列印超商繳款單" onclick="window.open('{{ route("PrintLogisticsPaymentSlip",["order_id"=>$order_detail->order_id ]) }}')"><br><br>
                            @endif
                                <button type="button" class="btn btn-secondary btn-sm" onclick="Edit_List_State('{{ $order_detail->order_id }}')">更改訂單狀態</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
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
                                    @foreach($streaming_products as $streaming_products)
                                    <tr>
                                        <td>
                                            <img src="{{ $streaming_products->pic_url }}">
                                        </td>
                                        <td>{{ $streaming_products->goods_name }}
                                            @if($streaming_products->category!="empty" && $streaming_products->category!=null)
                                                ，{{ $streaming_products->category }}
                                            @endif
                                        </td>
                                        <td class="currencyField">{{ $streaming_products->single_price }}</td>
                                        <td>{{ $streaming_products->order_num }}</td>
                                        <td class="currencyField">{{ ((int)$streaming_products->single_price)*((int)$streaming_products->order_num) }}</td>
                                    </tr>
                                    @endforeach
                                    @foreach($shop_products as $shop_products)
                                    <tr>
                                        <td>
                                            <img src="{{ $shop_products->pic_url }}">
                                        </td>
                                        <td>{{ $shop_products->goods_name }}
                                            @if($shop_products->category!="empty" && $shop_products->category!=null)
                                                ，{{ $shop_products->category }}
                                            @endif
                                        </td>
                                        <td class="currencyField">{{ $shop_products->goods_price }}</td>
                                        <td>{{ $shop_products->order_num }}</td>
                                        <td class="currencyField">{{ $shop_products->total_price }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="media card-body" data-toggle="collapse" data-target="#collapseDetail" aria-expanded="false" aria-controls="collapseDetail">
                            <div class="media-body">
                                <h5>
                                    <i class='far'>&#xf3d1;</i>
                                    <small class=" text-truncate">總金額： <span class="currencyField">{{ $order_detail->all_total }} </span></small>
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
                                        <small class="text-truncate">訂單總金額： <span class="currencyField">{{ $order_detail->goods_total }}</span> </small>
                                    </h6>
                                </div>
                            </div>
                            <div class="media card-body">
                                <div class="media-body">
                                    <h6>
                                        <i class='fas mr-2'>&#xf4df;</i>
                                        <small class="text-truncate">運費： <span class="currencyField">{{ $order_detail->freight }}</span> </small>
                                    </h6>
                                </div>
                            </div>
                            <div class="media card-body">
                                <div class="media-body">
                                    <h6>
                                        <i class='fas mr-2'>&#xf53c;</i>
                                        <small>折扣優惠： <span class="currencyField">0</span></small>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cotent end-->
    </div>
</div>
<script>
    $( document ).ready(function() {
        const driver = new Driver();

        driver.defineSteps([
                {
                    element: '#liststatue',
                    popover: {
                        title: '粉絲訂單狀態',
                        description: '顯示粉絲該筆訂單目前狀態',
                        position: 'bottom'
                    }
                },
                {
                    element: '.btn.btn-secondary.btn-sm',
                    popover: {
                        title: '點選更改訂單狀態',
                        description: '更改該筆訂單目前狀態，如訂單完成請更改為完成',
                        position: 'left-bottom'
                    }
                },
                {
                    element: '.dataTables_length',
                    popover: {
                        title: '選取資料筆數',
                        description: '調整顯示訂單筆數',
                        position: 'bottom'
                    }
                },
                {
                    element: '#DataTables_Table_0_filter',
                    popover: {
                        title: '快速尋找訂單',
                        description: '只需輸入關鍵字即可！',
                        position: 'bottom'
                    }
                },
                {
                    element: '#DataTables_Table_0',
                    popover: {
                        title: '訂單資訊',
                        description: '查看訂單詳細資訊',
                        position: 'top'
                    }
                }
            ]);

        document.querySelector('#help_me').addEventListener('click', function (e) {
            e.preventDefault();
        e.stopPropagation();
        driver.start();
        });
    });

   
</script>
@stop
@section('footer')

@stop