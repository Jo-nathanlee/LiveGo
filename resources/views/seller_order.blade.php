@extends('layouts.master')

@section('title','我的訂單')

   
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
        <div class="container-fluid all_content overflow-auto" id="List_Manage">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link text-dark font-weight-bold" id="all"  href="{{ route('seller_order') }}">全部</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black-50" id="unpaid" href="{{ route('seller_order_unpaid') }}">未付款<sub class="text-danger ml-1">{{$countUnpaidOrder}}</sub></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black-50" id="undelivered"  href="{{ route('seller_order_undelivered') }}" >等待出貨<sub class="text-danger ml-1">{{$countUndeliveredOrder}}</sub></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black-50" id="delivered" href="{{ route('seller_order_delivered') }}">運送中<sub class="text-danger ml-1">{{$countDeliveredOrder}}</sub></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black-50" id="finished"  href="{{ route('seller_order_finished') }}">已完成<sub class="text-danger ml-1">{{$countFinishedOrder}}</sub></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black-50" id="canceled" href="{{ route('seller_order_canceled') }}">已取消<sub class="text-danger ml-1">{{$countCanceledOrder}}</sub></a>
                        </li>
                    </ul>
                </div>
                <?php
                     $order_number="";
                ?>
                @foreach($order as $order_detail)
                <?php
                    if($order_number=="")
                    {
                        $order_number = $order_detail->order_id;
                    }else{
                        $order_number .= ",".$order_detail->order_id;
                    }
                ?>
                @endforeach
                <div class="row">
                    <div class="col-md-12 mb-4 pl-4 ml-4">
                        <a href="{{ route('seller_order_all',['order' => json_encode($order_number) ] ) }}"><button  type="button" class="btn btn-secondary">列印</button></a>
                    </div>
                </div>
                <div class="col-md-12">
                    <table id="table_nocontroler" class="table">
                        <thead>
                            <tr>
                                <th>得標者圖片</th>
                                <th>得標者姓名</th>
                                <th>訂單編號</th>
                                <th>訂單產生時間</th>
                                <th>總金額</th>
                                <th>狀態</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order as $order_detail)
                            <tr id="order_item">
                                <td scope="row">
                                    <img id="order_img" src="https://graph.facebook.com/{{ $order_detail->buyer_fbid }}/picture" class="img-fluid img">
                                </td>
                                <td>{{$order_detail->buyer_name}}</td>
                                <td>{{$order_detail->order_id}}</td>
                                <td>{{$order_detail->created_at}}</td>
                                <td class="format">{{$order_detail->all_total}}</td>
                                <td>{{$order_detail->order_status}}<br>
                                    {{$order_detail->message}}
                                </td>
                                <td><a href="{{ route('seller_order_pdf',['order_id' => json_encode($order_detail->order_id)]) }}"><button  type="button" class="btn btn-secondary">列印</button></a></td>
                                <td><a href="{{ route('excel_printer',['order_id' => json_encode($order_detail->order_id)]) }}"><button  type="button" class="btn btn-secondary">Excel</button></a></td>
                                <td><a href="{{ route('seller_order_detail',['order_id' => json_encode($order_detail->order_id)]) }}"><button  type="button" class="btn btn-outline-dark">查看詳情</button></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Cotent end-->
</div>
   
@stop
@section('footer')
<script>
        $('.format').each(function () {
            var currncy =  formatCurrency($(this).text());
            $(this).text(currncy);
        });




        function formatCurrency(total) {
            var neg = false;
            if(total < 0) {
                neg = true;
                total = Math.abs(total);
            }
            return (neg ? "-$" : '$') + parseFloat(total, 10).toFixed(0).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
        }

    $( document ).ready(function() {
        const driver = new Driver(
        //     {
        // onHighlightStarted: (Element) => {

        //     if(localStorage['visited']==undefined || localStorage['visited']=="yes"){
        //         $('#table_nocontroler').DataTable()
        //                     .row.add(['<img src="https://graph.facebook.com/321923508505733/picture" class="img-fluid img" style="height:64px;width:64px" >',"來福測試人頭","15628281513328029453",'2019-07-11 14:55:51	','$80','訂單完成','<button  type="button" class="btn btn-secondary">列印</button>','<button  type="button" class="btn btn-outline-dark">查看詳情</button>'])
        //                     .draw()
        //                     .node();   
        //     }
        //     localStorage['visited'] = "yes";
        // },
        // onDeselected: (Element) =>{

        //     var nodes = [];
        //     $('#table_nocontroler').DataTable().rows().every( function(rowIdx, tableLoop, rowLoop) {
        //         if ( this.data()[1] == '來福測試人頭') nodes.push(this.node())
        //     })
           
        //         $('#table_nocontroler').DataTable().row(nodes[0]).remove().draw()
            
        //     window.localStorage.removeItem('visited');
        // }    
        // }
        );

        driver.defineSteps([
                {
                    element: '.col-md-12.mb-4',
                    popover: {
                        title: '訂單狀態頁籤',
                        description: '查看各狀態之訂單',
                        position: 'bottom'
                    }
                },
                {
                    element: '.btn.btn-secondary',
                    popover: {
                        title: '點選列印',
                        description: '列印<strong>全部</strong>訂單',
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
                    element:'#table_nocontroler_filter',
                    popover: {
                        title: '快速尋找訂單',
                        description: '只需輸入關鍵字即可！',
                        position: 'bottom'
                    }
                },
                {
                    element: '#table_nocontroler',
                    popover: {
                        title: '點選查看訂單總資訊',
                        description: '可以查看顧客訂單資訊',
                        position: 'bottom'
                    }
                },
                {
                    element: 'td>a>.btn.btn-secondary',
                    popover: {
                        title: '點選列印',
                        description: '列印<strong>單筆</strong>訂單',
                        position: 'left-bottom'
                    }
                },
                {
                    element: '.btn.btn-outline-dark',
                    popover: {
                        title: '點選查看詳情',
                        description: '可以查看訂單更進一步資訊',
                        position: 'left-bottom'
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

