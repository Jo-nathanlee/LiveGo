@extends('layouts.master_checkout')

@section('title','Live GO 結帳')

@section('content')          
<div class="wrapper">
    <!-- Page Content  -->
    <div id="content">
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
                <form class="row" action="{{ route('ECPayCheckout') }}" method="POST">
                {{ csrf_field() }}
                    <diV class="col-md-6">
                        <div class="form-group">
                            <label for="formGroupExampleInput">訂購人</label>
                            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="{{$buyer_name}}">
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput2">電話</label>
                            <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="請輸入收件人電話 ...">
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput">付款方式</label>
                            <select class="custom-select" name="payway">
                                <option value="ALL" selected>ALL</option>
                                <option value="Credit">Credit</option>
                                <option value="CVS">CVS</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput2">物流方式</label>
                            <select class="custom-select">
                                <option selected>請選擇物流方式</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </diV>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="formGroupExampleInput">計件地址</label>
                            <div class="input-group">

                                <div class="input-group-prepend">
                                    <select class="custom-select">
                                        <option selected>國內</option>
                                        <option value="1">國外</option>
                                    </select>
                                </div>
                                <input type="text" class="form-control" placeholder="請輸入寄件地址 ..." aria-label="" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="comment">備註:</label>
                            <textarea class="form-control" rows="8" id="comment"></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="total_amount" value="{{ $all_total}}">
                    <input type="hidden" name="store_name" value="{{$page_name}}">
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