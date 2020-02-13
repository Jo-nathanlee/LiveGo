@extends('layouts.master_mall')

@section('title','來福商城')

@section('wrapper')
    <div class="wrapper">
@stop
@section('navbar')
    <div id="content">
        <!-- Page Content  -->
        <div id="content" style="background-color: #F5F5F5	">
            <div class="container">
                <div class="card rounded-0">
                    <div class="card-body p-0" style="min-height: 100vh ">
                    @stop
                        @section('content')
                        <div class="row text-center justify-content-center">
                            <div class="col-md-10">
                                <h3 class="text-center">
                                    <i class='fas mr-2'>&#xf49e;</i>{{ $product->goods_name }}
                                </h3>
                            </div>
                            <div class="col-md-5">
                                <div class="Product_Detail"  style="background-image: url('{{ $product->pic_url }}')"></div>
                            </div>
                            <div class="col-md-5 mt-4 pt-4">
                                <div class="bg-light p-3 font-weight-bold text-left mb-4 mt-4">
                                    <h5>價格：
                                        <span class="text-danger text-truncate">{{ $product->goods_price }}</span>
                                    </h5>
                                </div>
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend m-auto pr-2">
                                        數量：
                                    </div>
                                    <input id="goods_choese_num" type="number" min="0" max="999" class="form-control" required>
                                </div>
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend m-auto pr-2">
                                        備註：
                                    </div>
                                    <div type="text" class="form-control text-truncate">{{ $product->description }}</div>
                                </div>
                                <div class="text-left mb-4 text-truncate">
                                    剩餘商品數量： {{ $product->goods_num }} &nbsp;&nbsp;/&nbsp;&nbsp; 已銷售商品數量： {{ $product->selling_num }}
                                </div>
                                <div class="text-center">
                                    <button type="button" class="btn btn-secondary" onclick="submit_detail()">
                                            <i class='fas mr-2'>&#xf07a;</i>加入購物車
                                    </button>
                                    <form id="detail_form" class="d-none" action="{{ route('shopping_mall_addcart') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ $product->goods_name }}" name="goods_name">
                                        <input type="hidden" value="{{ $product->goods_price }}" name="goods_price">
                                        <input type="hidden" value="{{ $product->product_id }}" name="product_id">
                                        <input type="hidden" value="{{ $product->goods_num }}" name="goods_num">
                                        <input type="hidden" value="{{ $page_id}}" name="page_id">
                                        <input id="hiddengoods_choese_num" type="hidden" value="0" name="num">
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-7 text-center mt-4 pt-4">
                                來福推薦 － 為您推薦此商家其他商品
                                <br>
                                <small>TIPS ： 可以善用加價購專區商品，來獲取免運費！(免運費金額依各商家規定)</small>
                                <br>
                                <br>
                                <small>為了保障您的權益，請詳細閱讀服務條款</small>
                                <br>
                                <small>
                                    <sup>*</sup>如有其他操作上問題可以請洽
                                    <a href="https://livego.com.tw/">Live GO 來福狗</a>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')


    <script>
    function submit_detail() {
        if($("#goods_choese_num").val()==""){
            alertify.set('notifier','position', 'top-center');
            alertify.error('<i class="fas mr-2">&#xf06a;</i>'+"請輸入數量！");
        }else{
            $("#hiddengoods_choese_num").val($("#goods_choese_num").val());
            document.getElementById('detail_form').submit();
        }
    }
    </script>

@stop
