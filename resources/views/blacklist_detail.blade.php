@extends('layouts.master')

@section('title','棄標黑名單')
@section('heads')
@stop

@section('wrapper')
<div class="wrapper">
@stop
@section('navbar') 
    <!-- Page Content  -->
    <div id="content">
    @stop
    @section('content')
        <div class="container-fluid all_content overflow-auto" id="List_Manage_Detail">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card" id="memberinformation">
                        <div class="media card-body">
                            <img class="d-flex mr-3" src="https://graph.facebook.com/{{$member->fb_id}}/picture?type=normal&access_token={{ $page_token }}">
                            <div class="media-body">
                                <h5 class="mt-0 text-truncate">{{$member->fb_name}}</h5>
                                <small class="text-truncate">
                                    Facebook ID：{{$member->fb_id}}
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="card" id="discardinformation">
                        <div class="media card-body">
                            <div class="media-body">
                                <?php
                                    $blacklist_times = $member->blacklist_times;
                                    $rate = $blacklist_times/$streaming_order_count;
                                    $rate = round($rate, 2);
                                    $rate_percentage = $rate *100;
                                ?>
                                <h6><i class='far mr-3 text-truncate'>&#xf15c;</i>得標次數：{{$streaming_order_count}}</h6>
                                <h6><i class='far mr-2 text-truncate'>&#xf165;</i> 棄標次數：{{$member->blacklist_times}}</h6>
                                <h6><i class='far mr-3 text-truncate'>&#xf1c3;</i>棄標率：{{ $rate_percentage }}%</h6>
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
                                        <th>訂單編號</th>
                                        <th>商品名稱</th>
                                        <th>單價</th>
                                        <th>數量</th>
                                        <th>總金額</th>
                                        <th>時間</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($Order as $order)
                                    <tr>
                                        <td>{{ $order->order_id }}</td>
                                        <td>{{ $order->goods_name }}
                                        @if( $order->category !="empty" )
                                            ， {{ $order->category }} 
                                        @endif
                                        </td>
                                        <td class="currencyField">{{ $order->single_price }}</td>
                                        <td>{{ $order->order_num }}</td>
                                        <td class="currencyField">{{ ((int)$order->order_num)*((int)$order->single_price) }}</td>
                                        <td>{{ $order->created_time }}</td>   
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
    <!-- Cotent end-->
</div>

<script>
    $( document ).ready(function() {
        const driver = new Driver();

        driver.defineSteps([
                {
                    element: '#discardinformation',
                    popover: {
                        title: '粉絲棄標統計',
                        description: '粉絲棄標評價分析',
                        position: 'bottom'
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