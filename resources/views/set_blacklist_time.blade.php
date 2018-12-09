@extends('layouts.master')

@section('title','設定棄標時間')
@section('heads')
<script src="js/add_product.js"></script>
<script>
    function message_danger() {
        // error_code 接收錯誤代碼 error_msg 接收錯誤提示訊息
        var alert_div = document.createElement("div");
        alert_div.setAttribute('id', 'data_info');
        alert_div.setAttribute("class", "card-body align-middle h5 text-center bg-light");
        alert_div.innerHTML =
            "<strong><i class='icofont icofont-exclamation-circle h1'></i> </strong><div class='mt-4'>  {{ session('alert') }}</div>";
        var warp_div = document.createElement("div");

        warp_div.setAttribute("class", "card shadow show_msg_center  w-25 bg-light")
        warp_div.append(alert_div);
        $("html").append(warp_div);

        setTimeout(
            function () {
                $("#data_info").fadeToggle(1000);
            }, 2000);
        setTimeout(
            function () {
                $("#data_info").parent().remove();
            }, 3000);
    }
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
        <div id="main" class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('set_blacklist_time') }}" enctype="multipart/form-data" method="POST">
                        {{ csrf_field() }}
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button class="btn btn-secondary" type="button">得標付款期限設定</button>
                                </div>
                                <input type="number" name="hours" value="{{ $hours->deadline_time }}" class="form-control" placeholder="請輸入付款期限 (小時) ..." aria-label="" aria-describedby="basic-addon1">
                            </div>
                            <div class="form-row text-center">
                                <div class="col-12">
                                    <button type="submit" id="btnSubmit" class="btn btn-outline-success d-none">修改</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cotent end-->
</div>