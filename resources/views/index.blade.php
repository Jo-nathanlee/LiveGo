@extends('layouts.master')

@section('title','直播')
@section('heads')
<script>


    var message_id_list = [];

    var all_product =[];
    var start_time = Date.now();
    var CSRF_TOKEN= $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function () {
        $( "#type" ).change(function() {
            $("#goods_name").val("");
        });

        var CSRF_TOKEN= $('meta[name="csrf-token"]').attr('content');
        $("#show_list").click(function () {
            let drp_product;
            let item;
            $.ajax({
                url: '/refresh_drp_product',
                type: 'GET',
                data: { page_id: {{ $page_id }},_token:CSRF_TOKEN},
                dataType: 'JSON',
                success: function (data) {
                    
                    drp_product = data;
                    var item = '<select class="custom-select" id="live_select_goods">';
                    var type=$("#type").find("option:selected").val();
                    
                    //數量制
                    if(type==1){
                        for(var i in drp_product){
                            drp_product[i]['1'] = drp_product[i]['1'].replace(/\empty/g,'無屬性');
                            item+=' <option value = '+ drp_product[i]['0'] +'>'+ drp_product[i]['0'] + '&nbsp;❰&nbsp;' + drp_product[i]['1'] +'&nbsp;❱' + '</option>';

                        }
                    }
                    //競標制度
                    if(type==2){
                        for(var i in drp_product){
                            if(drp_product[i]['1']== "empty"){
                                drp_product[i]['1'] = drp_product[i]['1'].replace(/\empty/g,'無屬性');
                                item+=' <option value = '+ drp_product[i]['0'] +'>'+ drp_product[i]['0']  + '</option>';     
                            }                   

                        }
                    }
                    item+='</select>';

                    alertify.confirm('<H4>系統訊息</h4><br>請選擇想販賣商品。<br><small>若想事先新增商品請前往直播商品設定中新增商品，或直接手動輸入商品。</small>', item, function () {


                    $("#goods_name").val($("#live_select_goods").val());

                    $('#goods_price').val($("#live_select_goods option").attr('price'));
                    $('#note').val($("#live_select_goods option").attr('note'));





                    }, function () {  });
                    
                },
                error: function(xhr, status, error) {
                    // alert(error);
                    // alert(XMLHttpRequest.status);
                    // alert(XMLHttpRequest.responseText);
                }
            });    
                
        });

        $(".emojionearea-button").append("<div id='comment_icon'><i class='icofont icofont-audio'></i></div>");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            update_button = false;
            //抓取留言
            setInterval(function () {
                ajax(update_button);
            }, 1000);


            

            //按開始競標
            $( "#time_start" ).click(function() {
                var goods_name=$("#goods_name").val();
                var type=$("#type").find("option:selected").val();
                if(goods_name!="")
                {
                    alertify.confirm('系統訊息','是否確定販賣'+goods_name+'?'
                    , function () {
                                //禁止修改名稱及+1最高價制
                                $("#type").attr("disabled", true);
                                $("#show_list").attr("disabled",true);
                                //start->end
                                $("#time_start").removeClass("d-block").addClass("d-none");
                                $("#time_end").removeClass("d-none").addClass("d-block");

                                $("#list-bid").children().remove();
                                $( "#list-bid" ).append("<li class='list-group-item list-group-item-secondary sticky-top winner_list'>得標者清單</li>");
                    $.ajax({
                            /* the route pointing to the post function */
                            url: '/start_record',
                            type: 'POST',
                            /* send the csrf-token and the input to the controller */
                            data: { page_id:'{{$page_id}}' ,type:type,  page_token:'{{$token}}',post_video_id:'{{$post_video_id}}',goods_name:goods_name,_token:CSRF_TOKEN},
                            dataType: 'JSON',
                            /* remind that 'data' is the response of the AjaxController */
                            success: function (data) {
                                all_product = data;
                                start_time = Date.now();
                                
                            },
                            error: function(xhr, status, error) {
                                // alert(error);
                                // alert(xhr.status);
                                //alert(xhr.responseText);
                                alertify.alert("連線錯誤！請稍後再試！");
                            }
                    });
                    } , function () { });
                }
                else
                {
                    alertify.alert('系統訊息', '請輸入商品名稱！！', function () {  });
                }
            });
            //按結束競標
            $( "#time_end" ).click(function() {
                $.LoadingOverlay("show");
                setTimeout(function () {
                    var goods_name=$("#goods_name").val();
                    var goods_price=$("#goods_price").val();
                    var type=$("#type").find("option:selected").val();
                
                        //+1制
                        if(type==1)
                        {
                            $.ajax({
                                    /* the route pointing to the post function */
                                    url: '/end_record',
                                    type: 'POST',
                                    /* send the csrf-token and the input to the controller */
                                    data:{ page_id:'{{$page_id}}' , video_id:'{{$video_id}}',page_token:'{{$token}}',post_video_id:'{{$post_video_id}}',start_time:start_time,goods_name:goods_name,all_product:all_product,_token:CSRF_TOKEN},
                                    dataType: 'JSON',
                                    /* remind that 'data' is the response of the AjaxController */
                                    success: function (data) {
                                        if(data!="")
                                        {
                                            all_product = data[1];
                                            var fb_id ="";
                                            data = data[0];
                                            // var data = JSON.parse(data);
                                            $.each(data, function(i, comment) {

                                                var category_text = '';
                                                if(comment.category != 'empty'){
                                                    category_text = comment.category;
                                                }
                                                    
                                                var list_style="";
                                                if(comment.num == 0){
                                                    list_style = " bg-seashell ";
                                                     
                                                }

                                                if(jQuery.inArray( comment.message_id, message_id_list )== -1){
                                                    message_id_list.push(comment.message_id);
                                                }

                                            $( "#list-bid" ).append("<li  class='list-group-item winner"+list_style+"'>\
                                            <div class='media'>\
                                                <a class='d-flex pr-3 m-auto'>\
                                                    <img src='https://graph.facebook.com/"+comment.id+"/picture?type=normal&access_token="+"{{$token}}"+"'>\
                                                </a>\
                                                <div class='media-body'>\
                                                    <h6 class='mt-0'>"+comment.name+"</h6>\
                                                    <small>"+goods_name+" <strong> "+category_text+"</strong id='edit_category'>得標數量：</small>\
                                                    <small id='small_num'>"+comment.num+"</small>\
                                                </div>\
                                                <div class='m-auto'>\
                                                    <button type='button'  class='btn btn-xm btn-warning ' onclick='edit_getter(this)'>修改</button>\
                                                    <button type='button' class='btn btn-xm btn-danger btn_delete' onclick='delete_getter(this)'>刪除</button>\
                                                </div>\
                                                    <input type='hidden' id='fb_id' value='"+comment.id+"'>\
                                                    <input type='hidden' id='message_time' value='"+comment.message_time+"'>\
                                                    <input type='hidden' id='message_id' value='"+comment.message_id+"'>\
                                                    <input type='hidden' id='message_content' value='"+comment.message+"'>\
                                                    <input type='hidden' id='message_num' value='"+comment.num+"'>\
                                                    <input type='hidden' id='messenger_text' value='"+comment.messenger_text+"'>\
                                                    <input type='hidden' id='live_video_id' value='"+comment.live_video_id+"'>\
                                                    <input type='hidden' id='category' value='"+comment.category+"'>\
                                                    <input type='hidden' id='product_id' value='"+comment.product_id+"'>\
                                                    <input type='hidden' id='price' value='"+comment.price+"'>\
                                            </div>\
                                            </li>");
                                                });
                                                $( "#list-bid" ).append("<li class='list-group-item sticky-bottom '>\
                                                <button type='button' id='confirm' class='btn btn-secondary w-100' >確定</button>\
                                                </li>");
                                        if($("#list-bid>li").length==2)
                                        {
                                            $("#list-bid").children().remove();
                                            $( "#list-bid" ).append("<li class='list-group-item list-group-item-secondary sticky-top winner_list'>得標者清單</li>");
                                        }
                                        }
                                        $.LoadingOverlay("hide");
                                    },
                                    error: function(xhr, status, error) {
                                        // alert(error);
                                        // alert(xhr.status);
                                        // alert(xhr.responseText);
                                        $.LoadingOverlay("hide");
                                        alertify.alert("連線錯誤！請稍後再試！");
                                    }
                                });

                        }
                        //最高價制
                        if(type==2)
                        {
                            $.ajax({
                                    /* the route pointing to the post function */
                                    url: '/end_record_top_price',
                                    type: 'POST',
                                    /* send the csrf-token and the input to the controller */
                                    data: { video_id:'{{$video_id}}',page_token:'{{$token}}',post_video_id:'{{$post_video_id}}',goods_name:goods_name,all_product:all_product,_token:CSRF_TOKEN},
                                    dataType: 'JSON',
                                    /* remind that 'data' is the response of the AjaxController */
                                    success: function (data) {
                                        
                                        if(data!="")
                                        {
                                            data=data[0];
                                            $( "#list-bid" ).append("<li class='list-group-item winner'>\
                                            <div class='media'>\
                                                <a class='d-flex pr-3 m-auto'>\
                                                    <img src='https://graph.facebook.com/"+data[0][0].id+"/picture?type=normal&access_token="+"{{$token}}"+"'>\
                                                </a>\
                                                <div class='media-body'>\
                                                    <h6 class='mt-0'>"+data[0][0].name+"</h6>\
                                                    <small>"+goods_name+"得標價錢：</small>\
                                                    <small id='small_price'>"+data[0][0].price+"</small>\
                                                    <small>元得標</small>\
                                                </div>\
                                                <div class='m-auto'>\
                                                        <button type='button'  class='btn btn-xm btn-warning ' onclick='edit_getter(this)'>修改</button>\
                                                        <button type='button' class='btn btn-xm btn-danger btn_delete' onclick='delete_getter(this)'>刪除</button>\
                                                </div>\
                                                    <input type='hidden' id='fb_id' value='"+data[0][0].id+"'>\
                                                    <input type='hidden' id='message_time' value='"+data[0][0].message_time+"'>\
                                                    <input type='hidden' id='message_id' value='"+data[0][0].message_id+"'>\
                                                    <input type='hidden' id='message_content' value='"+data[0][0].price+"'>\
                                                    <input type='hidden' id='message_num' value='1'>\
                                                    <input type='hidden' id='live_video_id' value='"+data[0][0].live_video_id+"'>\
                                                    <input type='hidden' id='product_id' value='"+data[0][0].product_id+"'>\
                                                    <input type='hidden' id='price' value='"+data[0][0].price+"'>\
                                            </div>\
                                            </li>");
                                            
                                                $( "#list-bid" ).append("<li class='sticky-bottom list-group-item border-top-0' button_confirm>\
                                            <div class='col-md-12 text-center'>\
                                                <button type='button' id='confirm' class='btn btn-secondary  btn-block' >確定</button>\
                                            </div>\
                                        </li>");
                                            if($("#list-bid>li").length==2)
                                            {
                                                $("#list-bid").children().remove();
                                                $( "#list-bid" ).append("<li class='list-group-item list-group-item-secondary sticky-top winner_list'>得標者清單</li>");
                                            }
                                        }
                                    
                                        $.LoadingOverlay("hide");
                                    },
                                    error: function(xhr, status, error) {
                                        // alert(error);
                                        // alert(xhr.status);
                                        // alert(xhr.responseText);
                                        // alertify.alert("連線錯誤！請稍後再試！");
                                        $.LoadingOverlay("hide");
                                    }
                            });
                        }
                    

                    $("#time_end").removeClass("d-block").addClass("d-none");
                    $("#time_start").removeClass("d-none").addClass("d-block");
                    $("#type").attr("disabled", false);
                    $("#show_list").attr("disabled",false);
                    
                }, 200);

                
            });
            
            //點擊確認後，將得標清單轉成array or json傳至後台存入資料庫
            $('#list-bid').on('click','#confirm', function(){

                $.LoadingOverlay("show");

                setTimeout(function () {
                    var type=$("#type").find("option:selected").val();
                    var buyer = [];

                    for (i = 2; i < $("#list-bid>li").length; i++) {
                        var num = $("ul li:nth-child("+i+")").find("#message_num").val();
                        var comment = $("ul li:nth-child("+i+")").find("#message_content").val();
                        var id=$("ul li:nth-child("+i+")").find("#fb_id").val();
                        var message_id=$("ul li:nth-child("+i+")").find("#message_id").val();
                        var live_video_id=$("ul li:nth-child("+i+")").find("#live_video_id").val();
                        var product_id=$("ul li:nth-child("+i+")").find("#product_id").val();
                        var messenger_text=$("ul li:nth-child("+i+")").find("#messenger_text").val();
                        var price=$("ul li:nth-child("+i+")").find("#price").val();
                        var name = $("ul li:nth-child("+i+")").find("h6").html();
                        tmp = {
                            'comment': comment,
                            'num':num,
                            'id':id,
                            'message_id':message_id,
                            'messenger_text':messenger_text,
                            'live_video_id':live_video_id,
                            'product_id':product_id,
                            'price':price,
                            'name':name,
                        };

                        buyer.push(tmp);
                    }
                    
                
                    $.ajax({
                            /* the route pointing to the post function */
                            url: '/store_streaming_order',
                            type: 'POST',
                            /* send the csrf-token and the input to the controller */
                            data: { page_id:'{{$page_id}}' ,type:type,buyer:buyer,page_token:'{{$token}}',post_video_id:'{{$post_video_id}}',_token:CSRF_TOKEN},
                            dataType: 'JSON',
                            /* remind that 'data' is the response of the AjaxController */
                            success: function (data) {
                                $("#list-bid").children().remove();
                                $( "#list-bid" ).append("<li class='list-group-item list-group-item-secondary sticky-top winner_list'>得標者清單</li>");
                                $("#type").attr("disabled", false);
                                alertify.alert("得標訊息已私訊得標者。<br><small>欲查看訂單可於訂單總攬中的得標者清單查看，或是我的訂單做修改。</small>");
                                $.LoadingOverlay("hide");
                            },
                            error: function(XMLHttpRequest, status, error) {
                                // alert(error);
                                // alert(XMLHttpRequest.status);
                                //alert(XMLHttpRequest.responseText);
                                alertify.alert("連線錯誤！請稍後再試！");
                                $.LoadingOverlay("hide");
                            }
                    });
                    $("#goods_name").val("");
                    $("#note").val("");
                    $("#goods_price").val("");

                    
                }, 200);

                
            });

        
    });

    //貼文留言
    function comments_sent(){
        if(comment_message!=''){
            $(".emojionearea-editor").html("");
            $.ajax({
                /* the route pointing to the post function */
                url: '/add_comment',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {comment:comment_message,post_video_id:'{{$post_video_id}}',page_token:'{{$token}}',_token:CSRF_TOKEN},
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    
                },
                error: function(XMLHttpRequest, status, error) {
                    // $(".emojionearea-editor").html("");
                    // alert(error);
                    // alert(XMLHttpRequest.status);
                    // alert(XMLHttpRequest.responseText);
                    alertify.alert("連線錯誤！請稍後再試！");
                }
            });
        }
    }

    function enter_event(event) {
        var x = event.which || event.keyCode;
        if(x==13)
        {
            var comment_message= $(".emojionearea-editor").html();
            
            if(comment_message!='')
            {
                $(".emojionearea-editor").html("");
                $.ajax({
                    /* the route pointing to the post function */
                    url: '/add_comment',
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {comment:comment_message,post_video_id:'{{$post_video_id}}',page_token:'{{$token}}',_token:CSRF_TOKEN},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        
                    },
                    error: function(XMLHttpRequest, status, error) {
                        // $(".emojionearea-editor").html("");
                        // alert(error);
                        // alert(XMLHttpRequest.status);
                        // alert(XMLHttpRequest.responseText);
                        alertify.alert("連線錯誤！請稍後再試！");
                    }
                });
            }
        }
    }
    // //訊息
    // function reply(event) {
    //     var CSRF_TOKEN= $('meta[name="csrf-token"]').attr('content');
    //     var alertify_text="<input type='text' id='txtReply'>"
    //     alertify.confirm('請輸入私訊', alertify_text
    //     , function () {
    //         var reply_text=$("#txtReply").val();                //接收傳送的私訊
    //         if(reply_text!="")
    //         {
    //             var message_id=$(event.target).parent().siblings('.message_id').val();
    //             console.log(message_id);
    //             $.ajax({
    //                     /* the route pointing to the post function */
    //                     url: '/reply',
    //                     type: 'POST',
    //                     /* send the csrf-token and the input to the controller */
    //                     data: { reply_text:reply_text,message_id:message_id,page_token:'{{$token}}',_token:CSRF_TOKEN},
    //                     dataType: 'JSON',
    //                     /* remind that 'data' is the response of the AjaxController */
    //                     success: function (data) {
    //                         $("#txtReply").val("");
    //                         alertify.alert("訊息已發送！");
    //                     },
    //                     error: function(xhr, status, error) {
    //                         // alert(error);
    //                         // alert(XMLHttpRequest.status);
    //                         // alert(XMLHttpRequest.responseText);
    //                         alertify.alert("連線錯誤！請稍後再試！");
    //                     }
    //             });
    //         }
    //     }
    // , function () { });
    // }
        
    //留言處點擊得標
    function bid_win(event) {
        if( $( "#time_start" ).hasClass("d-block")&&$("#goods_name").val()!="")
        {
            var type=$("#type").find("option:selected").val();
            var winner_name=$(event.target).parent().siblings('.winner_name').val();
            var message_id=$(event.target).parent().siblings('.message_id').val();
            var winner_id=$(event.target).parent().siblings('.winner_id').val();
            var comment_time=$(event.target).parent().siblings('.comment_time').val();
            var comment_message=$(event.target).parent().siblings('.comment_message').val();
            
            console.log(comment_message);
            if(comment_message.includes("+"))
            {
                
                $.ajax({
                url: '/check_inventories',
                type: 'POST',
                data: { token:'{{$token}}',all_product:all_product,comment_message:comment_message,fb_id:winner_id,_token:CSRF_TOKEN},
                dataType: 'JSON',
                async:false,
                success: function (data) {
                    if(Object.prototype.toString.call(data)=="[object String]")
                    {
                        alertify.alert(data.toString());
                    }
                    else
                    {
                        for(var i = 0 ; i<  all_product.length ; i++){
                            if(  all_product[i][1] == data[0][0].product_id){
                                all_product[i][3] = parseInt(all_product[i][3])-parseInt(data[0][0].num);
                                break;
                            }
                        }


                        var list_style="";
                        var category_text = "";
                        if(data[0][0].category != 'empty'){
                            category_text = data[0][0].category;

                        }
                            
                        if(data[0][0].num == 0){
                            list_style = " bg-seashell ";
                           
                        }

                        if(jQuery.inArray( message_id, message_id_list )== -1){
                            message_id_list.push(message_id);   
                        }
                        //////////////////////////////////////////////////////////////
                        $(event.target).addClass('d-none');
                        
                        if($("#list-bid>li").length==1)
                        {
                            $( ".winner_list" ).after("<li class='list-group-item sticky-bottom '>\
                            <button type='button' id='confirm' class='btn btn-secondary w-100' >確定</button>\
                            </li>");
                        }
                        $( ".winner_list" ).after("<li   class='list-group-item winner"+list_style+"'>\
                        <div class='media'>\
                            <a class='d-flex pr-3 m-auto'>\
                                <img src='https://graph.facebook.com/"+data[0][0].id+"/picture?type=normal&access_token="+"{{$token}}"+"'>\
                            </a>\
                            <div class='media-body'>\
                                <h6 class='mt-0'>"+winner_name+"</h6>\
                                <small>"+$("#goods_name").val()+" <strong> "+category_text+"</strong>得標數量：</small>\
                                <small id='small_num'>"+data[0][0].num+"</small>\
                            </div>\
                            <div class='m-auto'>\
                                <button type='button'  class='btn btn-xm btn-warning ' onclick='edit_getter(this)'>修改</button>\
                                <button type='button' class='btn btn-xm btn-danger btn_delete' onclick='delete_getter(this)'>刪除</button>\
                            </div>\
                            <input type='hidden' id='fb_id' value='"+data[0][0].id+"'>\
                            <input type='hidden' id='message_time' value='"+comment_time+"'>\
                            <input type='hidden' id='message_id' value='"+message_id+"'>\
                            <input type='hidden' id='message_content' value='"+comment_message+"'>\
                            <input type='hidden' id='message_num' value='"+data[0][0].num+"'>\
                            <input type='hidden' id='messenger_text' value='"+data[0][0].messenger_text+"'>\
                            <input type='hidden' id='live_video_id' value='{{$post_video_id}}'>\
                            <input type='hidden' id='category' value='"+data[0][0].category+"'>\
                            <input type='hidden' id='product_id' value='"+data[0][0].product_id+"'>\
                            <input type='hidden' id='price' value='"+data[0][0].price+"'>\
                        </div>\
                        </li>");
                    }
                },
                error: function(XMLHttpRequest, status, error) {
                    //console.log(XMLHttpRequest.responseText);
                    alertify.alert("連線錯誤！請稍後再試！");
                }
                });
            }
            
                      
        }
    }

    function ajax(update_button) {
                comment_count = $("#Comments_LiveVideo").children('li').length;
                $.ajax({
                        url: '/update_message',
                        type: 'POST',
                        data: { page_id:'{{$page_id}}',video_id:'{{$video_id}}',page_token:'{{$token}}',comment_count:comment_count,update_button:update_button,_token:CSRF_TOKEN},   //
                        dataType: 'JSON',
                        success: function (data) {
                            if(data!=null)
                            {
                                var type=$("#type").find("option:selected").val();
                                $("#Comments_LiveVideo").children().remove();
                                $.each(data, function(i, comment) {
                                        if(comment.seller=='true'){
                                            $style = "style='background-color: #e9e9e962'";
                                            $button = "";
                                        }else{
                                            $button = "";
                                            $style = "";
                                            if(comment.can_reply_privately)
                                            {
                                                $button = " <button type='button'  no='"+i+"' class='btn btn-danger btn-sm' onclick='bid_win(event)'>得標</button>";
                                            }
                                        }

                                        if(type == 2)
                                        {
                                            $button = "";
                                        }

                                        if(jQuery.inArray( comment.id, message_id_list )!= -1){
                                            $button = "";
                                        }
                                                                           
                                        


                                            $( "#Comments_LiveVideo" ).append(
                                        "<li class='list-group-item' " +$style +" >\
                                            <div class='media' >\
                                                <a class='d-flex pr-3 m-auto'>\
                                                    <img src='https://graph.facebook.com/"+comment.from.id+"/picture?type=normal&access_token="+"{{$token}}"+"'>\
                                                </a>\
                                                <div class='media-body text-truncate pr-4'>\
                                                    <h6 class='mt-0'>"+comment.from.name+"</h6>\
                                                    <small>"+comment.message+"</small>\
                                                </div>\
                                                <input type='hidden' id='message_id' class='message_id' value='"+comment.id+"'>\
                                                <input type='hidden' id='winner_id' class='winner_id' value='"+comment.from.id+"'>\
                                                <input type='hidden' id='winner_name' class='winner_name' value='"+comment.from.name+"'>\
                                                <input type='hidden' id='comment_time' class='comment_time' value='"+comment.created_time+"'>\
                                                <input type='hidden' id='comment_message' class='comment_message' value='"+comment.message+"'>\
                                                <div class='m-auto' >"+$button+"\
                                                </div>\
                                            </div>\
                                        </li>");
                                    });

                                    var s = $('#Comments_LiveVideo').scrollTop(),
                                        c = $('#scrollwarp').height();
                                    var union = $("#Comments_LiveVideo .list-group-item").height();
                                    var length = $("#Comments_LiveVideo .list-group-item").length;
                                    var height = $(".main").height();
                                    length=length*1.48;
                                    var scrollPercent = (s / ((union*length)-height)) * 100;

                                    if (scrollPercent > 95 || scrollPercent<0) {
                                        $('#Comments_LiveVideo').scrollTop(union*length);
                                    }
                                    // <button type='button' class='btn btn-primary btn-sm' id='reply' onclick='reply(event)'>訊息</button>\
                                }
                        },error: function(xhr, status, error) {
                            // conosle.log(xhr.responseText);
                            // alertify.alert("連線錯誤！請稍後再試！");
                        }
                });
            }

    //得標清單點擊改
    function edit_getter(event)
    {   
        
        
        var reget = all_product;
        all_product = reget;
        var category_option="";

        if( all_product.length == 1 )
        {
                
                category_option = '<select class="custom-select" onchange="renew_num(this);" id="category_edit">'+'<option index="no" selected="selected" class="d-none">请選擇屬性</option>'+"<option index='0'   price='"+all_product[0][2]+"'  value='"+all_product[0][1]+"' >"+all_product[0][0].replace(/\empty/g,'無屬性')+"</option></select>" ;
            
        }else
        {
            category_option = '<select class="custom-select" onchange="renew_num(this);" id="category_edit"><option selected="selected" index="no" class="d-none">请選擇屬性</option>';
            $.each(all_product, function( i, data ) {

            category_option = category_option + "<option index="+i+" price='"+data[2]+"'  value='"+data[1]+"' >"+data[0].replace(/\empty/g,'無屬性')+"</option>" ;
            });
            category_option= category_option + '</select>';
        }


        
        alertify.confirm('修改得標資訊', '<div class="form-group"><label>選擇商品種類</label>'+category_option+' </div><div class="form-group"> <label>輸入商品數量<storng class="text-danger" id="limit_label"></storng></label><input oninput="maxNumber(this);" min="1" max="'+all_product[0][3]+'" id="num_edit" class="form-control" type="number" placeholder="請輸入數量"></div>', 
        function(){ 
            
                if($("#category_edit option:selected").attr('index')=="no" || $("#num_edit").val()==""){
                    alertify.set('notifier','position', 'top-center');
                    alertify.error('請確定有選擇商品屬性或輸入商品數量！');
                }else{
                    //新增原本商品數量
                    var original_num = parseInt($(event).parent().siblings("#message_num").val());
                    var edit_num = parseInt($("#num_edit").val());
                    var goods_index = $("#category_edit option:selected").attr('index');
                    var index = -1;
                    for(var i = 0 ; i<  all_product.length ; i++){
                        if(  all_product[i][1] == $(event).parent().siblings("#product_id").val()){
                            index = i;
                            break;
                        }
                    }
                    if(index != -1){

                        all_product[index][3] =  parseInt(all_product[index][3]) + parseInt(original_num) ;
                        all_product[goods_index][3] = parseInt(all_product[goods_index][3]) - parseInt(edit_num);
                        
                    }else{
                        all_product[goods_index][3] = ( parseInt(all_product[goods_index][3]) + parseInt(original_num) - parseInt(edit_num)).toString();
                    }
                

                    
                    $(event).parent().siblings(".media-body").children("small").children("strong").html($("#category_edit option:selected").text().replace("無屬性",""));
                    $(event).parent().siblings(".media-body").children("#small_num").html($("#num_edit").val());
                    $(event).parent().siblings("#messenger_text").val("");
                    $(event).parent().siblings("#message_num").val($("#num_edit").val());
                    
                    $(event).parent().siblings("#category").val($("#category_edit option:selected").text());
                    $(event).parent().siblings("#product_id").val($("#category_edit option:selected").val());
                    $(event).parent().siblings("#price").val($("#category_edit option:selected").attr('price'));
                }
            
         }
        , function(){ });

    }  

    function renew_num(sel)
    {
        $("#limit_label").html();
        var index_select = $(sel).find(':selected').attr('index');
        if(index_select!="no"){
            $("#num_edit").attr("max", all_product[index_select][3])
            maxNumber($("#num_edit"));
        }
    }

    function maxNumber(sel)
    {
        var value = $(sel).val();
        var max = $(sel).attr('max');
        if ((value !== '') && (value.indexOf('.') === -1)) {
            $("#limit_label").html("此商品最大數量為： "+max)
            $(sel).val(Math.max(Math.min(value, max), -max));
        }

    }




    //得標清單點擊刪除
    function delete_getter(event)
    {   

      
        var original_num =parseInt( $(event).parent().siblings("#message_num").val());
        var goods_category = $(event).parent().siblings("#category").val();
        var live_video_id = $(event).parent().siblings("#live_video_id").val();

        var array_count = all_product.length;
        var goods_index = 0;
        for (var i = 0 ; i<array_count ; i++){
            if(all_product[i][0] == goods_category){
                goods_index = i;
            }
        }


        message_id_list.splice($.inArray(live_video_id, message_id_list), 1);
        all_product[goods_index][3] = ( parseInt(all_product[goods_index][3]) + parseInt(original_num)).toString();
        
        $(event).parent().parent().parent().remove();
        if($("#list-bid>li").length==2)
        {
            $("#list-bid").children().remove();
            $( "#list-bid" ).append("<li class='list-group-item list-group-item-secondary sticky-top winner_list'>得標者清單</li>");
            $("#type").attr("disabled", false);
        }
        update_button = true;
        ajax(update_button);
    }  


</script>


@stop

@section('wrapper')
<div class="wrapper">
@stop
@section('navbar')
    <div id="content">
        @stop
        @section('content')
        <div class="main">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="Fourfloors_content ">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div id="iframe_LiveVideo">
                                        {!! $url !!}
                                        </div>
                                        <div class="p-2" id="control_LiveVideo">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">商品名稱：</span>
                                                    </div>
                                                    <input type="text" class="form-control disabled" disabled id="goods_name">
                                                    <div class="input-group-append ">
                                                        <button type="button" class="btn btn-secondary"  id="show_list" >+</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" style="height:3.25rem">得標模式：</span>
                                                    </div>
                                                    <select class="custom-select" style="height:3.25rem" id="type">
                                                        <option value="1" selected>數量</option>
                                                        <option value="2">競標</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="button" id="time_start" class="btn btn-outline-dark w-100" value="開始競標">
                                                <input type="button" id="time_end" class="btn btn-secondary w-100 d-none" value="結束競標">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="Sixfloors_content overflow-auto mt-1">
                                <div class="container-fluid">
                                    <ul class="list-group" id="list-bid">
                                        <li class="list-group-item list-group-item-secondary sticky-top">得標者清單</li>
                                       
                                    </ul>
                                </div>
                            </div>

                        </div>
                        <div class="con-md-6 w-50">
                            <nav class="all_content_auto bg-white">
                                <div id="scrollwarp" class="overflow-auto">
                                    <ul class="list-group  overflow-auto" id="Comments_LiveVideo">
                                    
                                    </ul>
                                </div>
                                <ul class="sticky-bottom p-0 " id="Comments_send_LiveVideo">
                                    <li class="list-group-item">
                                        <form class="form-inline">
                                            <img src="https://graph.facebook.com/ {!! $page_id !!}/picture" class="mr-4" />
                                            <input type="text" id="comment_message" class="form-control w-75" placeholder="留言 ..." onkeypress="enter_event(event)">
                                            <button type="button" onclick="comments_sent()" class="btn btn-secondary btn-sm ml-2">傳送</button>
                                        </form>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop 
@section('footer')    

@stop