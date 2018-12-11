@extends('layouts.master_checkout')

@section('title','結帳')

@section('content')
@section('wrapper')
<div class="wrapper">
@stop
@section('navbar')
    <!-- Page Content  -->
    <div id="content" class="active">
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
                            $goods_total=0;
                        ?>
                         @foreach($order as $goods )
                        <?php
                        $values = preg_split("/[,]+/", $goods);
                        $page_name=$values[0];
                        $fb_id=$values[1];
                        $name=$values[2];
                        $goods_name=$values[3];
                        $goods_price=$values[4];
                        $goods_num=$values[5];
                        $total_price=$values[6];
                        $page_id=$values[7];
                        $uid=$values[8];
                        $pic_url=$values[9];
                        //計算訂單總金額
                        ?>
                        <tr>
                            <td>
                                <img src="{{$pic_url}}"
                                />
                            </td>
                            <td>{{$goods_name}}</td>
                            <td>{{$goods_price}}</td>
                            <td>{{$goods_num}}</td>
                            <td>{{$total_price}}</td>
                            <?php
                            $goods_total+=(int)($total_price);
                            ?>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <?php
                        $all_total=$freight+$goods_total;
                        ?>
                        <tr>
                            <td colspan="4"></td> 
                            <td>
                                <small>總金額 : {{ $goods_total }}</small>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4"></td> 
                            <td>
                                <small>運費 : {{ $freight }}</small>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4"></td> 
                            <td>
                                <small> {{ $all_total }}</small>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="col-md-12">
                <form class="row" action="/ecpayCheckout" method="POST">
                {{ csrf_field() }}
                    <diV class="col-md-6">
                        <div class="form-group">
                            <label for="formGroupExampleInput">收件人</label>
                            <input type="text" class="form-control" id="formGroupExampleInput" name="buyer_name" value="{{$name}}" required>
                            <input type="hidden"  name="buyer_fbname" value="{{$name}}">
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput2">電話</label>
                            <input type="text" class="form-control" name="phone" id="formGroupExampleInput2" placeholder="請輸入收件人電話 ..." required>
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
                                <input type="text" class="form-control" name="address" placeholder="請輸入寄件地址 ..." aria-label="" aria-describedby="basic-addon1" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="comment">備註:</label>
                            <textarea class="form-control" name="note" rows="8" id="comment"></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="goods_total" value="{{$goods_total}}">
                    <input type="hidden" name="freight" value="{{$freight}}">
                    <input type="hidden" name="all_total" value="{{ $all_total }}">
                    <input type="hidden" name="page_name" value="{{$page_name}}">
                    <input type="hidden" name="goods" value="{{json_encode($order)}}">
                    <div class="col-md-12 text-center">
                        <input type="submit" value="結帳" class="btn btn-secondary">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Cotent end-->
</div>
@stop
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