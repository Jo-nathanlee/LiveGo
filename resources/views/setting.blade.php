@extends('layouts.master')

@section('title','賣家基本資料設定')

@section('head_extension')
<link rel="stylesheet" href="css/profile.css">
@stop

@section('wrapper')
<div class="wrapper">
@stop
@section('navbar')
    <div id="content">
@stop
    @section('content')
        <div class="col-sm-12 intro">
            <div id="profileBlock" class="">
                <div class="header">
                    <div class="fb-tag">
                        <img id="page_pic" src="img/facebook_icon.png"  class="fb-icon">
                        <span id="page_name">{{$myPage->page_name}}</span>
                    </div>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#switchAccount">切換粉絲專業</a>
                </div>
                <div class="content">
                    <div class="content-header flex">
                        <h3 class="title fwB">賣家資訊</h3>
                        <div class="shop_img" id="shop_img" style="background-image:url('https://graph.facebook.com/{{$page_id}}/picture?type=large&access_token={{$token}}')"></div>
                        <input type="hidden" value="{{$page_id}}" id="current_pageid">
                        <h3 class="entitle fwB">Profile</h3>
                    </div>
                    <button type="button" class="btn btn-dark btn-edit"><i class="far fa-edit mr5  "></i>修改資料</button>
                    <form action="{{ route('update_pagedeatil') }}" method="POST" id="edit_pagedetail">
                        {{ csrf_field() }} 
                        <div class="flex-bet-center2">
                            <div class="form-group w35">
                                <label class="inputTitle">賣家名稱</label>
                                <input type="text" class="form-control" name="sender_name" id="sender_name" placeholder="請輸入賣家名稱" value="{{$page_detail->sender_name}}" readonly>
                            </div>
                            <div class="form-group w35">
                                <label class="inputTitle">手機號碼</label>
                                <input type="text" class="form-control" name="sender_phone" id="sender_phone" placeholder="請輸入手機號碼" value="{{$page_detail->sender_phone}}" readonly>
                            </div>
                        </div>
                        <div class="flex-bet-center2">
                            <div class="form-group w35">
                                <label class="inputTitle">身分證字號</label>
                                <input type="text" class="form-control" name="sender_id" id="sender_id" placeholder="請輸入身分證字號" value="{{$page_detail->sender_id}}" readonly>
                            </div>
                            <div class="form-group w35">
                                <label class="inputTitle">收信郵件</label>
                                <input type="text" class="form-control" name="sender_email" id="sender_email" placeholder="請輸入收信郵件" value="{{$page_detail->sender_email}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="inputTitle">聯絡地址</label>
                            <input type="text" class="form-control" name="sender_address" id="sender_address" placeholder="請輸入聯絡地址" value="{{$page_detail->sender_address}}" readonly>
                        </div>
                        <div class="form-group">
                            <label class="inputTitle">永久地址</label>
                            <input type="text" class="form-control" name="sender_address_forever" id="sender_address_forever" placeholder="請輸入永久地址" value="{{$page_detail->sender_address_forever}}" readonly>
                        </div>
                        <hr>
                        <h3 class="textAC m15 fwB">賣家帳戶 Bank Account</h3>
                        <div class="flex-bet-center2">
                            <div class="form-group w50">
                                <label class="inputTitle">銀行帳戶名稱</label>
                                <input type="text" class="form-control" name="bank_account_name" id="bank_account_name" placeholder="請輸入銀行帳戶名稱" value="{{$page_detail->bank_account_name}}" readonly>
                            </div>
                            <div class="form-group w50">
                                <label class="inputTitle">銀行名稱</label>
                                <input type="text" class="form-control" name="bank_name" id="bank_name" placeholder="請輸入銀行名稱" value="{{$page_detail->bank_name}}" readonly>
                            </div>
                        </div>
                        <div class="flex-bet-center2">
                            <div class="form-group w50">
                                <label class="inputTitle">銀行帳戶</label>
                                <input type="text" class="form-control" name="bank_account" id="bank_account" placeholder="請輸入銀行帳戶" value="{{$page_detail->bank_account}}" readonly>
                            </div> 
                            <div class="form-group w50">
                                <label class="inputTitle">分行代號</label>
                                <input type="text" class="form-control" name="bank_code" id="bank_code" placeholder="請輸入分行代號" value="{{$page_detail->bank_code}}" readonly>
                            </div>
                        </div>
                        <h3 class="textAC m15 fwB">取貨方式 Delivery Method</h3>
                        <div class="flex-bet-center2">
                            <div class="fb-tag p-2">
                                <div class="custom-control custom-checkbox" readonly>
                                    @if($page_detail->home_delivery == 1)
                                        <input type="checkbox" id="homedelivery" name="home_delivery" value="1" class="custom-control-input" checked disabled="disabled">
                                    @else
                                        <input type="checkbox" id="homedelivery" name="home_delivery" value="0" class="custom-control-input" disabled="disabled">
                                    @endif
                                    <img id="page_pic" src="img/homedelivery.png"  class="fb-icon">
                                    <label class="custom-control-label inputTitle" for="homedelivery" >自行宅配</label>
                                    <input type="button" class="btn btn-outline-secondary btn-sm" value="設定" data-toggle="modal" data-target="#freight" onclick="ship_id_set(13)" disabled="disabled">
                                </div>
                            </div>

                            <div class="fb-tag p-2">
                                <div class="custom-control w35 custom-checkbox">
                                    @if($page_detail->family_mart == 1)
                                        <input type="checkbox" id="family" name="family_mart" value="1" class="custom-control-input" checked disabled="disabled">
                                    @else
                                        <input type="checkbox" id="family" name="family_mart" value="0" class="custom-control-input" disabled="disabled">
                                    @endif
                                    <img id="page_pic" src="img/family.png"  class="fb-icon">
                                    <label class="custom-control-label" for="family">全家便利商店</label>
                                    <input type="button" class="btn btn-outline-secondary btn-sm" value="設定" data-toggle="modal" data-target="#freight" onclick="ship_id_set(15)" disabled="disabled">
                                </div>
                            </div>
                            <div class="fb-tag p-2">
                                <div class="custom-control w35 custom-checkbox">
                                    @if($page_detail->seven_eleven == 1)
                                        <input type="checkbox" id="seveneleven" name="seven_eleven" value="1" class="custom-control-input" checked disabled="disabled">
                                    @else
                                        <input type="checkbox" id="seveneleven" name="seven_eleven" value="0" class="custom-control-input" disabled="disabled">
                                    @endif
                                    <img id="page_pic" src="img/711.png"  class="fb-icon">
                                    <label class="custom-control-label" for="seveneleven">7-ELEVEN</label>
                                    <input type="button" class="btn btn-outline-secondary btn-sm" value="設定" data-toggle="modal" data-target="#freight" onclick="ship_id_set(14)" disabled="disabled">
                                </div> 
                            </div> 
                            <div class="fb-tag p-2">
                                <div class="custom-control w35 custom-checkbox">
                                    @if($page_detail->ok_mart == 1)
                                        <input type="checkbox" id="okmart" name="ok_mart" value="1" class="custom-control-input" checked disabled="disabled">
                                    @else
                                        <input type="checkbox" id="okmart" name="ok_mart" value="0" class="custom-control-input" disabled="disabled">
                                    @endif
                                    <img id="page_pic" src="img/OK.png"  class="fb-icon">
                                    <label class="custom-control-label" for="okmart">OK便利商店</label>
                                    <input type="button" class="btn btn-outline-secondary btn-sm" value="設定" data-toggle="modal" data-target="#freight" onclick="ship_id_set(16)" disabled="disabled">
                                </div>
                            </div> 
                            <div class="fb-tag p-2">
                                <div class="custom-control w35 custom-checkbox">
                                    @if($page_detail->hi_life == 1)
                                        <input type="checkbox" id="hilife" name="hi_life" value="1" class="custom-control-input" checked disabled="disabled">
                                    @else
                                        <input type="checkbox" id="hilife" name="hi_life" value="0" class="custom-control-input"  disabled="disabled">
                                    @endif
                                    <img id="page_pic" src="img/hilife.png"  class="fb-icon">
                                    <label class="custom-control-label" for="hilife">Hi-Life 萊爾富</label>
                                    <input type="button" class="btn btn-outline-secondary btn-sm" value="設定" data-toggle="modal" data-target="#freight" onclick="ship_id_set(17)" disabled="disabled">
                                </div>
                            </div>
                        </div>
                        <div class="btnBlock flex-center-center d-none">
                            <button type="button" class="btn btn-primary mr5" onclick="submitBtn()"><i class="far fa-save mr5"></i>儲存</button>
                            <button type="button" id="btn-clear" class="btn btn-light" onclick="clearBtn()"><i class="fas fa-times mr5"></i>取消</button>
                        </div>
                    </form>
                    <div class="content-footer">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="switchAccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">切換帳戶</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="radioboxBlock iconRadio">
                            @foreach($fanPage as $key)
                                <li class="flex-bet-center">
                                    <div class="switch_img" style="background-image:url('https://graph.facebook.com/{{$key['page_id']}}/picture?type=normal&access_token={{$key['access_token']}}')"></div>
                                    <img src="img/facebook_icon.png" class="fb-icon">
                                    <label style="max-width: 60%;" for="{{$key['page_id']}}">{{$key['page_name']}}</label>
                                    <input type="radio" name="radio"  value="{{$key['page_id']}}" page_name="{{$key['page_name']}}" page_token="{{$key['access_token']}}" id="{{$key['page_id']}}" name="account">
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
            <!-- 寄送退貨 -->
    <div class="modal" id="return" tabindex="-1" role="dialog" aria-labelledby="returnLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="returnLabel">寄退貨設定</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="name">寄件者姓名</label>
                                <input type="text" class="form-control" id="name" placeholder="請輸入寄件人姓名 ...">
                            </div>
                            <div class="form-group">
                                <label for="phone">寄件人電話</label>
                                <input type="text" class="form-control" id="phone" placeholder="請輸入寄件人電話 ...">
                            </div>
                            <div class="form-group">
                                <label for="location">寄件地址</label>
                                <input type="text" class="form-control" id="location" placeholder="請輸入寄件地址 ...">
                            </div>
                        </form>
                        <p>※請務必填寫真實資訊，以利送貨及退貨。</p>
                        <p>※超商店到店寄件未取退回原寄件門市，須出示身分證件領取，請勿填寫公司名稱，避免無法領取退件。</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal"
                            data-target="#freight">上一步</button>
                        <button type="button" class="btn btn-primary" id="finish" data-dismiss="modal">完成</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- 運費設定 -->
        <div class="modal" id="freight" tabindex="-1" role="dialog" aria-labelledby="freightLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="freightLabel">運費設定</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" class="form-inline">
                            <div class="custom-control custom-radio">
                                <input type="hidden" value="13" id="current_shipid">
                                <input type="radio" id="free" name="freightchoese" class="custom-control-input" checked>
                                <label class="custom-control-label" for="free">免運費</label>
                            </div>
                            <div class="custom-control custom-radio ml-2">
                                <input type="radio" id="set_freight" name="freightchoese" class="custom-control-input">
                                <label class="custom-control-label" for="set_freight">設定運費</label>
                            </div>
                            
                            <div class="w-100 mt-4">
                                <span id="nofreight" class="">免運費</span>
                                <span id="payfreight" class="d-none">
                                    <div class="form-inline">
                                            運費<input type="number" class="form-control w-25 mr-3 ml-3" name="freightfee" id="freightfee" value="0" min="0">元，
                                            滿<input type="number" class="form-control w-25 mr-3 ml-3" name="active_freightfee" id="free_shipping" value="0" min="0">
                                            免運費。
                                    </div> 
                                </span>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-primary" id="next_step" data-dismiss="modal" data-toggle="modal"
                            data-target="#return">下一步</button>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" value="" id="set_shipfee">
        <input type="hidden" value="" id="set_freeshipping">
        <input type="hidden" value="" id="set_sendername">
        <input type="hidden" value="" id="set_senderphone">
        <input type="hidden" value="" id="set_senderaddress">
    @stop 
@section('footer')    


<script>
     var CSRF_TOKEN= $('meta[name="csrf-token"]').attr('content')
     alertify.set('notifier','position', 'top-center');;
     $(function(){
            $('.btn-edit').click(function(){
                $('input').removeAttr('readonly');
                $('input').removeAttr( "disabled" )
                $('.btnBlock').removeClass('d-none');
                $('.btn-edit').addClass('btn-secondary');
                $('.btn-edit').removeClass('btn-dark');

            });
            $('.btn-clear').click(function(){
                $('input').val('');
            });


            $('input[type=radio][name=freightchoese]').change(function () {
               
                $('#nofreight').toggleClass('d-none');
                $('#payfreight').toggleClass('d-none');

            });
            

            $('input[name="radio"]').click(function(){
                    $.LoadingOverlay("show");
                    var page_id =  $(this).val();
                    var page_name =  $(this).attr('page_name');
                    var page_token =  $(this).attr('page_token');
                    $.ajax({
                        url: '/update_page',
                        type: 'POST',
                        data: { page_id:page_id , page_name:page_name , page_token:page_token , _token:CSRF_TOKEN},
                        dataType: 'JSON',
                        success: function (data) {
                            //$("#shop_img").attr("src","https://graph.facebook.com/"+page_id+"/picture?type=large&access_token="+page_token);
                            $('#shop_img').css("background-image", "url(https://graph.facebook.com/"+page_id+"/picture?type=large&access_token="+page_token+")");  
                            $("#page_name").html(page_name);
                            $('#current_pageid').val(page_id);
                            $('input[name ="sender_address"]').val(data['sender_address']);
                            $('input[name ="sender_address_forever"]').val(data['sender_address_forever']);
                            $('input[name ="sender_name"]').val(data['sender_name']);
                            $('input[name ="sender_phone"]').val(data['sender_phone']);
                            $('input[name ="sender_email"]').val(data['sender_email']);
                            $('input[name ="sender_id"]').val(data['sender_id']);
                            $('input[name ="bank_code"]').val(data['bank_code']);
                            $('input[name ="bank_name"]').val(data['bank_name']);
                            $('input[name ="bank_account"]').val(data['bank_account']);
                            $('input[name ="bank_account_name"]').val(data['bank_account_name']);


                            $('.user_p>img').attr("src", "https://graph.facebook.com/"+page_id+"/picture?type=large&access_token="+page_token);  
                            $(".user_n").html(page_name);
                            if(data['home_delivery'] == 1 ){
                                $('input[name ="home_delivery"]').attr( "checked", 'checked' );
                            }else{
                                $('input[name ="home_delivery"]').removeAttr( "checked" );
                            }

                            if(data['seven_eleven'] == 1 ){
                                $('input[name ="seven_eleven"]').attr( "checked", 'checked' );
                            }else{
                                $('input[name ="seven_eleven"]').removeAttr( "checked" );
                            }
                            if(data['ok_mart'] == 1 ){
                                $('input[name ="ok_mart"]').attr( "checked", 'checked' );
                            }else{
                                $('input[name ="ok_mart"]').removeAttr( "checked" );
                            }

                            if(data['family_mart'] == 1 ){
                                $('input[name ="family_mart"]').attr( "checked", 'checked' );
                            }else{
                                $('input[name ="family_mart"]').removeAttr( "checked" );
                            }

                            if(data['hi_life'] == 1 ){
                                $('input[name ="hi_life"]').attr( "checked", 'checked' );
                            }else{
                                $('input[name ="hi_life"]').removeAttr( "checked" );
                            }
                            
                            alertify.success('成功更改粉絲團！');
                            $.LoadingOverlay("hide");
                            $('.modal').modal('hide');

                        },
                        error: function(XMLHttpRequest, status, error) {
                            //  console.log(error);
                            // console.log(XMLHttpRequest.status);
                            console.log(XMLHttpRequest.responseText);
                        }
                    });
                
        });
    });

        function submitBtn(){
            var if_true = 0;
            var mobile=$.trim($("#sender_phone").val());
            if(!is_mobile(mobile)){
                alertify.error("手機號碼格式不正確");
                if_true++;
            }

            var email=$("#sender_email").val();
            if(!is_email(email)){
                alertify.error("email格式不正確");
                if_true++;
            }

            var id = $("#sender_id").val();
            if(!is_id(id)){
                alertify.error("身分證字號格式不正確");
                if_true++;
            }
            if(if_true==0)
            {
                $('input').attr('readonly', 'readonly');
                $('input').attr( "disabled", 'readonly');
                $('input[name ="radio"]').removeAttr('readonly');
                $('input[name ="radio"]').removeAttr('disabled');
                $('.btnBlock').addClass('d-none');
                $('.btn-edit').removeClass('btn-secondary');
                $('.btn-edit').addClass('btn-dark');
                //用ajax來送
                if( $('#homedelivery').is(':checked') ){ 
                    var homedelivery = 1;
                }else{ 
                    var homedelivery = 0;
                }
                if( $('#seveneleven').is(':checked') ){ 
                    var seveneleven = 1;
                }else{ 
                    var seveneleven = 0;
                }
                if( $('#okmart').is(':checked') ){ 
                    var okmart = 1;
                }else{ 
                    var okmart = 0;
                }
                if( $('#family').is(':checked') ){ 
                    var family = 1;
                }else{ 
                    var family = 0;
                }
                if( $('#hilife').is(':checked') ){ 
                    var hilife = 1;
                }else{ 
                    var hilife = 0;
                }
                $.LoadingOverlay("show");
                $.ajax({
                    url: '/update_pagedeatil',
                    type: 'POST',
                    data: { 
                        page_id: $('#current_pageid').val(),
                        sender_address: $('#sender_address').val(),
                        sender_address_forever: $('#sender_address_forever').val(),
                        sender_name: $('#sender_name').val(),
                        sender_phone: $('#sender_phone').val(),
                        sender_email: $('#sender_email').val(),
                        sender_id: $('#sender_id').val(),
                        bank_code: $('#bank_code').val(),
                        bank_name: $('#bank_name').val(),
                        bank_account: $('#bank_account').val(),
                        bank_account_name: $('#bank_account_name').val(),
                        home_delivery: homedelivery,
                        seven_eleven: seveneleven,
                        ok_mart: okmart,
                        family_mart: family,
                        hi_life: hilife,
                        _token:CSRF_TOKEN 
                    },
                    dataType: 'JSON',
                    success: function (data) {
                        
                        alertify.success('資料更改成功！');
                        $.LoadingOverlay("hide");
                        $('.modal').modal('hide');

                    },
                    error: function(XMLHttpRequest, status, error) {
                        //  console.log(error);
                        // console.log(XMLHttpRequest.status);
                        console.log(XMLHttpRequest.responseText);
                    }
                });
            }
        }

        function clearBtn(){
            $('input').attr('readonly', 'readonly');
            $('input').attr( "disabled", 'readonly');
            $('input[name ="radio"]').removeAttr('readonly');
            $('input[name ="radio"]').removeAttr('disabled');
            $('.btnBlock').addClass('d-none');
            $('.btn-edit').removeClass('btn-secondary');
            $('.btn-edit').addClass('btn-dark');
        }

        function is_mobile(mobile) {
            var cellphone = /^09[0-9]{8}$/; 
            if ( cellphone.test( mobile ) ) { 
                return true;
            } else {
                return false;
            }
        }

        function is_email(email) {
            reg = /^[^\s]+@[^\s]+\.[^\s]{2,3}$/;
            if ( reg.test( email ) ) { 
                return true;
            } else {
                return false; 
            }
        }

        function is_id( id ) {
            tab = "ABCDEFGHJKLMNPQRSTUVXYWZIO"                     
            A1 = new Array (1,1,1,1,1,1,1,1,1,1,2,2,2,2,2,2,2,2,2,2,3,3,3,3,3,3 );
            A2 = new Array (0,1,2,3,4,5,6,7,8,9,0,1,2,3,4,5,6,7,8,9,0,1,2,3,4,5 );
            Mx = new Array (9,8,7,6,5,4,3,2,1,1);

            if ( id.length != 10 ) return false;
            i = tab.indexOf( id.charAt(0) );
            if ( i == -1 ) return false;
            sum = A1[i] + A2[i]*9;

            for ( i=1; i<10; i++ ) {
                v = parseInt( id.charAt(i) );
                if ( isNaN(v) ) return false;
                sum = sum + v * Mx[i];
            }
            if ( sum % 10 != 0 ) return false;
            return true;
        }

        function ship_id_set(ship_id){
            //運費設定視窗
            $('#current_shipid').val(ship_id);
            $.LoadingOverlay("show");
            $.ajax({
                url: '/get_ship_set',
                type: 'POST',
                data: { 
                    page_id: $('#current_pageid').val(),
                    ship_id: ship_id,
                    _token:CSRF_TOKEN 
                },
                dataType: 'JSON',
                success: function (data) {
                    $('#freightfee').val(data['fee']);
                    $('#free_shipping').val(data['free_shipping']);
                    $('#name').val(data['sender_name']);
                    $('#phone').val(data['sender_phone']);
                    $('#location').val(data['sender_address']);
                    $.LoadingOverlay("hide");
                },
                error: function(XMLHttpRequest, status, error) {
                    console.log(XMLHttpRequest.responseText);
                }
            });
        }

        $('#next_step').click(function(){
            if($('#free').is(':checked')){
                $('#set_shipfee').val(0);
                $('#set_freeshipping').val(0);
            }else if($('#set_freight').is(':checked')){
                $('#set_shipfee').val($('#freightfee').val());
                $('#set_freeshipping').val($('#free_shipping').val());
            }
        });

        $('#finish').click(function(){
            $('#set_sendername').val($('#name').val());
            $('#set_senderphone').val($('#phone').val());
            $('#set_senderaddress').val($('#location').val());

            //ajax
            $.LoadingOverlay("show");
            $.ajax({
                url: '/update_shipping_fee',
                type: 'POST',
                data: { 
                    page_id: $('#current_pageid').val(),
                    ship_id: $('#current_shipid').val(),
                    fee: $('#set_shipfee').val(),
                    free_shipping: $('#set_freeshipping').val(),
                    sender_name: $('#set_sendername').val(),
                    sender_phone: $('#set_senderphone').val(),
                    sender_address: $('#set_senderaddress').val(),
                    _token:CSRF_TOKEN 
                },
                dataType: 'JSON',
                success: function (data) {
                    
                    alertify.success('資料更改成功！');
                    $.LoadingOverlay("hide");
                    $('.modal').modal('hide');

                },
                error: function(XMLHttpRequest, status, error) {
                    //  console.log(error);
                    // console.log(XMLHttpRequest.status);
                    console.log(XMLHttpRequest.responseText);
                }
            });
        });    

</script>
@stop

