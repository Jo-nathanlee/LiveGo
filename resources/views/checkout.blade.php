@extends('layouts.master_mall')

@section('title','結帳')
@section('heads')

@stop

@section('wrapper')
<div class="wrapper">
@stop
@section('navbar')
    <div id="content" style="background-color: #F5F5F5	">
        <div class="container">
            <div class="card rounded-0">
                <div class="card-body p-0">
                @stop
                    @section('content')
                    <div class="row justify-content-center pl-4" style="max-width: 100%;min-height: 100vh;">
                        <div class="col-md-10 " >
                            <div class="media mt-3 pb-3 border-bottom font-weight-bolder">
                                <div class="media-body d-flex align-self-center mr-3 ">
                                    商品圖片
                                </div>
                                <div class="media-body d-flex align-self-center mr-3">
                                    商品名稱
                                </div>
                                <div class="media-body d-flex align-self-center mr-3">
                                    商品單價
                                </div>
                                <div class="media-body d-flex align-self-center mr-3">
                                    商品數量
                                </div>
                                <div class="media-body d-flex align-self-center mr-3 ">
                                    總價
                                </div>
                            </div>
                            <?php
                            $goods_total=0;
                            ?>
                            @if($streaming_order != null)
                            @foreach($streaming_order as $goods)
                            <?php
                            $values = preg_split("/[,]+/", $goods);
                            $page_name=$values[0];
                            $fb_id=$values[1];
                            $name=$values[2];
                            $goods_name=$values[3];
                            $goods_price=$values[4];
                            $goods_num=$values[5];
                            $goods_total+=$values[6];
                            $total_price=$values[6];
                            $page_id=$values[7];
                            $uid=$values[8];
                            $pic_url=$values[9];
                            $category=$values[10];
                            $product_id=$values[11];
                            //計算訂單總金額
                            ?>
                            <div class="media mt-3 pb-3 border-bottom text-center">
                                <div class="media-body d-flex align-self-center mr-3 ">
                                    <img class="d-flex mr-3 align-self-center "  onerror="this.src='img/Products.png';" style="height: 3rem;width: 3rem" src="{{$pic_url}}">
                                </div>
                                <div class="media-body d-flex align-self-center mr-3">
                                    {{$goods_name}}<?php if($category!="empty"){ echo '，'.$category ; }  ?>
                                </div>
                                <div class="media-body d-flex align-self-center mr-3 currencyField">
                                    {{$goods_price}}
                                </div>
                                <div class="media-body d-flex align-self-center mr-3">
                                    {{$goods_num}}
                                </div>
                                <div class="media-body d-flex align-self-center mr-3 currencyField">
                                    {{$total_price}}
                                </div>
                            </div>
                            @endforeach
                            @endif
                            @if($shop_order != null)
                            @foreach($shop_order as $goods)
                            <?php
                            $values = preg_split("/[,]+/", $goods);
                            $page_name=$values[0];
                            $fb_id=$values[1];
                            $name=$values[2];
                            $goods_name=$values[3];
                            $goods_price=$values[4];
                            $goods_num=$values[5];
                            $goods_total+=$values[6];
                            $total_price=$values[6];
                            $page_id=$values[7];
                            $uid=$values[8];
                            $pic_url=$values[9];
                            $category=$values[10];
                            $product_id=$values[11];
                            //計算訂單總金額
                            ?>
                            <div class="media mt-3 pb-3 border-bottom text-center">
                                <div class="media-body d-flex align-self-center mr-3 ">
                                    <img class="d-flex mr-3 align-self-center "  onerror="this.src='img/Products.png';" style="height: 3rem;width: 3rem" src="{{$pic_url}}">
                                </div>
                                <div class="media-body d-flex align-self-center mr-3">
                                    {{$goods_name}}<?php if($category!="empty"){ echo '，'.$category ; }  ?>
                                </div>
                                <div class="media-body d-flex align-self-center mr-3 currencyField">
                                    {{$goods_price}}
                                </div>
                                <div class="media-body d-flex align-self-center mr-3">
                                    {{$goods_num}}
                                </div>
                                <div class="media-body d-flex align-self-center mr-3 currencyField">
                                    {{$total_price}}
                                </div>
                            </div>
                            @endforeach
                            @endif
                            <div class="media mt-3 pb-3 border-bottom text-center">
                                <div class="media-body d-flex align-self-center mr-3">
                                    訂單金額：<span class="currencyField">{{ $goods_total }}</span>
                                </div>
                                <div class="media-body d-flex align-self-center mr-3">
                                    運費：<span id="freight" class="currencyField">0</span>
                                </div>
                                <div class="media-body d-flex align-self-center mr-3">
                                    總付款金額：<span id="all_total_span" class="currencyField"> {{ $goods_total }} </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="Recipient">收件人</label>
                                <input type="text" maxlength="4" minlength="2" onkeyup="value=value.replace(/[ -~]/g,'')" onkeydown="if(event.keyCode==13)event.keyCode=9" class="form-control" id="inputRecipient" placeholder="請輸入寄件人 ...">
                            </div>
                            <div class="form-group">
                                <label for="inputContactPhone">手機</label>
                                <input type="text" maxlength="10" class="form-control" id="inputContactPhone" placeholder="請輸入電話 ...">
                            </div>
                            <div class="form-group">
                                <label for="inputShippingMethods">物流方式</label>
                                <select class="custom-select" id="inputShippingMethods" required>
                                    <option value="0" class="d-none" selected>請選擇物流方式 ...</option>
                                    @foreach($ship as $option )
                                        @if( $page->ecpay == "true")
                                            <option value="{{$option->ship_id}}">{{$option->ship_type}}</option>
                                        @else
                                            @if($option->value != "FAMIC2C" AND $option->value != "UNIMARTC2C")
                                                <option value="{{$option->ship_id}}"">{{$option->ship_type}}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputPaymentMethod">付款方式</label>
                                <select class="custom-select" id="inputPaymentMethod">
                                    <option value="0" class="d-none" selected>請選擇付款方式 ...</option>
                                    {{-- <option value="1" >轉帳</option> --}}
                                        @if( $page->ecpay =="true")
                                            <option value="1">自行轉帳</option>
                                            <option value="2">線上支付</option>
                                        @else
                                            <option value="1">自行轉帳</option>
                                        @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="inputMailingAddress">寄件地址</label>
                                <input type="text" maxlength="1024" class="form-control" id="inputMailingAddress" placeholder="請輸入寄件地址 ...">
                            </div>
                            <div class="form-group">
                                <label for="inputMailingAddress">Email</label>
                                <input type="email" maxlength="1024" class="form-control" id="inputEMail" placeholder="請輸入Email ...">
                            </div> 
                            <div class="form-group">
                                <label for="inputRemark">備註:</label>
                                <textarea class="form-control" maxlength="2048" placeholder="請輸入備註 ..." name="note" rows="5" id="inputRemark"></textarea>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="text-center">
                                <button type="button" id="btnSubmit" class="btn btn-secondary">結帳</button>
                            </div>
                        </div>
                    </div>
                    <form class="d-none" id="checkoutForm" action="/ecpayCheckout" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" id="hiddenRecipient" name="buyer_name">
                        <input type="hidden" id="hiddenContactPhone" name="phone">
                        <input type="hidden" id="hiddenMailingAddress" name="address">
                        <input type="hidden" id="hiddenShippingMethod" name="shipping_method">
                        <input type="hidden" id="hiddenPaymentType" name="payment_type">
                        <input type="hidden" id="hiddenEmail" name="email">
                        <input type="hidden" id="hiddenRemark" name="comment">
                        <input type="hidden" id="goods_total" name="goods_total" value="{{$goods_total}}">
                        <input type="hidden" id="hiddenFreight" name="freight" value="0">
                        <input type="hidden" id="all_total" name="all_total" value="{{ $goods_total }}">
                        <input type="hidden" name="page_name" value="{{$page_name}}">
                        <input type="hidden" name="streaming_order" value="{{json_encode($streaming_order)}}">
                        <input type="hidden" name="shop_order" value="{{json_encode($shop_order)}}">
                        <input type="hidden" name="page_id" value="{{ $page_id }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Cotent end-->
</div>
@stop
@section('footer')

<script>


    //過濾特殊字元
    $('input, textarea').on('input', function() {
        var c = this.selectionStart,
            r = /[<>~#$%&/]/gi,
            v = $(this).val();
        if(r.test(v)) {
            $(this).val(v.replace(r, ''));
            c--;
        }
        this.setSelectionRange(c, c);
    });


    $( "#inputShippingMethods" ).change(function() {


        var alltotal =  0;
        if(parseInt({{ $page->free_shipping }})<=parseInt({{ $goods_total }})){
            alltotal=  parseInt($("#goods_total").val());
            $("#transferfreight").text("0");
            $("#hiddenFreight").val("0");
            $("#freight").text("0");
            $("#transferhiddenFreight").val("0");
        }else{
            alltotal =  parseInt($(this).val())+ parseInt($("#goods_total").val());
            $("#transferfreight").text($("#inputShippingMethods").val());
            $("#hiddenFreight").val($(this).val());
            $("#freight").text($("#inputShippingMethods").val());
            $("#transferhiddenFreight").val($(this).val());
        }

        $("#all_total").val(alltotal);
        $("#transferall_total").val(alltotal);
        $("#all_total_span").text(alltotal);




    });


    $("#btnSubmit").on('click',function(){
  
        var re=/^09\d{2}\d{6}$/;
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regex.test($("#inputEMail").val())) {
            alertify.alert('系統訊息', '請填寫正確的E-MAIL格式', function(){ });
        }
        else if(!re.test($("#inputContactPhone").val())){
            alertify.alert('系統訊息', '請填寫正確的手機格式', function(){ });
        }
        else if($("#inputRecipient").val().length<2 || $("#inputRecipient").val().length>5){
            alertify.alert('系統訊息', '請填寫正確的中文姓名格式', function(){ });
        }
        else{
                if($( "#inputShippingMethods" ).val()==0){
                    alertify.alert('系統訊息', '請選擇物流方式！', function(){  });
                }

                if($("#inputPaymentMethod").val()==0){
                    alertify.alert('系統訊息', '請選擇付款方式！', function(){  });
                }
                if($("#inputPaymentMethod").val()==2 || $("#inputPaymentMethod").val()==1){
                    alertify.confirm('系統訊息', '確認是否送出訂單？提醒您送出訂單後無法做更改。<br><small>提醒您於規定時間內付款，若有任何問題可以立刻與店家進行反映！</small>',
                    function(){
                        $("#hiddenRecipient").val($("#inputRecipient").val());
                        $("#hiddenContactPhone").val($("#inputContactPhone").val());
                        $("#hiddenMailingAddress").val($("#inputMailingAddress").val());
                        $("#hiddenRemark").val($("#inputRemark").val());
                        $("#hiddenShippingMethod").val($("#inputShippingMethods").val());
                        $("#hiddenPaymentType").val($("#inputPaymentMethod").val());
                        $("#hiddenEmail").val($("#inputEMail").val());
                        
                        document.getElementById('checkoutForm').submit()
                }
                , function(){ });
                }
        }



    });

</script>
@stop
