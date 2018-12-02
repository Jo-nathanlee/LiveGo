@extends('layouts.master')

@section('title','Live GO 編輯直播商品')
@section('heads')
<script src="js/edit_product.js"></script>
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
 <!-- main -->
    <div class="main bg-light shadow">
        <h3 class="m-3">編輯賣場商品</h3>
        <hr>
        <div class="row main">
            <div class="col-12 col-md-6">
                <form action="{{ route('edit_streaming_product') }}" enctype="multipart/form-data" method="POST">
                {{ csrf_field() }}
                    <div class="row mb-2">
                        <div class="col-md-5 ml-3 d-flex " id="pictureEdit">
                        <input type="file" class="custom-file-input" name="image" id="imgInp" required>
                            <img src="{{$product->pic_url  }}" id="pictureEdit_upload" class="img-fluid img mh-100 m-auto" />
                            <input type="hidden" name="primary_key" value="{{$product->pic_url  }}">
                        </div>
                        <div class="pictureEdit_item invisible">
                            <i class="icofont icofont-edit"></i>
                            <br>點選編輯
                        </div>
                    </div>
                    <h4>商品資訊</h4>
                    <div class="form-group">
                        <label for="exampleFormControlInput1"> 商品名稱</label>
                        <input type="text" name="name" class="form-control form-control-sm" value="{{ $product->goods_name }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1"> 商品描述</label>
                        <textarea class="form-control form-control-sm" name="description" id="exampleFormControlTextarea1" rows="3">{{ $product->description }}</textarea>
                    </div>
                    <h4>價格與庫存</h4>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">商品價格</label>
                        <input type="text" name="price" class="form-control form-control-sm" value="{{ $product->goods_price }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">商品數量</label>
                        <input type="text" name="num" class="form-control form-control-sm" value="{{ $product->goods_num }}">
                    </div>
                    <input class="btn btn-info float-right" type="submit" value="送出">
                </form>
                <form action="{{ route('delete_streaming_product') }}" enctype="multipart/form-data" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="primary_key" value="{{$product->pic_url  }}">
                <input class="btn btn-danger float-right ml-2" type="submit" value="刪除">
                </form>
            </div>
        </div>
    </div>
    <!-- main end -->
</div>
<!-- Cotent end-->
<!-- Edit picture div strat -->
<div class="col-md-12 d-none" id="activity">
    <div class="card col-offset-4" id="activtiy-content">
        <div class="card-body">
            <div class="card">
                <div class="card-body">
                    <i class="icofont icofont-ui-close float-right activity_close m-1"></i>
                    <div class="imageBox">
                        <div class="thumbBox"></div>
                        <div class="spinner">Loading...</div>
                    </div>
                    <div class="mr-3 mt-2">
                        <button class="btn btn-success btn-sm float-right" id="btnCrop">儲存</button>
                        <button type="button" class="btn btn-secondary btn-sm float-right mr-2" id="btnZoomIn">放大</button>
                        <button type="button" class="btn btn-secondary btn-sm float-right mr-2 " id="btnZoomOut">縮小</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Edit picture div end -->
</div>
<!-- jQuery CDN - Slim version (=without AJAX) -->
@stop 
@section('footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
        crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
        crossorigin="anonymous"></script>
    <!-- My JS -->
    <script src="js/Live_go.js"></script>
    <!-- copping picture js -->
    <script src="js/Cropping.js"></script>
@stop