@extends('layouts.master')

@section('title','Live GO 商城商品總覽')

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
        <div id="product_mgnt" class="container-fluid main">
            <div class="row">
                <div class="col-md-12">
                    <!-- 狀態列 -->
                    <div id="product_st_nav " class="container-fluid st_nav">
                        <div class="row">
                            <div class="col-md-12">
                                <nav class="nav nav-tabs">
                                    <a class="nav-link selected" href="#!">全部</a>
                                    <a class="nav-link tip" href="#!">
                                        <span data-tooltip="'5'筆新訂單">已上架
                                            <sub>20</sub>
                                    </a>
                                    <a class="nav-link tip" href="#!">
                                        <span data-tooltip="'0'筆新訂單">已售完
                                            <sub>5</sub>
                                    </a>
                                    <a class="nav-link tip" href="#!">
                                        <span data-tooltip="'0'筆新訂單">暫停出售
                                            <sub>8</sub>
                                    </a>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <!-- 狀態列end -->
                    <!-- 搜尋 -->
                    <div id="product" class="container-fluid">
                        <div class="row">
                            <div id="product_search" class="col-sm-6 col-md-6 col-lg-8 form-group search ">
                                <div class="input-group mb-2 mr-sm-2">
                                    <input class="form-control" type="text" placeholder="商品搜尋">
                                    <div class="input-group-append">
                                        <div class="input-group-text btn">
                                            <i class="icofont icofont-search"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sort_slt col-sm-6 col-md-6 col-lg-4 float-right">
                                <button class="btn btn-light badge-pill">人氣 <small><i class="icofont icofont-sort"></i></small></button>
                                <button class="btn btn-light badge-pill">銷售數量 <small><i class="icofont icofont-sort"></i></small></button>
                                <button class="btn btn-light badge-pill">剩餘數量 <small><i class="icofont icofont-sort"></i></small></button>
                                
                            </div>
                        </div>
                    </div>
                    <hr>
                    <!-- 搜尋end -->
                    <!-- 商品列表 -->
                    <div class="container-fluid">
                        <div class="col-md-12">
                            <div class="row" id="product_mgnt_list">
                                <div  class="col-lg-2 col-md-3 col-sm-6 mt-4">
                                    <div class="col-md-12" id="add_product_btn">
                                    <a href="{{ route('AddProduct_show') }}">
                                        <i class="icofont icofont-ui-add mr-2"></i>點選新增商品
                                        </a>
                                    </div>
                                </div>
                                @foreach($products as $product)
                                <!-- ------------- -->
                                <div class="col-lg-2 col-md-3 col-sm-6">
                                    <div class="col-md-12 shadow  pb-1 mt-4">
                                        <div class="warp_img">
                                          <a href="{{route('EditProduct_show', ['key' =>$product->pic_url ])}}"><img src="{{$product->pic_url }}"></a>
                                        </div>
                                        <P class="pt-2">
                                            {{$product->goods_name}}
                                        </P>
                                        <P class="now_page">
                                            $ {{$product->goods_price}}
                                        </P>
                                        <div class="row">
                                            <small class="col-md-12">
                                                <small class="float-left">
                                                    <i class="icofont icofont-heart-alt text-danger"></i> 520
                                                </small>
                                                <small class="float-right">
                                                    <i class="icofont icofont-star text-info"></i>
                                                    <i class="icofont icofont-star text-info"></i>
                                                    <i class="icofont icofont-star text-info"></i>
                                                    <i class="icofont icofont-star text-info"></i>
                                                    <i class="icofont icofont-star"></i> (573)
                                                </small>
                                            </small>
                                        </div>
                                        <div class="row">
                                            <small class="col-md-12">
                                                <small class="float-left">
                                                    剩餘數量：2
                                                </small>
                                                <small class="float-right">
                                                    銷售數量：68
                                                </small>
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <!-- ------------- -->
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- 商品列表end -->
                </div>
            </div>
        </div>
        <!-- main end -->
    </div>
    <!-- Cotent end-->
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
    <!-- 我新增的JS -->
    <!-- <script src="js/list_mgnt.js"></script> -->
    <script src="js/jquery-tablepage-1.0.js"></script>
@stop