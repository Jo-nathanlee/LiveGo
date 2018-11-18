@extends('layouts.master_checkout')

@section('title','Live GO 結帳')

@section('content')    
<nav class="navbar-ft navbar-expand-sm">
    <div class="container-fluid">
        <div class="collapse navbar-collapse  col-offset-1  d-block" id="#">
            <ul class="nav-shop navbar-nav com_nav_none">
                <!-- <li class="float-right">
                    <button type="button" class="btn btn-outline-dark" id="sidebarCollapse" class="btn">
                        <i class="fas fa-align-left"></i>
                    </button>
                </li> -->
                <li class="nav-item-shop">
                    <a class="nav-link" href="#">追蹤我們
                        <i class="icofont icofont-social-facebook"></i>
                        <i class="icofont icofont-social-instagram"></i>
                    </a>
                </li>
            </ul>
            <ul class="nav-shop navbar-nav ml-auto">
                <li class="float-right d-md-none d-lg-none d-xl-none">
                    <button type="button" class="btn btn-outline-dark btn-sm dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" class="btn">
                        <i class="fas fa-align-left"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <a class="dropdown-item" href="#!"><i class="icofont icofont-social-kakaotalk mr-1"></i> 提醒</a>
                        <a class="dropdown-item" href="#!"><i class="icofont icofont-list mr-1"></i> 歷史訂單</a>
                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-video-play mr-1"></i> 節目表</a>
                        <a class="dropdown-item" href="{{ route('buyer_index') }}"><i class="icofont icofont-cart-alt mr-1"></i> 購物車</a>
                        <a class="dropdown-item" href="#!"><i class="icofont icofont-home  mr-1"></i>首頁</a>
                        <a class="dropdown-item" href="#!"> <i class="icofont icofont-helmet mr-1"></i>運動用品</a>
                        <a class="dropdown-item" href="#!"><i class="icofont icofont-goal-keeper mr-1"></i>運動配備</a>
                        <a class="dropdown-item" href="#!"><i class="icofont icofont-refree-jersey mr-1"></i>男生衣著</a>
                        <a class="dropdown-item" href="#!"><i class="icofont icofont-football mr-1"></i>球類用品</a>
                    </div>
                </li>
                <li class="nav-item-shop d-md-none d-lg-none d-xl-none">
                    <a class="nav-link" href="#">
                    <i class="icofont icofont-social-facebook"></i>
                    <i class="icofont icofont-social-instagram"></i>
                    </a>
                </li>
                <li class="nav-item-shop com_nav_none">
                    <a class="nav-link" href="#">
                        <i class="icofont icofont-ui-video-play"></i> 節目表</a>
                </li>
                <li class="nav-item-shop com_nav_none">
                    <a class="nav-link" href="#">
                        <i class="icofont icofont-list"></i> 歷史訂單</a>
                </li>
                <li class="nav-item-shop com_nav_none">
                    <a class="nav-link" href="#">
                        <i class="icofont icofont-social-kakaotalk"></i> 提醒</a>
                </li>
                <li class="dropdown ml-auto">
                    <a href="#" id="Account" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="https://graph.facebook.com/{{Auth::user()->fb_id}}/picture" class="rounded-circle mt-1"
                        />
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Account">
                        <a class="dropdown-item" href="{{ route('buyer_index') }}">來去逛逛</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            {{ __('登出') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<nav class="navbar-sec navbar-expand-sm ">
    <div class="container-fluid ">
        <div class="collapse navbar-collapse d-block" id="#">
            <ul class="nav-shop navbar-nav col-md-3 col-offset-1 col-sm-12">
                <li>
                    <H3 style="font-family:Microsoft JhengHei;" class="mt-2 text-nowrap">
                        <img src="img/livego.png" />來福逛逛</H3>
                </li>
                <li class="d-xl-none d-lg-none d-md-none">
                    <div class="input-group" id="search-box">
                       <input class="form-control py-2 border-right-0 border" type="search" placeholder="Search">
                        <div class="input-group-append ">
                            <div class="input-group-text align-middle" id="btnGroupAddon2">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="nav-shop col-md-7 com_nav_none">
                <div class="input-group"  id="search-box">
                    <input class="form-control py-2 border-right-0 border" type="search" placeholder="Search">
                    <div class="input-group-append ">
                        <div class="input-group-text align-middle" id="btnGroupAddon2">
                            <i class="fa fa-search"></i>
                        </div>
                    </div>
                </div>
            </ul>
            <ul class="nav-shop navbar-nav ml-auto col-md-1 com_nav_none">
                <li class="nav-item-shop">
                    <a class="nav-link" href="{{ route('buyer_index') }}">
                        <i class="icofont icofont-cart-alt text-center h3"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>      
<div class="wrapper">
    <!-- Page Content  -->
    <div id="content" class="active">
        <div id="main" class="row">
            <div class="col-md-12" id="Order_Shop">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>商品圖片</th>
                            <th>商品名稱</th>
                            <th>商品價格</th>
                            <th>商品數量</th>
                            <th>總金額</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //計算訂單總金額
                        $all_total=0;
                        //訂購人FB名稱
                        $buyer_name="";
                        $page_name="";
                        ?>
                        @foreach($order as $values )
                        <tr>
                            <td>
                                <img src="{{$values->pic_path}}"
                                />
                            </td>
                            <td>{{$values->goods_name}}</td>
                            <td>{{$values->goods_price}}</td>
                            <td>{{$values->goods_num}}</td>
                            <td>{{$values->total_price}}</td>
                            <?php
                            $all_total+=(int)($values->total_price);
                            $buyer_name=$values->name;
                            $page_name=$values->page_name;
                            ?>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text_right">
                                <small>Total : {{$all_total}}</small>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="col-md-12">
                <form class="row" action="/ecpay/ecpayCheckout" method="POST">
                {{ csrf_field() }}
                    <diV class="col-md-6">
                        <div class="form-group">
                            <label for="formGroupExampleInput">訂購人</label>
                            <input type="text" class="form-control" id="formGroupExampleInput" name="buyer_name" value="{{$buyer_name}}">
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput2">電話</label>
                            <input type="text" class="form-control" name="phone" id="formGroupExampleInput2" placeholder="請輸入收件人電話 ...">
                        </div>
                    </diV>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="formGroupExampleInput">計件地址</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="address" placeholder="請輸入寄件地址 ..." aria-label="" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="comment">備註:</label>
                            <textarea class="form-control" name="note" rows="8" id="comment"></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="total_amount" value="{{$all_total}}">
                    <input type="hidden" name="page_name" value="{{$page_name}}">
                    <input type="hidden" name="order_id" value="{{$order_id}}">
                    <input type="hidden" name="order_detail" value="{{json_encode($order)}}">
                    <div class="col-md-12 text-center">
                        <input type="submit" value="結帳" class="btn btn-secondary">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Cotent end-->
</div>
@section('footer')
<!-- jQuery CDN - Slim version (=without AJAX) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
    crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
    crossorigin="anonymous"></script>
<!-- My JS -->
<script src="js/Live_go.js"></script>
@stop