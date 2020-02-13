@extends('layouts.master')

@section('title','我的訂單')

@section('head_extension')



<style>
    .right_bottom{
        position:fixed;
        z-index: 200000;
        right: 2.8rem;
        bottom: 2.2rem;
        background-color: #009944;
        width: 3.5rem;
        height: 3.5rem;
        padding: 0.5rem;
        opacity: 0.8;
    }
    .right_bottom:hover {
        opacity: 1 !important;
    }


    .right_bottom img:hover {
        animation: shake 0.82s cubic-bezier(.36,.07,.19,.97) both;
        transform: translate3d(0, 0, 0);
        backface-visibility: hidden;
        perspective: 1000px;
    }

    @keyframes shake {
        10%, 90% {
            transform: translate3d(-1px, 0, 0);
        }
        
        20%, 80% {
            transform: translate3d(2px, 0, 0);
        }

        30%, 50%, 70% {  
            transform: translate3d(-4px, 0, 0);
        }

        40%, 60% {
            transform: translate3d(4px, 0, 0);
        }
    }
</style>


@stop

@section('wrapper')
<div class="wrapper">
@stop
@section('navbar')
    <div id="content">
@stop

        @section('content')
        <table id="order" class=" table table-striped or_table" style="width:80% !important;">
            <thead>
                <tr>
                    <th>訂單日期</th>
                    <th>訂單編號</th>
                    <th>訂購人</th>
                    <th>金額</th>
                </tr>
            </thead>
            <div class="mask"></div>
            <tbody style="font-size: 1.1rem;" class="or_ck_R_box">
                @if($inconfirmed_order != null)
                    @foreach( $inconfirmed_order as $order)
                    <tr status="{{$order['status_id']}}" number="{{ $loop->iteration }}">
                        <th scope="row" class="pl-4">
                            @if($status != 0)
                            <span class="or_ck_label">
                                <input id="order_ck{{ $loop->iteration }}" name="sel_or"  type="checkbox" onclick="order_ck(this,{{ $loop->iteration }})" psid="{{$order['ps_id']}}" orderid="{{ $order['order_id'] }}" class="chkbox" />
                                <label for="order_ck{{ $loop->iteration }}"></label>
                            </span>
                            @endif
                            {{$order['time']}}
                        </th>
                        <td>{{$order['order_id']}}<a href="{{ route('inconfirmed_orders', ['ps_id' => $order['ps_id']]) }}"><i class="fas fa-info-circle or_i_L"></i></a></td>
                        <td>
                        <div class="or_photo">
                            <img src="https://graph.facebook.com/{{$order['ps_id']}}/picture?type=normal&access_token={{$token}}" class="rounded-circle">
                        </div>
                        <span style="display: inline-block;">
                            {{$order['name']}}
                        </span>
                        </td>
                        <td class="currencyField">{{$order['total']}}</td>
                    </tr>
                    @endforeach
                @endif
                @if($confirmed_order != null)
                    @foreach( $confirmed_order as $order)
                    <tr status="{{ $order->orderstatus_id }}" number="{{ $loop->iteration }}">
                        <th scope="row" class="pl-4">
                            @if($status != 0)
                                @if($order->orderstatus_id!=15)
                                    <span class="or_ck_label">
                                        <input id="order_ck{{ $loop->iteration }}" name="sel_or"  type="checkbox" onclick="order_ck(this,{{ $loop->iteration }})" psid="{{$order->ps_id}}" orderid="{{ $order->order_id  }}" class="chkbox" />
                                        <label for="order_ck{{ $loop->iteration }}"></label>
                                    </span>
                                @endif
                            @endif
                            {{ $order->created_at }} 
                        </th>
                        <td>{{ $order->order_id }}<a href="{{ route('order_detail', ['order_id' => $order->order_id]) }}"><i class="fas fa-info-circle or_i_L"></i></a></td>

                        <td>
                        <div class="or_photo">
                            <img src="https://graph.facebook.com/{{ $order->ps_id }}/picture?type=normal&access_token={{ $token }}" class="rounded-circle">
                        </div>
                        <span style="display: inline-block;">
                            {{ $order->fb_name }}
                        </span>
                        </td>
                        <td class="currencyField">{{ $order->goods_total }}</td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
            
        </table>
        <div class="right_bottom rounded-circle shadow " onclick="location.href='{{ route('order_excel',['page_id'=>$page_id,'start_date'=>$start_date,'end_date'=>$end_date ,'status'=>$status]) }}';"  data-toggle="tooltip"
            data-placement="top" title="點選下載得訂單資料">
            <img src="img/ecxel.png" class="w-100">
        </div>
        @stop 
@section('footer')    


<script>
     var CSRF_TOKEN= $('meta[name="csrf-token"]').attr('content');
    var selectedOrder = new Array();
 
    function order_cg_ok(){ //確定訂單更改
       
        var status = $("input:radio[name=cg_or_st]:checked").val();

        if(status==undefined){
            alertify.set('notifier','position', 'top-center');
            alertify.error('請選擇想要更改之訂單狀態！');
        }else{
            alertify.confirm('系統訊息', '是否確定要更改訂單狀態？<br>如果將訂單狀態改成"已取消"訂單將取消無法再做更改。', 
            function(){
                if(selectedOrder[0][0] =="尚未成立訂單"){
                    if(status!=15){ 
                        alertify.set('notifier','position', 'top-center');
                        alertify.error('尚未成立之訂單，只能將其取消無法更改為其他狀態！'); 
                    }else{
                        $(".order_top_cg").attr("disabled",true);
		                $('.order_top_cg').css({'background-color':'#eeeeee','color':'#464646','cursor':'auto'}); 
                        $(".or_ck_R_box tr").addClass("d-none");
                        $(".or_ck_R_box tr[status=" +status+ "]").removeClass("d-none");
                        $("input:checkbox[name=sel_or]:checked").parent().parent().parent('tr').attr('status',status)
                        edit_order_status(selectedOrder,status);
                    }
                }else{
                    $(".order_top_cg").attr("disabled",true);
		            $('.order_top_cg').css({'background-color':'#eeeeee','color':'#464646','cursor':'auto'}); 
                    $(".or_ck_R_box tr").addClass("d-none");
                    $(".or_ck_R_box tr[status="+ status + "]").removeClass("d-none");
                    $("input:checkbox[name=sel_or]:checked").parent().parent().parent('tr').attr('status',status)
                    edit_order_status(selectedOrder,status);
                }
             }, 
            function(){ });
            order_cg_cg1();
        }
    }

    function edit_order_status(selectedOrder ,status){
        $.ajax({
            url: '/order_edit',
            type: 'POST',
            data: {selectedOrder:selectedOrder,status:status ,page_id:'{{$page_id}}',_token:CSRF_TOKEN},
            dataType: 'JSON',
            success: function (data) {
                alertify.set('notifier','position', 'top-center');
                alertify.success('<i class="fa mr-2">&#xf14a;</i>'+"更改成功");
                setTimeout(function(){
                    location.reload(); 
                }, 1000); 
            },
            error: function(XMLHttpRequest, status, error) {
                console.log(XMLHttpRequest.responseText);
                alertify.error('更改失敗！請聯繫客服！');
            }
        });
    }

    function cg_order_status(){ //訂單更改狀況
        selectedOrder = new Array();
        $("input:checkbox[name=sel_or]:checked").each(function(){
            selectedOrder.push( [$(this).attr('orderid'),$(this).attr('psid')] );
        });


        $('.mask').css({'display':'block'}); 

        $('.order_L_box').empty();
        $(".order_L_box").prepend(
            "<ul>"+
            "<label for='order_L_cg1'><li>待確定<img src='img/tick.png' alt='ok'></li><input type='radio' name='cg_or_st' id='order_L_cg1' value='10' style='display:none;' onclick='order_L_cg(this,1)'></label>"+
            "<label for='order_L_cg2'><li>待付款<img src='img/tick.png' alt='ok'></li><input type='radio' name='cg_or_st' id='order_L_cg2' value='11' style='display:none;' onclick='order_L_cg(this,2)'></label>"+
            "<label for='order_L_cg3'><li>待出貨<img src='img/tick.png' alt='ok'></li><input type='radio' name='cg_or_st' id='order_L_cg3' value='13' style='display:none;' onclick='order_L_cg(this,3)'></label>"+
            "<label for='order_L_cg4'><li>運送中<img src='img/tick.png' alt='ok'></li><input type='radio' name='cg_or_st' id='order_L_cg4' value='12' style='display:none;' onclick='order_L_cg(this,4)'></label>"+
            "<label for='order_L_cg5'><li>已完成<img src='img/tick.png' alt='ok'></li><input type='radio' name='cg_or_st' id='order_L_cg5' value='14' style='display:none;' onclick='order_L_cg(this,5)'></label>"+
            "<label for='order_L_cg6'><li>已取消<img src='img/tick.png' alt='ok'></li><input type='radio' name='cg_or_st' id='order_L_cg6' value='15' style='display:none;' onclick='order_L_cg(this,6)'></label>"+
            "<label for='order_L_cg7'><li>退貨申請<img src='img/tick.png' alt='ok'></li><input type='radio' name='cg_or_st' id='order_L_cg7' value='16' style='display:none;' onclick='order_L_cg(this,7)'></label>"+
            "<li><button onclick='order_cg_no()'><i class='fas fa-times'></i>取消</button><button onclick='order_cg_ok()'><i class='fas fa-check'></i>更改</button></li>"+
            "</ul>"
        );
        $('.order_L_box').css({'z-index':'1501'}); 
        // $('.order_L_box ul>li:nth-child(9)').css({'display':'block'}); 
        // $('.order_L_box ul>li:nth-child(1)').css({'display':'none'}); 

        
        
    }

    function show_all(){
        $(".or_ck_R_box tr").removeClass("d-none");
        for(i=1;i<8;i++){
		    $('.order_L_box ul>label:nth-child('+(i)+')>li>img').css({'display':'none'}); 
	    }
    }

    function order_L_cg(radio,x){ //選擇訂單更改什麼狀態
        if($('.order_top_cg').css('cursor') != 'pointer'){
            $(".or_ck_R_box tr").addClass("d-none");
            $(".or_ck_R_box tr[status=" +radio.value + "]").removeClass("d-none");
        }

        if($('.order_L_box').css('z-index') != '1501'){
            $("input[name='sel_or']:checked").prop('checked', false);
            //$('.order_ck_box img').css({'display':'none'}); 
            $('table.dataTable tbody>tr').css({'background-color':'#FFFFFF'}); 
            $('table.dataTable tbody>tr>th').css({'z-index':'1','background-color':'#FFFFFF'}); 
            $('table.dataTable tbody>tr>td').css({'z-index':'1','background-color':'#FFFFFF'}); 
            $(".order_top_cg").attr("disabled",true);
		    $('.order_top_cg').css({'background-color':'#eeeeee','color':'#464646','cursor':'auto'}); 
        }





        for(i=1;i<8;i++){
            $('.order_L_box ul>label:nth-child('+(i)+')>li>img').css({'display':'none'}); 
        }
        if(radio.checked == true){
            $('.order_L_box ul>label:nth-child('+(x)+')>li>img').css({'display':'inline-block'}); 
            
        }
    }

    
    function order_cg_cg1(){ //選單變化 (恢復)
        $("input[type=radio]").prop('checked', false);


        $('.mask').css({'display':'none'}); 
        $('.order_L_box').css({'z-index':'1'}); 
        $('.order_L_box').empty();
        $(".order_L_box").prepend(
            "<ul>"+
            "<a href='{{ route('order', ['status' => 0 , 'startday' => date('Y-m-d', $start_date->getTimestamp()),'endday' => date('Y-m-d', $end_date->getTimestamp())]) }}'><li><div></div>全部訂單<i class='fas fa-paw'></i></li></a>"+
            "<a href='{{ route('order', ['status' => 10 , 'startday' => date('Y-m-d', $start_date->getTimestamp()),'endday' => date('Y-m-d', $end_date->getTimestamp())]) }}'><li>待確定</li></a>"+
            "<a href='{{ route('order', ['status' => 11 , 'startday' => date('Y-m-d', $start_date->getTimestamp()),'endday' => date('Y-m-d', $end_date->getTimestamp())]) }}'><li>待付款</li></a>"+
            "<a href='{{ route('order', ['status' => 13 , 'startday' => date('Y-m-d', $start_date->getTimestamp()),'endday' => date('Y-m-d', $end_date->getTimestamp())]) }}'><li>待出貨</li></a>"+
            "<a href='{{ route('order', ['status' => 12 , 'startday' => date('Y-m-d', $start_date->getTimestamp()),'endday' => date('Y-m-d', $end_date->getTimestamp())]) }}'><li>運送中</li></a>"+
            "<a href='{{ route('order', ['status' => 14 , 'startday' => date('Y-m-d', $start_date->getTimestamp()),'endday' => date('Y-m-d', $end_date->getTimestamp())]) }}'><li>已完成</li></a>"+
            "<a href='{{ route('order', ['status' => 15 , 'startday' => date('Y-m-d', $start_date->getTimestamp()),'endday' => date('Y-m-d', $end_date->getTimestamp())]) }}'><li>已取消</li></a>"+
            "<a href='{{ route('order', ['status' => 16 , 'startday' => date('Y-m-d', $start_date->getTimestamp()),'endday' => date('Y-m-d', $end_date->getTimestamp())]) }}'><li>退貨申請</li></a>"+
            "</ul>"
        );
        
    }

    $(document).ready(function () {
        show_all();
        var CSRF_TOKEN= $('meta[name="csrf-token"]').attr('content');
        $("input[name='sel_or']:checked").prop('checked', false);
        
        $('#order').DataTable({
            "pagingType": "full_numbers",

            "oLanguage": {
                "sLengthMenu": "顯示 _MENU_ 筆資料",
                "sInfo": "共 _TOTAL_ 筆資料",
                "sSearch":"",
                "oPaginate": {
                "sFirst":" ",
                "sPrevious": " ",
                "sNext":" ",
                "sLast":" "
            }
            }
        });
        $(function () {
            var start_date = new Date({{ $start_date->getTimestamp() }}*1000);
            var end_date = new Date({{ $end_date->getTimestamp() }}*1000);
            $('input[name="daterange"]').daterangepicker({
                "alwaysShowCalendars": true,
                autoUpdateInput: true,
                startDate: start_date,
                endDate: end_date,
                opens: 'right',
                ranges: {
                    "今天": [moment(), moment()],
                    "過去 7 天": [moment().subtract(6, "days"), moment()],
                    "本月": [moment().startOf("month"), moment().endOf("month")],
                    "上個月": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
                },
                locale: {
                    format: "YYYY-MM-DD",
                    separator: " ~ ",
                    applyLabel: "確定",
                    cancelLabel: "清除",
                    fromLabel: "開始日期",
                    toLabel: "結束日期",
                    customRangeLabel: "自訂日期區間",
                    daysOfWeek: ["日", "一", "二", "三", "四", "五", "六"],
                    monthNames: ["1月", "2月", "3月", "4月", "5月", "6月",
                        "7月", "8月", "9月", "10月", "11月", "12月"
                    ],
                  
                }
            }, function (start, end, label) {
                $.LoadingOverlay("show")
                startday = start.format('YYYY-MM-DD');
                endday = end.format('YYYY-MM-DD');
                location.replace( 'https://livego.com.tw/order?startday='+startday+'&endday='+endday);
               
            });
        });

        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2) 
                month = '0' + month;
            if (day.length < 2) 
                day = '0' + day;

            return [year, month, day].join('-');
        }


        $("#order_wrapper .row:nth-child(3) .col-md-5").removeClass("col-md-5")
        $("#order_wrapper .row:nth-child(3) .col-md-7").removeClass("col-md-7")
        $("#order_wrapper .row:nth-child(3)").prepend("<div class='order_BL_box'></div>");
        $("#order_wrapper .row:nth-child(1) .col-md-6:nth-child(1)").addClass("col-md-2");
        $("#order_wrapper .row:nth-child(1) .col-md-6:nth-child(2)").addClass("col-md-3");
        $("#order_wrapper .row:nth-child(1) .col-md-6").removeClass("col-md-6");

        $("#order_wrapper .row:nth-child(1) .col-md-2:nth-child(1)").after("<div class='col-sm-12 col-md-7 order_top_box'></div>");
        $(".order_top_box").prepend("<input type='text' class='form-control col-md-4 order_dat' id='daterange' name='daterange'/>"+
            "<span>"+
                "<i class='fas fa-sync'></i>"+
            "</span>"+
            "<button class='order_top_re d-none' onclick='' disabled='true'><i class='fas fa-times'></i>&ensp;刪除</button>"+
            "<button class='order_top_cg' onclick='cg_order_status()' disabled='true'><i class='far fa-hand-point-up'></i>&ensp;更改狀態</button>");

        $("#order_wrapper .row:nth-child(2) table").before("<div class='order_L_box ' style='width:17% !important;''></div>"); //左側選單
        $(".order_L_box").prepend(
            "<ul>"+
            "<a href='{{ route('order', ['status' => 0 , 'startday' => date('Y-m-d', $start_date->getTimestamp()),'endday' => date('Y-m-d', $end_date->getTimestamp())]) }}'><li><div></div>全部訂單<i class='fas fa-paw'></i></li></a>"+
            "<a href='{{ route('order', ['status' => 10 , 'startday' => date('Y-m-d', $start_date->getTimestamp()),'endday' => date('Y-m-d', $end_date->getTimestamp())]) }}'><li>待確定</li></a>"+
            "<a href='{{ route('order', ['status' => 11 , 'startday' => date('Y-m-d', $start_date->getTimestamp()),'endday' => date('Y-m-d', $end_date->getTimestamp())]) }}'><li>待付款</li></a>"+
            "<a href='{{ route('order', ['status' => 13 , 'startday' => date('Y-m-d', $start_date->getTimestamp()),'endday' => date('Y-m-d', $end_date->getTimestamp())]) }}'><li>待出貨</li></a>"+
            "<a href='{{ route('order', ['status' => 12 , 'startday' => date('Y-m-d', $start_date->getTimestamp()),'endday' => date('Y-m-d', $end_date->getTimestamp())]) }}'><li>運送中</li></a>"+
            "<a href='{{ route('order', ['status' => 14 , 'startday' => date('Y-m-d', $start_date->getTimestamp()),'endday' => date('Y-m-d', $end_date->getTimestamp())]) }}'><li>已完成</li></a>"+
            "<a href='{{ route('order', ['status' => 15 , 'startday' => date('Y-m-d', $start_date->getTimestamp()),'endday' => date('Y-m-d', $end_date->getTimestamp())]) }}'><li>已取消</li></a>"+
            "<a href='{{ route('order', ['status' => 16 , 'startday' => date('Y-m-d', $start_date->getTimestamp()),'endday' => date('Y-m-d', $end_date->getTimestamp())]) }}'><li>退貨申請</li></a>"+
            "</ul>"
        );
        

    });
    
</script>
@stop

