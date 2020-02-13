@extends('layouts.master')

@section('title','直播')
@section('head_extension')
<script>
    $(document).ready(function () {
        var CSRF_TOKEN= $('meta[name="csrf-token"]').attr('content');
        alertify.set('notifier','position', 'top-center');
        var arr_lucky;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //留言更新&判斷得標
        update_message();

        setInterval(function(){
            update_aution_sales();
        },5000);

        //處理留言
        function update_message() {
            $.ajax({
                    url: '/update_message',
                    type: 'POST',
                    data: { page_id:'{{$page_id}}',live_video_id:'{{$live_video_id}}',page_token:'{{$token}}',_token:CSRF_TOKEN },   
                    dataType: 'JSON',
                    success: function (data) {
                        // console.log(data);
                        if(data != null && data != '')
                        {
                            $("#facebook_comment").empty();
                            $.each(data, function(i, comment) {
                                if(comment.old_customer){
                                    $old_customer = "<div class='ag_mb'><br>回<br>頭<br>客<br><br></div>";
                                }
                                else{
                                    $old_customer = "";
                                }
                                if(comment.from.id != '{{$page_id}}'){
                                    var style_display = '';
                                    if(comment.can_reply_privately == true){
                                        style_display= "d-none";
                                    }
                                    if(comment.member_type == ''){
                                        $( "#facebook_comment" ).append(
                                            "<a href='#!' level='非會員' class='list-group-item list-group-item-action flex-column align-items-start fb_u V_general' onmouseover='show_btn(this)' onmouseout='hide_btn(this)'>\
                                                <div class='d-flex w-100 justify-content-between' style='height: 40px;'>\
                                                <img  src='https://graph.facebook.com/"+comment.from.id+"/picture?type=normal&access_token={{$token}}'\
                                                class='rounded-circle mr-2' width='auto' height='100%' style='vertical-align: inherit;'>\
                                                <h5 class='mb-1 mr-auto mr_nw'>"+comment.from.name+"<br>\
                                                <span class='text-muted h6 small' style='font-size:13px'>"+comment.created_time+"</span>\
                                                <span>‧</span>\
                                                <small class='comments'>"+comment.message.replace(/</g, "&lt;").replace(/>/g, "&gt;")+"</small>\
                                                </h5>\
                                                <button class='get_btn invisible' data-target='#manually_awarded' reply='"+comment.can_reply_privately+"'  time='"+comment.created_time+"' name='"+comment.from.name+"' member_type='"+comment.member_type+"'  psid='"+comment.from.id+"'  messageid='"+comment.id+"' data-toggle='modal'\
                                                onclick='manually_awarded(this)' ><i class='fas fa-plus'></i>&nbsp;得標</button>\
                                                <div class='status_Y'><i class='fas fa-check-circle "+style_display+"'></i></div>"+$old_customer+"\
                                                </div>\
                                            </a>");
                                    }else{
                                        $( "#facebook_comment" ).append(
                                            "<a href='#!' level='"+comment.member_type+"' class='list-group-item list-group-item-action flex-column align-items-start fb_u V_general' onmouseover='show_btn(this)' onmouseout='hide_btn(this)'>\
                                                <div class='d-flex w-100 justify-content-between' style='height: 40px;'>\
                                                <img  src='https://graph.facebook.com/"+comment.from.id+"/picture?type=normal&access_token={{$token}}'\
                                                class='rounded-circle mr-2' width='auto' height='100%' style='vertical-align: inherit;'>\
                                                <h5 class='mb-1 mr-auto mr_nw'>"+comment.from.name+"<div class='mb_lev lv_general'>"+comment.member_type+"</div><br>\
                                                <span class='text-muted h6 small' style='font-size:13px'>"+comment.created_time+"</span>\
                                                <span>‧</span>\
                                                <small class='comments'>"+comment.message.replace(/</g, "&lt;").replace(/>/g, "&gt;")+"</small>\
                                                </h5>\
                                                <button class='get_btn invisible' data-target='#manually_awarded' reply='"+comment.can_reply_privately+"' time='"+comment.created_time+"' name='"+comment.from.name+"' member_type='"+comment.member_type+"'  psid='"+comment.from.id+"'  messageid='"+comment.id+"' data-toggle='modal'\
                                                onclick='manually_awarded(this)' ><i class='fas fa-plus'></i>&nbsp;得標</button>\
                                                <div class='status_Y'><i class='fas fa-check-circle "+style_display+"'></i></div>"+$old_customer+"\
                                                </div>\
                                            </a>");
                                    }
                                }else{
                                    $( "#facebook_comment" ).append(
                                    "<a href='#!' level='粉絲團' class='list-group-item list-group-item-action flex-column align-items-start fb_u V_general' onmouseover='show_btn(this)' onmouseout='hide_btn(this)'>\
                                        <div class='d-flex w-100 justify-content-between' style='height: 40px;'>\
                                        <img  src='https://graph.facebook.com/"+comment.from.id+"/picture?type=normal&access_token={{$token}}'\
                                        class='rounded-circle mr-2' width='auto' height='100%' style='vertical-align: inherit;'>\
                                        <h5 class='mb-1 mr-auto mr_nw'>"+comment.from.name+"<br>\
                                        <span class='text-muted h6 small' style='font-size:13px'>"+comment.created_time+"</span>\
                                        <span>‧</span>\
                                        <small class='comments'>"+comment.message.replace(/</g, "&lt;").replace(/>/g, "&gt;")+"</small>\
                                        </h5>\
                                        <div class='status_Y'><i style='display:none' class='fas fa-check-circle'></i></div>"+$old_customer+"\
                                        </div>\
                                    </a>");
                                }


                            });
                            comment_block($("input[name='sel']:checked"));
                            
                            setTimeout(update_message,1000);
                            

                        }
                    },error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        // alertify.alert("連線錯誤！請稍後再試！");
                    }
            });
        }

        //挑選直播商品
        $('#select_product').click(function(e) {
            e.preventDefault();
            var GoodsKey = [];
            $. each($("input[name='selected_product']:checked"), function(){
                GoodsKey.push($(this). val());
            });
            if( GoodsKey.length !== 0){
                $.ajax({
                    url: '/select_product',
                    type: 'POST',
                    data: { page_id:'{{$page_id}}',live_video_id:'{{$live_video_id}}',goods_key:GoodsKey,_token:CSRF_TOKEN},
                    dataType: 'JSON',
                    success: function (data) {
                        alertify.success('成功將商品新增至直播拍賣清單中！');
                        show_auction_product()      
                        $('#addStreamingProduct').modal('toggle');
                    },
                    error: function(XMLHttpRequest, status, error) {
                        //  console.log(error);
                        // console.log(XMLHttpRequest.status);
                        console.log(XMLHttpRequest.responseText);
                    }
                });
            }else{
                alertify.error('請確認是否挑選商品！');
            }
        });



        //抽獎
        $('#btn_luckydraw').click(function(e) {
            e.preventDefault();
            $.LoadingOverlay("show");
            var arr_lucky_length = Object.keys(arr_lucky).length;
            var arr_lucky_keys = Object.keys(arr_lucky);
            if(arr_lucky_length>0)
            {
                var bg = $("#blah_prize").css('background-image');
                bg = bg.replace(/(url\(|\)|'|")/gi, '');
                var res = bg.split('base64,', 2 );
                var prize_image = res[1];

                var prize_name = $('#FormLuckyDraw').find('input[name="prize_name"]').val();
                var prize_num = $('#FormLuckyDraw').find('input[name="prize_num"]').val();

                $.ajax({
                    url: '/lucky_winner',
                    type: 'POST',
                    data: { page_id:'{{$page_id}}',video_id:'{{$video_id}}',page_token:'{{$token}}',prize_image:prize_image,arr_lucky:arr_lucky,
                            arr_lucky_keys:arr_lucky_keys,prize_name:prize_name,prize_num:prize_num,_token:CSRF_TOKEN},
                    dataType: 'JSON',
                    success: function (data) {
                        alertify.success('成功塞選出天選之人(得獎者)！');
                        clear_img('lottery','prize_Input','blah_prize');
                        $('#ComplianceList').modal('toggle');
                    },
                    error: function(XMLHttpRequest, status, error) {
                        //  console.log(error);
                        // console.log(XMLHttpRequest.status);
                        // console.log(XMLHttpRequest.responseText);
                    }
                });
            }
            clear_img('lottery','prize_Input','blah_prize');
            $('#ComplianceList').modal('toggle');
            $.LoadingOverlay("hide"); 
        });
        
        //篩選抽獎留言
        $('#prize_next').click(function(e) {
            // Coding
            $.LoadingOverlay("show");
            
            e.preventDefault();
            var bg = $("#blah_prize").css('background-image');
            bg = bg.replace(/(url\(|\)|'|")/gi, '');
            var res = bg.split('base64,', 2 );
            var getprize_image = res[1];
            var prize_name = $('#FormLuckyDraw').find('input[name="prize_name"]').val();
            var prize_num = $('#FormLuckyDraw').find('input[name="prize_num"]').val();
            var prize_keyword = $('#FormLuckyDraw').find('input[name="prize_keyword"]').val();

            if(prize_name=="" || prize_num==0 || prize_keyword==""){
                alertify.error('請確定是否輸入商品名稱、抽獎關鍵字或抽獎數量！');
                $.LoadingOverlay("hide");
            }else{
                $.ajax({
                    url: '/lucky_draw',
                    type: 'POST',
                    data: { page_id:'{{$page_id}}',live_video_id:'{{$live_video_id}}',page_token:'{{$token}}',
                            prize_name:prize_name,prize_num:prize_num,prize_keyword:prize_keyword,_token:CSRF_TOKEN},
                    dataType: 'JSON',
                    success: function (data) {
                        $('#lottery').modal('hide');
                        $('#ComplianceList').modal('show');
                        arr_lucky = data;
                        $("#luckydraw").empty();
                        $.each(data, function(i, result) {
                            $("#luckydraw").append(
                                    '<ul class="list-group gi_ul" id="Compliance" >\
                                        <li class="list-group-item d-flex  align-items-center gi_li">\
                                            <img src="https://graph.facebook.com/'+result.ps_id+'/picture?type=normal&access_token={{$token}}"\
                                                style="padding-right: 7px;padding-left: 0px;" alt="" class="col-4">\
                                            <span class="" style="padding-right: 0px;">\
                                                <span style="font-size: 1.3rem;">\
                                                    <a href="#"> '+result.name+'</a>\
                                                </span>\
                                                    <span class="ml-auto con_ok">符合資格</span>\
                                                <br>\
                                                <span style="font-size: .9rem;letter-spacing:1px;">\
                                                    '+result.time+'\
                                                </span>\
                                            </span>\
                                        </li>\
                                    </ul>'
                            )
                        }); 
                        $.LoadingOverlay("hide");  
                    },
                    error: function(XMLHttpRequest, status, error) {
                            // console.log(XMLHttpRequest.responseText);
                        }
                });

                //or  $('#IDModal').modal('hide');
                $.LoadingOverlay("hide");
                return false;
            }

        });

        $('#btn_addproduct').click(function(e) {
            $.LoadingOverlay("show");
            e.preventDefault();
            var bg = $("#blah").css('background-image');
            bg = bg.replace(/(url\(|\)|'|")/gi, '');
            var res = bg.split('base64,', 2 );
            var upload_image = res[1];
            var num_validation = false;
            var price_validation = false;
            var category_validation = false;
            var product_name = $('input[name="ProductName"]').val();
            alertify.set('notifier','position', 'top-center');
                
            var product_category = new Array();
            $('input[name^="product_category"]').each(function() {
                product_category.push($(this).val());
            });
            var product_price = new Array();
            $('input[name^="product_price"]').each(function() {
                product_price.push($(this).val());
            });
            var product_num = new Array();
            $('input[name^="product_num"]').each(function() {
                product_num.push($(this).val());
            });

            for(var i=0 ; i<product_num.length ; i++){
                if(product_num[i]<=0){
                    num_validation =true;
                }
                if(product_price[i]<=0){
                    price_validation =true;
                }
                if(product_category[i]==''){
                    if(product_category.length>1){
                        category_validation =true;
                    }
                }
            }

            if(product_name==null){
                alertify.error('請確定是否輸入商品名稱！');
                $.LoadingOverlay("hide");
            }else if(product_category.length>1 && $.inArray(null,product_category)>0   ){
                alertify.error('請確定是否輸入商品屬性！');
                $.LoadingOverlay("hide");
            }else if(num_validation==true){
                alertify.error('請確定庫存是否大於0！');
                $.LoadingOverlay("hide");
            }else if(price_validation==true){
                alertify.error('請確定價格是否大於0！');
                $.LoadingOverlay("hide");
            }else if(category_validation==true){
                alertify.error('請確定商品屬性是否輸入！');
                $.LoadingOverlay("hide");
            }
            else{
                $.ajax({
                    url: '/create_product',
                    type: 'POST',
                    data: { page_id:'{{$page_id}}',page_token:'{{$token}}',upload_image:upload_image,
                            product_name:product_name,product_category:product_category,product_price:product_price,
                            product_num:product_num,_token:CSRF_TOKEN},
                    dataType: 'json',
                    success: function (data) {
                        $.LoadingOverlay("hide");
                        alertify.success('新增成功！');
                        $('#addProduct').modal('toggle');  
                        clear_addproduct(data);    
                    },
                    
                    error: function(XMLHttpRequest, status, error) {
                            // console.log(XMLHttpRequest.responseText);
                            // console.log(XMLHttpRequest.error);
                        }
                });
            }
        });



    });
//---------------------------------------------------------------------------------------------
    var CSRF_TOKEN= $('meta[name="csrf-token"]').attr('content');
    alertify.set('notifier','position', 'top-center');
        //編輯商品
        function comment_block(element){
        var radio_val = $(element).val();

        if(radio_val == 'all'){
            $("#facebook_comment a").css('display','flex');
        }else if(radio_val == 'bk'){
            $("#facebook_comment a").css('display','flex');
            $("#facebook_comment a[level='已封鎖']").css('display','none');

        }else{
            $("#facebook_comment a").css('display','flex');
            $("#facebook_comment a[level='已封鎖']").css('display','none');
            $("#facebook_comment a[level='非會員']").css('display','none');      
            $("#facebook_comment a[level='粉絲團']").css('display','none');
        }
    }
    function EditProductShow(element){
        $("#editCategory").empty();
        $("#editCategory").append('<div id="editEvent" onclick="editEvent()" style="color:#0f7867;font-size: 18px;cursor: pointer;">\
        + 增加商品規格\
        </div>\
        <span id="error_text_edit" class="text-danger d-none">\
            (商品種類至多七種)\
        </span>');
        goods_key = $(element).attr('goodskey');
        // console.log(goods_key);
        $.LoadingOverlay("show");
        
        $.ajax({
            url: '/show_EditProduct',
            type: 'POST',
            data: { page_id:'{{$page_id}}',goods_key:goods_key,_token:CSRF_TOKEN},
            dataType: 'JSON',
            success: function (data) {          
                $.LoadingOverlay("hide");
                $("#Goods_Name").val(data[0].goods_name);
                $('#blah_edit').css('background-image', 'url(' + data[0].pic_url + ')');
                $.each(data,function( index, data ) {
                    if(index==0){
                        $("#editCategory").append('<div class="mb-2 br-10" >\
                            <input type="text"\
                                class="form-control mr-4 w-25 d-inline-block category br-10 row_inp_style"\
                                placeholder="請輸入商品規格 ..." disabled name="edit_category[]" value="'+data.category+'" required>\
                            <input type="number"\
                                class="form-control mr-4 w-25 d-inline-block price br-10 row_inp_style" min="0"\
                                value="'+data.goods_price+'" disabled name="edit_price[]" required>\
                            <input type="number"\
                                class="form-control mr-4 w-25 d-inline-block stock br-10 row_inp_style" min="0"\
                                value="'+data.goods_num+'" name="edit_num[]" required>\
                            <input type="hidden" id="HiddenGoodsKey"\
                                value="'+data.goods_key+'">\
                            <input type="hidden" name="product_id[]"\
                                value="'+data.product_id+'">\
                        </div>');
                    }else{
                        $("#editCategory").append('<div class="mb-2 br-10" >\
                            <input type="text"\
                                class="form-control mr-4 w-25 d-inline-block category br-10 row_inp_style"\
                                placeholder="請輸入商品規格 ..." disabled name="edit_category[]" value="'+data.category+'" required>\
                            <input type="number"\
                                class="form-control mr-4 w-25 d-inline-block price br-10 row_inp_style" min="0"\
                                value="'+data.goods_price+'" disabled name="edit_price[]" required>\
                            <input type="number"\
                                class="form-control mr-4 w-25 d-inline-block stock br-10 row_inp_style" min="0"\
                                value="'+data.goods_num+'" name="edit_num[]" required>\
                            <input type="hidden" name="product_id[]"\
                                value="'+data.product_id+'">\
                        </div>');
                    }
                });  
            },
            
            error: function(XMLHttpRequest, status, error) {
                    console.log(XMLHttpRequest.responseText);
            }
        });
    }
    
    function btn_editproduct(){
        $.LoadingOverlay("show");
        var goods_key = $('#HiddenGoodsKey').val();
        var goods_name =  $("#Goods_Name").val();

        var image_url = $("#blah_edit").css('background-image');
        if(!image_url.includes('imgur'))
        {
            image_url = image_url.replace(/(url\(|\)|'|")/gi, '');
            image_url = image_url.split('base64,', 2 );
            image_url = image_url[1];
        }


        var product_category = new Array();
        $('input[name^="edit_category"]').each(function() {
            product_category.push($(this).val());
        });

        var product_price = new Array();
        $('input[name^="edit_price"]').each(function() {
            product_price.push($(this).val());
        });

        var product_num = new Array();
        $('input[name^="edit_num"]').each(function() {
            product_num.push($(this).val());
        });

        var product_id = new Array();
        $('input[name^="product_id"]').each(function() {
            product_id.push($(this).val());
        });

        
        $.ajax({
            url: '/edit_product',
            type: 'POST',
            data: { 
                    page_id:'{{$page_id}}',
                    live_video_id:'{{$live_video_id}}',
                    product_id:product_id,
                    goods_key:goods_key,
                    image_url:image_url,
                    goods_name:goods_name,
                    product_category:product_category,
                    product_num:product_num,
                    product_price:product_price,
                    _token:CSRF_TOKEN,
                },
            dataType: 'JSON',
            success: function (data) {
                $.LoadingOverlay("hide");
                $('#editProduct').modal('toggle');
                show_auction_product();     
                window.location.reload();
            },
            error: function(XMLHttpRequest, status, error) {
                    console.log(XMLHttpRequest.responseText);
            }
        });
    }
    

    
    function clear_addproduct(goods_key){
        $("#blah").removeClass('New_Img').css("background-image", "");
        $("#Upload_Img").removeClass("d-none");
        $("#GoodsName").val('');
        $( "#addCategory" ).html('');
        $( "#addCategory" ).append('<div class="mb-2 br-10" required="required">\
            <input type="text" name="product_category[]" class="form-control mr-4 w-25 d-inline-block category br-10 row_inp_style" placeholder="請輸入商品規格 ...">\
            <input type="number" name="product_price[]" class="form-control mr-4 w-25 d-inline-block price br-10 row_inp_style" min="0" value="0" required="">\
            <input type="number" name="product_num[]" class="form-control mr-4 w-25 d-inline-block stock br-10 row_inp_style" min="0" value="0" required="">\
        </div>');
        $( "#addCategory" ).append('<div id="addEvent" onclick="addEvent()" style="color:#0f7867;font-size: 18px;cursor: pointer;">\
        + 增加商品規格</div>');
        $("#addProduct").modal('hide'); 

            $.ajax({
                url: '/select_product',
                type: 'POST',
                data: { page_id:'{{$page_id}}',live_video_id:'{{$live_video_id}}',goods_key:goods_key,_token:CSRF_TOKEN},
                dataType: 'JSON',
                success: function (data) {
                    alertify.success('成功將商品新增至直播拍賣清單中！');
                    show_auction_product()      
                },
                error: function(XMLHttpRequest, status, error) {
                    //  console.log(error);
                    // console.log(XMLHttpRequest.status);
                    // console.log(XMLHttpRequest.responseText);
                }
            });
    }

    //搜尋
    function SearchProudct(element){
        var value = $(element).val().toLowerCase();
        $(" .list-group.pi_ul").filter(function() {
            $(this).toggle($(this).attr('data').toLowerCase().indexOf(value) > -1)
        });
    }

    function AuctionSearch(element){
        var value = $(element).val().toLowerCase();
        $("#auction_list .media.bg-white.live_bor").filter(function() {
            $(this).toggle($(this).attr('data').toLowerCase().indexOf(value) > -1)
        });
    }

    function ManuallySearch(element){
        var value = $(element).val().toLowerCase();
        $("#bid_live_box .media.bg-white.live_bor").filter(function() {
            $(this).toggle($(this).attr('data').toLowerCase().indexOf(value) > -1)
        });
    }
    //搜尋結束
    
    //處理動態產生手動得標按鈕onmouse事件
    function show_btn(element){
        $(element).find("button").last().removeClass("invisible");
    }
    function hide_btn(element){
        $(element).find("button").last().addClass("invisible");
    }
    //結束
    //顯示手動得標
    function manually_awarded(element){
        $.LoadingOverlay("show");
        var psid = $(element).attr('psid');
        var member_type = $(element).attr('member_type');
        var messageid = String($(element).attr('messageid'));
        var name = $(element).attr('name');
        var time = $(element).attr('time');
        var reply = $(element).attr('reply');
        $.ajax({
            url: '/show_product',
            type: 'POST',
            data: { page_id:'{{$page_id}}',live_video_id:'{{$live_video_id}}',page_token:'{{$token}}',_token:CSRF_TOKEN},
            dataType: 'JSON',
            success: function (data) {
                $("#bid_live_box").children().remove();
                $("#bid_footer").children().remove();
                if(reply!='false'){
                    var reply_str = '<span style="color:#e64a3b;">(系統分析失敗)</span>';
                }else{
                    var reply_str = '<span style="color:#4db67d;">(系統分析成功，如再次新增將不會再私訊提醒買家結帳。)</span>';
                }
                $("#bid_footer").append('<img src="https://graph.facebook.com/'+psid+'/picture?type=normal&access_token={{$token}}" style="height: 40px;"\
                class="rounded-circle mr-2" width="auto" height="100%"\
                style="vertical-align: inherit;">\
                <span>'+name+'</span>\
                <div class="mb_lev lv_VIP"><i class="fas fa-thumbs-up"></i>&nbsp;'+member_type+'</div>\
                <div class="w" style="display: inline-block;text-align: center;margin-left: 10px;">\
                    '+reply_str+'<br>\
                    <span>'+time+'</span>\
                </div>\
                <div style="display: inline-block;margin-left: auto;">\
                    <button type="button" class="btn btn-secondary btn_window btn_no" data-dismiss="modal">取消</button>\
                    <button type="button" class="btn btn-primary btn_window btn_next" onclick="manually_awarded_add('+"'"+messageid+"'"+','+"'"+psid+"'"+')" \
                        style="background-color: #4db67d;margin-left: 10px;">送出</button>\
                </div>');
                if(data!="")
                {
                    $.each(data, function( index, value ) {
                        var maxnum= value['goods_num'] - value['bid_times'];
                        if(value['index'] == 1)
                        {
                            if(value['diverse']>1){
                            $( "#bid_live_box" ).append(
                                "<div class='media bg-white  live_bor' data='"+value['goods_name']+"' >"+
                                    "<div class='live_QB'>"+
                                        "<div class='QB_get'>得標數</div>"+
                                        "<div class='QB_get_N'>"+value['bid_times']+"</div>"+
                                        "<div class='QB_Q'>庫存數</div>"+
                                        "<div class='QB_Q_N' >"+value['goods_num']+"</div>"+
                                        "<div class='live_line'></div>"+
                                    "</div>"+
                                    "<img class='d-flex mr-3 rounded live_goods' src='"+value['pic_url']+"' style='margin-left: 5px;'>"+
                                    "<div class='media-body'>"+
                                        "<div class='mt-0 pt-2 product_name over-text'><span class='over-text' style='max-width:15rem;display:inherit;width:auto'>"+value['goods_name']+"<span>"+
                                            "<div class='product_edit'><i class='fas fa-edit' product_id='"+value['product_id']+"' data-dismiss='modal' data-toggle='modal' goodskey='"+value['goods_key']+"' onclick='EditProductShow(this)'  data-target='#editProduct' style='position: absolute;top: 15px;'></i></div>"+
                                            "<div class='product_KW'>關鍵字&nbsp;:&nbsp;<div class='product_Key'>&nbsp;"+value['keyword']+"&nbsp;</div></div>"+
                                            "<div class='product_cg_num_w'>選擇得標數量</div>"+
                                        "</div>"+
                                        "<div class='h6'><span class='badge badge-warning product_M'>NT$ "+value['goods_price']+"</span>"+ 
                                            "<div class='op_goods' data-toggle='collapse' data-target='.live_"+value['goods_key']+"' aria-expanded='false' aria-controls='live_"+value['goods_key']+"'>"+
                                                "<span class='product_S float-left over-text' style='max-width:150px'>"+value['all_category']+"</span>"+
                                                "<div class='op_goods_i float-right'><i class='fas fa-sort-down'></i></div>"+
                                            "</div>"+
                                            "<div class='product_cg_num'><input class='form-control' type='number' value='0' keyword='"+value['keyword']+"' min='0' max='"+maxnum+"' name='bid_num' ></div>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>");
                            }else{
                                $( "#bid_live_box" ).append(
                                "<div class='media bg-white  live_bor' data='"+value['goods_name']+"' >"+
                                    "<div class='live_QB'>"+
                                        "<div class='QB_get'>得標數</div>"+
                                        "<div class='QB_get_N'>"+value['bid_times']+"</div>"+
                                        "<div class='QB_Q'>庫存數</div>"+
                                        "<div class='QB_Q_N' >"+value['goods_num']+"</div>"+
                                        "<div class='live_line'></div>"+
                                    "</div>"+
                                    "<img class='d-flex mr-3 rounded live_goods' src='"+value['pic_url']+"' style='margin-left: 5px;'>"+
                                    "<div class='media-body'>"+
                                        "<div class='mt-0 pt-2 product_name over-text'><span class='over-text' style='max-width:15rem;display:inherit;width:auto'>"+value['goods_name']+"<span>"+
                                            "<div class='product_edit'><i class='fas fa-edit' product_id='"+value['product_id']+"' data-dismiss='modal' data-toggle='modal' goodskey='"+value['goods_key']+"' onclick='EditProductShow(this)'  data-target='#editProduct' style='position: absolute;top: 15px;'></i></div>"+
                                            "<div class='product_KW'>關鍵字&nbsp;:&nbsp;<div class='product_Key'>&nbsp;"+value['keyword']+"&nbsp;</div></div>"+
                                            "<div class='product_cg_num_w'>選擇得標數量</div>"+
                                        "</div>"+
                                        "<div class='h6'><span class='badge badge-warning product_M'>NT$ "+value['goods_price']+"</span>"+ 
                                                "<span class='product_S  over-text' style='max-width:150px'>"+value['all_category']+"</span>"+
                                            "<div class='product_cg_num'><input class='form-control' type='number' value='0' keyword='"+value['keyword']+"' min='0' max='"+maxnum+"' name='bid_num' ></div>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>");
                            }
                        }
                        else
                        {
                            $( "#bid_live_box" ).append("<div class='card collapse live_"+value['goods_key']+"' style='margin-left: 30px;'>"+
                                "<ul class='list-group list-group-flush '>"+
                                    "<li class='list-group-item d-flex justify-content-between align-items-center' style='padding:5px;'>"+
                                        "<div class='live_QB'>"+
                                            "<div class='QB_get'>得標數</div>"+
                                            "<div class='QB_get_N'>"+value['bid_times']+"</div>"+
                                            "<div class='QB_Q'>庫存數</div>"+
                                            "<div class='QB_Q_N' >"+value['goods_num']+"</div>"+
                                            "<div class='live_line'></div>"+
                                        "</div>"+
                                        "<img class='d-flex mr-3 rounded live_goods' src='"+value['pic_url']+"' style='margin-left: 5px;'>"+
                                        "<div class='media-body ' style='padding:5 '>"+
                                            "<div class='mt-0 pt-2 over-text product_name'><span class='over-text' style='max-width:15rem;display:inherit;width:auto'>"+value['goods_name']+"<span>"+
                                                "<div class='product_edit'><i class='fas fa-edit' data-dismiss='modal' product_id='"+value['product_id']+"' data-toggle='modal' goodskey='"+value['goods_key']+"' onclick='EditProductShow(this)'  data-target='#editProduct'  style='position: absolute;top: 15px;'></i></div>"+
                                                "<div class='product_KW'>關鍵字&nbsp;:&nbsp;<div class='product_Key'>&nbsp;"+value['keyword']+"&nbsp;</div></div>"+
                                                "<div class='product_cg_num_w'>選擇得標數量</div>"+
                                            "</div>"+
                                            "<div class='h6'>"+
                                                "<span class='badge badge-warning product_M'>NT$ "+value['goods_price']+"</span>"+
                                                "<span class='product_S float-left over-text' style='max-width:150px'>"+value['all_category']+"</span>"+
                                                "<div class='product_cg_num'><input class='form-control' type='number' value='0' min='0' keyword='"+value['keyword']+"'  max='"+maxnum+"' name='bid_num' ></div>"+
                                            "</div>"+
                                        "</div>"+
                                    "</li>"+
                                "</ul>"+
                            "</div>");
                        }
                    });
                }else{
                    $( "#bid_live_box" ).append('<P>尚無拍賣商品，請至拍賣商品中點選新增拍賣商品。</P>') 
                }
                $.LoadingOverlay("hide");
            },
            error: function(XMLHttpRequest, status, error) {
                // console.log(XMLHttpRequest.responseText);
            }
        });
    }

    //新增商品屬性欄位
    function addEvent(){
        var children_node = $("#addCategory div").length;
        if (children_node < 8) {
            $("#error_text").removeClass().addClass('text-danger d-none');

            $("#addCategory>div:nth-child(1)").attr("required", true);
            $("#addCategory>div:nth-child(1)").after('<div class="mb-2">\
            <input type="text" name="product_category[]" class="form-control mr-4 w-25 d-inline-block category"\
                placeholder="請輸入商品規格 ..." required>\
            <input type="number" name="product_price[]" class="form-control mr-4 w-25 d-inline-block price"\
            min="0" value="0" required>\
            <input type="number" name="product_num[]" class="form-control mr-4 w-25 d-inline-block stock"\
            min="0" value="0" required>\
            <i class="fas fa-times-circle text-danger cancel_add_goods"  onclick="cancelProduct(this)"></i>\
            </div>' );
        } else {
            $("#error_text").removeClass().addClass('text-danger');
        }
    }    


    //手動得標新增商品
    function manually_awarded_add(messageid,psid){
        var bid_list = [];
        $('input[name="bid_num"]').each(function(){
            if($(this).val()!=0){
                bid_list.push({'keyword':$(this).attr('keyword'),'num':$(this).val()})
            }
        });
        $.ajax({
            url: '/manually_awarded',
            type: 'POST',
            data: { page_id:'{{$page_id}}',live_video_id:'{{$live_video_id}}',page_token:'{{$token}}',bid_list:bid_list,messageid:messageid,psid:psid,_token:CSRF_TOKEN},
            dataType: 'JSON',
            success: function (data) {
                alertify.success('成功幫買家新增商品！');
            },
            error: function(XMLHttpRequest, status, error) {
                // console.log(error);
                // console.log(XMLHttpRequest.status);
                // console.log(XMLHttpRequest.responseText);
            }
        });
        $('#manually_awarded').modal('toggle');
    }

    //顯示直播商品
    function show_auction_product(){
        $.LoadingOverlay("show");
        $.ajax({
            url: '/show_product',
            type: 'POST',
            data: { page_id:'{{$page_id}}',live_video_id:'{{$live_video_id}}',page_token:'{{$token}}',_token:CSRF_TOKEN},
            dataType: 'JSON',
            success: function (data) {
                    $("#auction_list").children().remove();
                    $.each(data, function( index, value ) {
                        if(value['index'] == 1)
                        {
                            if(value['diverse']>1){
                                $( "#auction_list" ).append(
                                "<div class='media bg-white  live_bor' data='"+value['goods_name']+"'>"+
                                    "<div class='live_QB'>"+
                                        "<div class='QB_get over-text'>得標數</div>"+
                                        "<div class='QB_get_N' id='"+value['keyword']+"'>"+value['bid_times']+"</div>"+
                                        "<div class='QB_Q over-text'>庫存數</div>"+
                                        "<div class='QB_Q_N' id='"+value['keyword']+"2'>"+value['goods_num']+"</div>"+
                                        "<div class='live_line'></div>"+
                                    "</div>"+
                                    "<img class='d-flex mr-3 rounded live_goods' src='"+value['pic_url']+"' style='margin-left: 5px;'>"+
                                    "<div class='media-body'>"+
                                        "<div class='mt-0 pt-2 product_name over-text'><span class='over-text' style='max-width:15rem;display:initial;width:auto'>"+value['goods_name']+"<span>"+
                                            "<div class='product_edit'><i class='fas fa-edit' data-dismiss='modal' data-toggle='modal' goodskey='"+value['goods_key']+"' product_id='"+value['product_id']+"' onclick='EditProductShow(this)'  data-target='#editProduct'  style='position: absolute;top: 15px;'></i></div>"+
                                            "<div class='product_KW'>關鍵字&nbsp;:&nbsp;<div class='product_Key'>&nbsp;"+value['keyword']+"&nbsp;</div></div>"+
                                            "<div class='re_goods'><i class='fas fa-times pt-3' onclick='delete_product("+'"'+value['goods_key']+'"'+")' ></i></div>"+
                                        "</div>"+
                                        "<div class='h6'><span class='badge badge-warning product_M'>NT$ "+value['goods_price']+"</span>"+ 
                                            "<div class='op_goods' data-toggle='collapse' data-target='."+value['goods_key']+"' aria-expanded='false' aria-controls='"+value['goods_key']+"'>"+
                                                "<span class='product_S float-left over-text' style='max-width:150px'>"+value['all_category']+"</span>"+
                                                "<div class='op_goods_i float-right'><i class='fas fa-sort-down'></i></div>"+
                                            "</div>"+
                                            "<div class='share_goods'><i class='fas fa-share' data-toggle='tooltip' data-placement='top' title='分享商品資訊至聊天室'"+
                                                "onclick='share_product("+'"'+value['goods_key']+'"'+")' ></i></div>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>");
                            }else{
                                $( "#auction_list" ).append(
                                "<div class='media bg-white  live_bor' data='"+value['goods_name']+"'>"+
                                    "<div class='live_QB'>"+
                                        "<div class='QB_get over-text'>得標數</div>"+
                                        "<div class='QB_get_N' id='"+value['keyword']+"'>"+value['bid_times']+"</div>"+
                                        "<div class='QB_Q over-text'>庫存數</div>"+
                                        "<div class='QB_Q_N' id='"+value['keyword']+"2'>"+value['goods_num']+"</div>"+
                                        "<div class='live_line'></div>"+
                                    "</div>"+
                                    "<img class='d-flex mr-3 rounded live_goods' src='"+value['pic_url']+"' style='margin-left: 5px;'>"+
                                    "<div class='media-body'>"+
                                        "<div class='mt-0 pt-2 product_name over-text'><span class='over-text' style='max-width:15rem;display:initial;width:auto'>"+value['goods_name']+"<span>"+
                                            "<div class='product_edit'><i class='fas fa-edit' data-dismiss='modal' data-toggle='modal' goodskey='"+value['goods_key']+"' product_id='"+value['product_id']+"' onclick='EditProductShow(this)'  data-target='#editProduct'  style='position: absolute;top: 15px;'></i></div>"+
                                            "<div class='product_KW'>關鍵字&nbsp;:&nbsp;<div class='product_Key'>&nbsp;"+value['keyword']+"&nbsp;</div></div>"+
                                            "<div class='re_goods'><i class='fas fa-times pt-3' onclick='delete_product("+'"'+value['goods_key']+'"'+")' ></i></div>"+
                                        "</div>"+
                                        "<div class='h6'>"+
                                            "<span class='badge badge-warning product_M'>NT$ "+value['goods_price']+"</span>"+ 
                                            "<span class='product_S float-left over-text' style='max-width:150px'>"+value['all_category']+"</span>"+
                                            "<div class='share_goods'><i class='fas fa-share' data-toggle='tooltip' data-placement='top' title='分享商品資訊至聊天室' onclick='share_product("+'"'+value['goods_key']+'"'+")' ></i></div>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>");
                            }

                        }
                        else
                        {
                            $( "#auction_list" ).append("<div class='card collapse "+value['goods_key']+"' style='margin-left: 30px;'>"+
                                "<ul class='list-group list-group-flush '>"+
                                    "<li class='list-group-item d-flex justify-content-between align-items-center' style='padding:5px;'>"+
                                        "<div class='live_QB'>"+
                                            "<div class='QB_get over-text'>得標數</div>"+
                                            "<div class='QB_get_N' id='"+value['keyword']+"'>"+value['bid_times']+"</div>"+
                                            "<div class='QB_Q over-text'>庫存數</div>"+
                                            "<div class='QB_Q_N' id='"+value['keyword']+"2'>"+value['goods_num']+"</div>"+
                                            "<div class='live_line'></div>"+
                                        "</div>"+
                                        "<img class='d-flex mr-3 rounded live_goods' src='"+value['pic_url']+"' style='margin-left: 5px;'>"+
                                        "<div class='media-body ' style='padding:5 '>"+
                                            "<div class='mt-0 pt-2 product_name over-text'><span class='over-text' style='max-width:15rem;display:initial;width:auto'>"+value['goods_name']+"<span>"+
                                                "<div class='product_edit'><i class='fas fa-edit' data-dismiss='modal' data-toggle='modal' goodskey='"+value['goods_key']+"' product_id='"+value['product_id']+"' onclick='EditProductShow(this)'  data-target='#editProduct'  style='position: absolute;top: 15px;'></i></div>"+
                                                "<div class='product_KW'>關鍵字&nbsp;:&nbsp;<div class='product_Key'>&nbsp;"+value['keyword']+"&nbsp;</div></div>"+
                                                "<div class='re_goods'><i class='fas fa-times pt-3' onclick='delete_product("+'"'+value['goods_key']+'"'+")'></i></div>"+
                                            "</div>"+
                                            "<div class='h6'>"+
                                                "<span class='badge badge-warning product_M'>NT$ "+value['goods_price']+"</span>"+
                                                "<span class='product_S float-left over-text' style='max-width:150px'>"+value['all_category']+"</span>"+
                                                "<div class='share_goods'><i class='fas fa-share' data-toggle='tooltip' data-placement='top' title='分享商品資訊至聊天室'  onclick='share_product("+'"'+value['goods_key']+'"'+")'></i></div>"+
                                            "</div>"+
                                        "</div>"+
                                    "</li>"+
                                "</ul>"+
                            "</div>");
                        }
                    });
                    $.LoadingOverlay("hide");
            },
            error: function(XMLHttpRequest, status, error) {
                console.log(XMLHttpRequest.responseText);
            }
        });
    }

    //刪除直播商品
    function delete_product(goods_key){
        $.LoadingOverlay("show");
        $.ajax({
            url: '/delete_auction',
            type: 'POST',
            data: { page_id:'{{$page_id}}',live_video_id:'{{$live_video_id}}',page_token:'{{$token}}',goods_key:goods_key,_token:CSRF_TOKEN},
            dataType: 'text',
            success: function (data) {
                alertify.success('已將商品從直播拍賣清單中移除！');
                show_auction_product();
                $.LoadingOverlay("hide");
            },
            error: function(XMLHttpRequest, status, error) {
                // console.log(error);
                // console.log(XMLHttpRequest.status);
                // console.log(XMLHttpRequest.responseText);
            }
        });
    }

    //更新銷售數量
    function update_aution_sales(){
        $.ajax({
            /* the route pointing to the post function */
            url: '/update_product',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {page_id:'{{$page_id}}',live_video_id:'{{$live_video_id}}',_token:CSRF_TOKEN},
            dataType: 'json',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                
                $.each(data, function(index,value) {
                    // console.log(value);
                    // console.log(value.keyword);
                    // console.log(value['bid_times']);
                    $("#"+value['keyword']).html(value['bid_times']);
                    $("#"+value['keyword']+"2").html(value['stock_num']);
                });
            },
            error: function(XMLHttpRequest, status, error) {
                // console.log(XMLHttpRequest.responseText);
            }
        });
    }

    //貼文留言
    function enter_event(event) {
        
        var x = event.which || event.keyCode;
        if(x==13)
        {
            var comment_message = $("#facebook_message").val();
            send_comment(comment_message);
        }
    }

    //傳送訊息到FB直播中
    function send_comment(comment_message){
        var CSRF_TOKEN= $('meta[name="csrf-token"]').attr('content');
        var comment = (comment_message == '') ? $("#facebook_message").val() : comment_message ;
        if(comment!='')
        {
            $("#facebook_message").val("");
            $.ajax({
                /* the route pointing to the post function */
                url: '/send_comment',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {comment:comment,video_id:'{{$video_id}}',page_token:'{{$token}}',_token:CSRF_TOKEN},
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                },
                error: function(XMLHttpRequest, status, error) {
                    // console.log(XMLHttpRequest.responseText);
                }
            });
        }
    }

    //挑選商品
    function refresh_drp_product(){
        $.LoadingOverlay("show");
        $("#streamingproduct").children().remove();
        $("#streamingproduct").append('<input class="form-control mb-4 br-10 row_inp_style" id="SearchProudct" onkeyup="SearchProudct(this)" type="text" placeholder="Search..">');

        $.ajax({
            /* the route pointing to the post function */
            url: '/refresh_drp_product',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {page_id:'{{$page_id}}',live_video_id:'{{$live_video_id}}',_token:CSRF_TOKEN},
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
                var counter = 1;
                    $.each(data, function( index, value ) {
                        var categorys= "";
                        var len = Object.keys(value).length;
                        $.each(data[index], function( x, query){               
                            if (query['index']==len) {
                                categorys= categorys+query['goods_category'];
                                if(categorys.includes("、")){
                                    $("#streamingproduct").append(
                                    '<ul class="list-group pi_ul p-1" data="'+query['goods_name']+'" id="Compliance" > \
                                        <label for="goods_'+query['goods_key']+'" class=""  style="width: 100%;">\
                                            <li class="list-group-item d-flex  align-items-center gi_li" style="cursor: pointer;">\
                                                <div style="height:4.5rem;width:4.5rem;background: url('+query['pic_url']+') no-repeat center;background-size: 100% auto;background-position: center center;"></div>\
                                                    <span class="pi_w pr-4 over-text">\
                                                        '+query['goods_name']+'&nbsp;&nbsp;<small>（'+categorys+'）</small>'+'\
                                                    </span>\
                                                <span class="or_ck_label" >\
                                                    <input id="goods_'+query['goods_key']+'"  value="'+index+'"  name="selected_product" type="checkbox"  class="chkbox" />\
                                                    <label  for="goods_'+query['goods_key']+'" ></label>\
                                                </span>\
                                            </li>\
                                        </label>\
                                    </ul>'
                                    )
                                }else{
                                    $("#streamingproduct").append(
                                    '<ul class="list-group pi_ul p-1" data="'+query['goods_name']+'" id="Compliance" > \
                                        <label for="goods_'+query['goods_key']+'" class=""  style="width: 100%;">\
                                            <li class="list-group-item d-flex  align-items-center gi_li" style="cursor: pointer;">\
                                                <div style="height:4.5rem;width:4.5rem;background: url('+query['pic_url']+') no-repeat center;background-size: 100% auto;background-position: center center;"></div>\
                                                <span class="pi_w pr-4 over-text">\
                                                    '+query['goods_name']+'&nbsp;&nbsp;<small>'+categorys+'</small>'+'\
                                                </span>\
                                                <span class="or_ck_label" >\
                                                    <input id="goods_'+query['goods_key']+'"  value="'+index+'"  name="selected_product" type="checkbox"  class="chkbox" />\
                                                    <label  for="goods_'+query['goods_key']+'" ></label>\
                                                </span>\
                                            </li>\
                                        </label>\
                                    </ul>'
                                    )
                                }
                            }else{
                                categorys= categorys+query['goods_category']+"、";
                            }
                            
                        });
                        counter++;
                    });
                $.LoadingOverlay("hide");
            },
            error: function(XMLHttpRequest, status, error) {
                // console.log(XMLHttpRequest.responseText);
            }
        });
    }
    
    //發送商品資訊到聊天室
    function share_product(goods_key){
        $.ajax({
            /* the route pointing to the post function */
            url: '/share_product',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {page_id:'{{$page_id}}',live_video_id:'{{$live_video_id}}',goods_key:goods_key,_token:CSRF_TOKEN},
            dataType: 'text',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {

                if(data=="%0A%0A"){
                    alertify.error('商品已售完，無須再次推廣！');
                }else{
                    send_comment(data);
                }
                
            },
            error: function(XMLHttpRequest, status, error) {
                // console.log(XMLHttpRequest.responseText);
            }
        });
    }

    function top_five(){
        $.LoadingOverlay("show");
        $.ajax({
                /* the route pointing to the post function */
                url: '/TopFiveShoper',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {page_id:'{{$page_id}}',live_video_id:'{{$live_video_id}}',_token:CSRF_TOKEN},
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    $("#msg_empty_sales").html("");
                    if(data!=""){
                        $(".TF_L").children().remove();
                        $(".TF_RT").children().remove();
                        $('#TF_line').removeClass().addClass('TF_line');
                        $.each(data, function( index, value ) {
                            if(index==0){
                                $(".TF_L").append(
                                        '<div class="top_no1_C"><img src="img/crown.png" alt="crown"></div>\
                                        <!-- 第一名 -->\
                                        <div class="pho_b">\
                                            <img src="https://graph.facebook.com/'+value['ps_id']+'/picture?type=large&access_token={{$token}}" alt="photo">\
                                        </div>\
                                        <span class="repo_top">No.1</span>&nbsp;<span class="repo_name over-text" style="display: list-item!important;">'+value['fb_name']+'</span> \
                                        <span class="repo_m currencyField">'+value['total']+'</span>\
                                        <!-- 第一名結尾 -->');
                            }
                            else if(index>0 && index<5){
                                $(".TF_RT").append(
                                    '<div class="repo_box repo_box_2">\
                                        <div class="pho_b">\
                                            <img src="https://graph.facebook.com/'+value['ps_id']+'/picture?type=large&access_token={{$token}}" alt="photo">\
                                        </div>\
                                        <span class="repo_top repo_top5">No.'+(index+1)+'</span>&nbsp;<span class="repo_name over-text repo_name5" style="display: list-item!important;">'+value['fb_name']+'</span>\
                                        <span class="repo_m repo_m5 currencyField">'+value['total']+'</span>\
                                    </div>'
                                );
                            }
                            else{
                                $(".TF_R").append(
                                    '<div class="repo_box repo_box_2">\
                                        <div class="pho_b">\
                                            <img src="https://graph.facebook.com/'+value['ps_id']+'/picture?type=large&access_token={{$token}}" alt="photo">\
                                        </div>\
                                            <span class="repo_top repo_top6">No.'+(index+1)+'</span>&nbsp;<span class="repo_name over-text repo_name6" style="display: list-item!important;">'+value['fb_name']+'</span>\
                                            <span class="repo_m repo_m6 currencyField">'+value['total']+'</span>\
                                    </div>'
                                )
                            }
                        });
                    }else{
                        $('#TF_line').addClass('d-none')
                        $("#msg_empty_sales").append('尚無買家購買資料。');
                    }
                    $('.currencyField').formatCurrency();
                    $.LoadingOverlay("hide");
                },
                error: function(XMLHttpRequest, status, error) {
                    // $(".emojionearea-editor").html("");
                    // alert(error);
                    // alert(XMLHttpRequest.status);
                    // console.log(XMLHttpRequest.responseText);
                }
            });
    }
    //銷售清單
    function commodity_sales_list(){
        $.LoadingOverlay("show");
        $.ajax({
                /* the route pointing to the post function */
                url: '/CommoditySalesList',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {page_id:'{{$page_id}}',live_video_id:'{{$live_video_id}}',_token:CSRF_TOKEN},
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    $("#SalesList").html("");
                    if(data!=""){
                        $.each(data, function( index, value ) {
                            if(index==0){
                                $("#SalesList").append(
                                    '<div class="media sales_box"><!-- 一個商品開始 -->\
                                        <div class="sales_top_box">1\
                                            <div class="sales_top_i"><i class="fas fa-caret-up" style="color:#2fc36d"></i></div>\
                                            <img src="img/crown.png" alt="crown" class="sales_no1_C">\
                                        </div>\
                                        <div class="sales_photo"><img src="'+value['pic_url']+'" alt="photo"></div>\
                                        <div class="sales_w_box">\
                                            <span class="sales_T">'+value['goods_name']+'&nbsp;<small>（'+value['category']+'）</small></span><br>\
                                            <span class="sales_w">預計總銷售額&nbsp;:&nbsp;<span class="currencyField">'+value['total']+'</span>&nbsp;&nbsp;&nbsp;預計銷售數量&nbsp;:&nbsp;'+value['bid_time']+'</span>\
                                        </div>\
                                    </div><!-- 一個商品結尾 -->'
                                )
                            }else if(index==1){
                                $("#SalesList").append(
                                    '<div class="media sales_box"><!-- 一個商品開始 -->\
                                        <div class="sales_top_box">2\
                                            <div class="sales_top_i"><i class="fas fa-sort-down" style="color:#e22835"></i></div>\
                                            <img src="img/crown.png" alt="crown" class="sales_no1_C">\
                                        </div>\
                                        <div class="sales_photo"><img src="'+value['pic_url']+'" alt="photo"></div>\
                                        <div class="sales_w_box">\
                                            <span class="sales_T">'+value['goods_name']+'&nbsp;<small>（'+value['category']+'）</small></span><br>\
                                            <span class="sales_w">預計總銷售額&nbsp;:&nbsp;<span class="currencyField">'+value['total']+'</span>&nbsp;&nbsp;&nbsp;預計銷售數量&nbsp;:&nbsp;'+value['bid_time']+'</span>\
                                        </div>\
                                    </div><!-- 一個商品結尾 -->'
                                )
                            }else if(index==2){
                                $("#SalesList").append(
                                    '<div class="media sales_box"><!-- 一個商品開始 -->\
                                        <div class="sales_top_box">3\
                                            <div class="sales_top_i"><i class="fas fa-minus" style="color:#9f9d9e;font-size:50%"></i></div>\
                                            <img src="img/crown.png" alt="crown" class="sales_no1_C">\
                                        </div>\
                                        <div class="sales_photo"><img src="'+value['pic_url']+'" alt="photo"></div>\
                                        <div class="sales_w_box">\
                                            <span class="sales_T">'+value['goods_name']+'&nbsp;<small>（'+value['category']+'）</small></span><br>\
                                            <span class="sales_w">預計總銷售額&nbsp;:&nbsp;<span class="currencyField">'+value['total']+'</span>&nbsp;&nbsp;&nbsp;預計銷售數量&nbsp;:&nbsp;'+value['bid_time']+'</span>\
                                        </div>\
                                    </div><!-- 一個商品結尾 -->'
                                )
                            }else{
                                $("#SalesList").append(
                                    '<div class="media sales_box"><!-- 一個商品開始 -->\
                                        <div class="sales_top_box">'+(index+1)+'\
                                            <div class="sales_top_i"><i class="fas fa-minus" style="color:#9f9d9e;font-size:50%"></i></div>\
                                            <img src="img/crown.png" alt="crown" class="sales_no1_C">\
                                        </div>\
                                        <div class="sales_photo"><img src="'+value['pic_url']+'" alt="photo"></div>\
                                        <div class="sales_w_box">\
                                            <span class="sales_T">'+value['goods_name']+'&nbsp;<small>（'+value['category']+'）</small></span><br>\
                                            <span class="sales_w">預計總銷售額&nbsp;:&nbsp;<span class="currencyField">'+value['total']+'</span>&nbsp;&nbsp;&nbsp;預計銷售數量&nbsp;:&nbsp;'+value['bid_time']+'</span>\
                                        </div>\
                                    </div><!-- 一個商品結尾 -->'
                                )
                            }
                        });
                    }else{
                        $("#SalesList").append("尚未賣出商品。");
                    }
                    $('.currencyField').formatCurrency();
                    $.LoadingOverlay("hide");
                },
                error: function(XMLHttpRequest, status, error) {
                    // $(".emojionearea-editor").html("");
                    // alert(error);
                    // alert(XMLHttpRequest.status);
                    // console.log(XMLHttpRequest.responseText);
                }
            });
    }

    function getShop_threedays_customer(){
        $.LoadingOverlay("show");
        $.ajax({
                /* the route pointing to the post function */
                url: '/GetShopThreeDaysCustomer',
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {page_id:'{{$page_id}}',_token:CSRF_TOKEN},
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    $("#Repo").html("");
                    if(data!=""){
                        $.each(data, function( index, value ) {
                            $("#Repo").append(
                                '<div class="repo_box ">'+
                                    '<div class="pho_b">'+
                                        '<img src="https://graph.facebook.com/'+value['ps_id']+'/picture?type=large&access_token={{$token}}" alt="'+value['fb_name']+'">'+
                                    '</div>'+
                                    '<span class="repo_name over-text" style="display: list-item!important;">'+value['fb_name']+'</span>'+
                                '</div>'
                            );
                        });
                    }else{
                        $("#Repo").append("尚無購買資料！");
                    }


                },
                error: function(XMLHttpRequest, status, error) {
                    // $(".emojionearea-editor").html("");
                    // alert(error);
                    // alert(XMLHttpRequest.status);
                    // console.log(XMLHttpRequest.responseText);
                }
            });
        $.LoadingOverlay("hide");
    }



    function clear_img( modal_id , input_id , div_id){
        $("#"+input_id+" input").val("");
        $("#"+input_id).removeClass("d-none");
        $("#"+div_id).removeClass().css("background-image", "");
        $("#"+modal_id).modal('hide'); 

        if( modal_id=='lottery'){
            $("#prize_name").val("");
            $("#prize_keyword").val("");
            $("#prize_num").val(0);
        }
    }

    function editEvent(){
        var children_node = $("#editCategory div").length;
        if (children_node < 8) {
            $("#error_text_edit").removeClass().addClass('text-danger d-none');


            $("#editCategory").append('<div class="mb-2">\
            <input type="text" name="edit_category[]" class="form-control mr-4 w-25 d-inline-block category br-10 row_inp_style"\
                placeholder="請輸入商品規格 ..." required>\
            <input type="number" name="edit_price[]" class="form-control mr-4 w-25 d-inline-block price br-10 row_inp_style"\
            min="0" value="0" required>\
            <input type="number" name="edit_num[]" class="form-control mr-4 w-25 d-inline-block stock br-10 row_inp_style"\
            min="0" value="0" required>\
            <input type="hidden" name="product_id[]"\
                                value="add">\
            <i class="fas fa-times-circle text-danger cancel_add_goods"  onclick="cancelProduct(this)"></i>\
            </div>' );
        } else {
            $("#error_text_edit").removeClass().addClass('text-danger');
        }
    }
</script>
@stop
<style>
    .right_bottom{
        position:fixed;
        z-index: 200000;
        right: 2.8rem;
        bottom: 2.2rem;
        background-color: #009944;
        width: 3.5rem;
        height: 3.5rem;
        padding: 0.5rem;
        opacity: 0.8;
    }
    .right_bottom:hover {
        opacity: 1 !important;
    }


    .right_bottom img:hover {
        animation: shake 0.82s cubic-bezier(.36,.07,.19,.97) both;
        transform: translate3d(0, 0, 0);
        backface-visibility: hidden;
        perspective: 1000px;
    }

    @keyframes shake {
        10%, 90% {
            transform: translate3d(-1px, 0, 0);
        }
        
        20%, 80% {
            transform: translate3d(2px, 0, 0);
        }

        30%, 50%, 70% {  
            transform: translate3d(-4px, 0, 0);
        }

        40%, 60% {
            transform: translate3d(4px, 0, 0);
        }
    }
</style>
@section('wrapper')
    <div class="wrapper">
        @stop
        @section('navbar')
        <div id="content">
        @stop
        @section('content')
            <div class="row">
                <div class="col-md-12 col-lg-6 col-md-6_L">
                    <div class="row row_1">
                            @if( $device=="computer")
                                <div class="col-md-12 col-sm-12 live_video" id="live_video" >
                                    <iframe
                                    src="{!! $url !!}"
                                    width="95%" height="310px" style="border:none;overflow:hidden;position: absolute;" scrolling="no"
                                    frameborder="0" allowTransparency="true" allowFullScreen="true"></iframe>
                                </div>
                            @else
                                <div class="col-md-12 col-sm-12 live_video" style="padding-left:37.5%" id="live_video" >
                                    <iframe
                                    src="{!! $url !!}"
                                    width="25%" height="310px"  style="border:none;overflow:hidden;position: absolute" scrolling="no"
                                    frameborder="0" allowTransparency="true" allowFullScreen="true"></iframe>
                                </div>
                            @endif
                        
                        <div class="col-md-12 col-sm-12 al_btn" id="button_panel">
                            <span data-toggle="modal" data-target="#lottery">
                                <button type="button" class="btn btn-secondary mb-3 btn_4 over-text" data-toggle="tooltip"
                                data-placement="top" title="小提示：請買家留言抽獎關鍵字後再新增"><i class="fa fa-gift"></i>&nbsp;
                                    新增抽獎</button>
                            </span>
                            <span data-toggle="modal" data-target="#addProduct">
                                <button type="button" class="btn btn-secondary mb-3 btn_4 over-text" data-toggle="tooltip"
                                data-placement="top" title="新增後台商品，新增成功後會直接挑選至此直播拍賣清單中。" ><i class="fas fa-plus-circle"></i>&nbsp;後臺商品</button>
                            </span>
                            <span data-toggle="modal"  data-target="#addStreamingProduct" >
                                <button type="button" id="btn_product" data-toggle="tooltip" data-placement="top" title="挑選商品至直播拍賣清單中。" class="btn btn-secondary mb-3 btn_4 over-text" onclick="refresh_drp_product();"><i class="fas fa-check-circle"></i>&nbsp;拍賣商品</button>
                            </span>
                            <span>
                                <button type="button" class="btn btn-secondary mb-3 btn_4 over-text" data-toggle="modal"
                                data-target="#Sales" onclick="getShop_threedays_customer()"><i class="fas fa-eye"></i>&nbsp;查看賣況</button>
                            </span>
                        </div>
                    </div>



                    <div class="row pt-2 ">
                        <ul class="list-group w-100 live_row" id="live_shop" style="min-height: 400px;">
                            <li class="list-group-item d-flex justify-content-between align-items-center  live_li live_top" style="background-color: #eeeeee;">
                                <span style="font-size: 18px;"><i class="fa fa-gavel fa-flip-horizontal mr-2"></i>直播拍賣商品</span>
                                <div><i class="fas fa-search pt-1"></i><input id="auction_search" onkeyup="AuctionSearch(this)" type="text" placeholder="商品關鍵字查詢"
                                    aria-label="Search"></div>
                                
                            </li>

                        <div class="live_box" id="auction_list">
                        @if($auction_list)
                        @foreach($auction_list as $list)
                            @if( $list['index']==1)
                                <div class="media bg-white  live_bor" data="{{ $list['goods_name'] }}"><!-- 一個商品開始 -->
                                        <div class="live_QB">
                                            <div class="QB_get over-text">得標數</div>
                                            <div class="QB_get_N" id="{{ $list['keyword'] }}">{{ $list['bid_times'] }}</div>
                                            <div class="QB_Q over-text">庫存數</div>
                                            <div class="QB_Q_N" id="{{ $list['keyword'] }}2">{{ $list['goods_num'] }}</div>
                                            <div class="live_line"></div>
                                        </div>
                                    <img class="d-flex mr-3 rounded live_goods" src="{{ $list['pic_url'] }}" style="margin-left: 5px;">
                                    
                                    
                                    <div class="media-body">
                                        <div class="mt-0 pt-2 product_name over-text"><span class='over-text' style='max-width:15rem;display:inherit;width:auto'>{{ $list['goods_name'] }}</span>
                                            <div class="product_edit"><i class="fas fa-edit" product_id="{{ $list['product_id'] }}" data-dismiss='modal' data-toggle='modal' goodskey='{{ $list['goods_key'] }}' product_id='{{ $list['product_id'] }}' onclick='EditProductShow(this)'  data-target='#editProduct'  style="position: absolute;top: 15px;'"></i></div> 
                                            <div class="product_KW">關鍵字&nbsp;:&nbsp;<div class="product_Key">&nbsp;{{ $list['keyword'] }}&nbsp;</div></div>
                                            <div class="re_goods"><i class="fas fa-times pt-3" onclick="delete_product('{{ $list['goods_key'] }}')"></i></div>
                                        </div>
                                        
                                        <div class="h6"><span class="badge badge-warning product_M" style="margin-right: 5px">NT$ {{ $list['goods_price'] }}</span>  
                                            @if($list['diverse']>1)                                     
                                                <div class="op_goods" data-toggle="collapse" data-target=".{{ $list['goods_key'] }}" aria-expanded="false">
                                                    <span class="product_S float-left over-text over-text" style='max-width:150px'>
                                                        {!! $list['all_category'] !!}
                                                    </span>
                                                    <div class="op_goods_i float-right"><i class="fas fa-sort-down"></i></div>
                                                </div> 
                                            @else
                                                <span class="product_S float-left over-text over-text" style='max-width:150px'>
                                                    {!! $list['all_category'] !!}
                                                </span>
                                            @endif                                    
                                            <div class="share_goods"><i class="fas fa-share" data-toggle='tooltip' data-placement='top' title='分享商品資訊至聊天室' onclick="share_product('{{ $list['goods_key'] }}')"></i></div>
                                        </div>
                                    </div>
                                    
                                </div><!-- 一個商品結尾 -->
                            @else
                                <div class="card collapse {{ $list['goods_key'] }}"  style="margin-left: 30px;">
                                    <ul class="list-group list-group-flush ">
                                        <li class="list-group-item d-flex justify-content-between align-items-center "
                                            style="padding:5px;">

                                            <div class="live_QB">
                                                <div class="QB_get over-text">得標數</div>
                                                <div class="QB_get_N" id="{{ $list['keyword'] }}">{{ $list['bid_times'] }}</div>
                                                <div class="QB_Q over-text">庫存數</div>
                                                <div class="QB_Q_N" >{{ $list['goods_num'] }}</div>
                                                <div class="live_line"></div>
                                            </div>
                                            <img class="d-flex mr-3 rounded live_goods" src="{{ $list['pic_url'] }}"
                                                style="margin-left: 5px;">

                                            <div class="media-body " style="padding:5 ">
                                                <div class="mt-0 pt-2 product_name"><span class='over-text' style='max-width:15rem;display:inherit;'>{{ $list['goods_name'] }}</span>
                                                    <div class="product_edit"><i class="fas fa-edit" data-dismiss='modal' data-toggle='modal' product_id='{{ $list['product_id'] }}' goodskey='{{ $list['goods_key'] }}' product_id='{{ $list['product_id'] }}' onclick='EditProductShow(this)'
                                                            style="position: absolute;top: 15px;"></i></div>
                                                    <div class="product_KW">關鍵字&nbsp;:&nbsp;<div class="product_Key">
                                                            &nbsp;{{ $list['keyword'] }}&nbsp;</div>
                                                    </div>
                                                    <div class="re_goods"><i class="fas fa-times pt-3" onclick="delete_product('{{ $list['goods_key'] }}')"></i></div>
                                                </div>

                                                <div class="h6">
                                                    <span class="badge badge-warning product_M">NT {{ $list['goods_price'] }}</span>
                                                    <span class="product_S float-left over-text" style='max-width:150px'>
                                                        {!! $list['all_category'] !!}
                                                    </span>
                                                    <div class="share_goods"><i class="fas fa-share" data-toggle='tooltip' data-placement='top' title='分享商品資訊至聊天室' onclick="share_product('{{ $list['goods_key'] }}')"></i></div>
                                                </div>
                                            </div>

                                        </li>
                                    </ul>
                                </div>
                            @endif
                        @endforeach
                        @endif
                        </div>
                        </ul>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 col-md-6_R">
                    <div class="row_R position-relative">
                    <div class="al_sel">
                        <label for="radios1" class=" al_sel_1 al_sel_all" onclick="show_W()">
                            <input type="radio" name="sel" id="radios1" value="all" checked="true" style="display: none;">
                            <div class="fx_sel">
                                <div class="sel_ck_box"></div>
                                <div class="sel_ck_box sel_ck_box_all" ><img src="img/tick.png" alt="tick"  ></div>
                                <span class="sel_ck_box_w">全部</span>
                            </div>
                        </label>
                        <label for="radios2" class=" al_sel_1 al_sel_bk" onclick="show_W()">
                            <input type="radio" name="sel" id="radios2" onclick="comment_block(this)" value="bk" style="display: none;">
                            <div class="fx_sel">
                                <div class="sel_ck_box"></div>
                                <div class="sel_ck_box sel_ck_box_bk" style="display: none;"><img src="img/tick.png" alt="tick"  ></div>
                                <span class="sel_ck_box_w">隱藏封鎖用戶</span>
                            </div>
                        </label>
                        <label for="radios3" class=" al_sel_1 al_sel_mb" onclick="show_W()">
                            <input type="radio" name="sel" id="radios3" onclick="comment_block(this)" value="mb" style="display: none;">
                            <div class="fx_sel">
                                <div class="sel_ck_box"></div>
                                <div class="sel_ck_box sel_ck_box_mb" onclick="comment_block(this)" style="display: none;"><img src="img/tick.png" alt="tick"  ></div>
                                <span class="sel_ck_box_w">顯示會員留言</span>
                            </div>
                        </label>
                       
                        <div class="al_sel_2">
                            <div class="al_sel_max" onclick="al_sel_max()">
                                <i class="far fa-window-maximize" ></i>
                            </div>
                            <div class="al_sel_min" onclick="al_sel_min()" style="display: none;">
                                <i class="far fa-window-minimize" ></i>
                            </div>
                        </div>
                    </div>
                    <div class="list-group " id="facebook_comment">
                    </div>


                    <ul class="list-group position-absolute" style="bottom: 20px;width: calc(100% - 40px);">
                        <li class="list-group-item su_box">
                            <div class="input-group">
                                <img src="https://graph.facebook.com/ {!! $page_id !!}/picture"
                                    class="rounded-circle mr-4" width="38rem" height="38rem">
                                <input type="text" class="form-control inp_s" id="facebook_message" aria-label="" aria-describedby="basic-addon1"
                                    placeholder="請輸入留言 ..." onkeypress="enter_event(event)">
                                <div class="input-group-append">
                                    <button type="button" onclick="send_comment('')"  class="su_btn btn_no btn_s btn" >
                                        送出
                                    </button>
                                </div>
                            </div>
                        </li>
                    </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- 新增抽獎 -->
    <div class="modal " id="lottery" tabindex="-1" role="dialog" aria-labelledby="lotteryLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role=" document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lotteryLabel">
                        <i class="fa fa-gift mr-1"></i>&nbsp;
                                新增抽獎
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="float-right w-75 pl-4" id="FormLuckyDraw" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                        <div class="form-group ">
                            <label for="">獎品名稱</label>
                            <input type="text" class="form-control br-10 row_inp_style" name="prize_name" id="prize_name" placeholder="請輸入獎品名稱 ..." required>
                        </div>
                        <div class="form-group ">
                            <label for="">抽獎關鍵字</label>
                            <input type="text" class="form-control br-10 row_inp_style" name="prize_keyword" id="prize_keyword" placeholder="請輸入抽獎關鍵字 ..." required>
                        </div>
                        <div class="form-group ">
                            <label for="">獎品數量</label>
                            <input type="number" class="form-control br-10 row_inp_style" name="prize_num" id="prize_num" value="0" min="0" required>
                        </div>
                        <input type="hidden" name="getprize_image" id="getprize_image">
                    </form>
                    <div id="prize_Input" class="w-25">
                        <input type="file" class="custom-file-input w-25" value="" id="prize_image" name="prize_image"
                            accept="image/*" >
                    </div>
                    <div id="blah_prize">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn_window btn_no" onclick="clear_img('lottery','prize_Input','blah_prize')" data-dismiss="modal">取消</button>
                    <input type="submit" class="btn btn-primary btn_window btn_next" id="prize_next" data-toggle="modal"
                        value="下一步">
                </div>
                
            </div>
        </div>
    </div>

    <!-- 新增商品區塊 -->
    <div class="modal " id="addProduct" tabindex="-1" role="dialog" aria-labelledby="addProductLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role=" document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductLabel"><i class="fas fa-plus-circle"></i>&nbsp;新增後臺商品</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                
                <div class="modal-body">
                    <form class="float-right w-75 pl-4" id="addProductContent" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group ">
                            <label for="GoodsName">商品名稱</label>
                            <input type="text" name="ProductName" class="form-control br-10 row_inp_style" id="GoodsName" placeholder="請輸入商品名稱 ..." required>
                        </div>
                        <div class="w-100">
                            <label class="w-25 mr-4">規格</label>
                            <label class="w-25 mr-4">價格</label>
                            <label class="w-25 mr-4">庫存</label>
                        </div>
                        <div class="w-100 " id="addCategory">
                            <div class="mb-2 br-10">
                                <input type="text" name="product_category[]" class="form-control mr-4 w-25 d-inline-block category br-10 row_inp_style"
                                    placeholder="請輸入商品規格 ...">
                                <input type="number" name="product_price[]" class="form-control mr-4 w-25 d-inline-block price br-10 row_inp_style" min="0"
                                    value="0" required>
                                <input type="number" name="product_num[]" class="form-control mr-4 w-25 d-inline-block stock br-10 row_inp_style" min="0"
                                    value="0" required>
                            </div>
                            <div id="addEvent" style="color:#0f7867;font-size: 18px;cursor: pointer;">
                                + 增加商品規格
                            </div>
                        </div>
                        <input type="hidden" id="getUpload_Input" name="getUpload_Input">
                    </form>
                    <div id="Upload_Img" class="w-25">
                        <input type="file" class="custom-file-input w-25" value="" id="Upload_Input" name="upload_image"
                            accept="image/*">
                    </div>
                    <div id="blah" class="w-25">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn_window btn_no" onclick="clear_addproduct()" >取消</button>
                    <input type="submit" id="btn_addproduct" class="btn btn-primary btn_window btn_next" style="background-color: #0f7867" value="完成">
                </div>
            </div>
            
        </div>
    </div>

    <div class="modal " id="addStreamingProduct" tabindex="-1" role="dialog" aria-labelledby="addStreamingProductLabel"
            aria-hidden="true">
        <div class="modal-dialog modal-lg" role=" document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">
                        <i class="fas fa-check-circle"></i>&nbsp; 挑選拍賣商品
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div class="tab-pane active show " id="streamingproduct">
                        <input class="form-control mb-4 br-10 row_inp_style" id="SearchProudct" type="text" placeholder="Search..">
                        {{-- 商品區塊 --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn_window btn_no" data-dismiss="modal" >取消</button>
                    <button type="button" id="select_product" class="btn btn-primary btn_window btn_next" style="background-color: #f1613f;">挑選完畢</button>
                </div>
            </div>
        </div>
    </div>


    <!-- 顯示符合中獎者區塊 -->
    <div class="modal " id="ComplianceList" tabindex="-1" role="dialog" aria-labelledby="SalestLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role=" document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductLabel">
                        <i class="fa fa-gift mr-1"></i>&nbsp; 新增抽獎
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div class="tab-pane active show show_2" id="luckydraw">
                        <input class="form-control mb-4 br-10 row_inp_style" id="SearchCompliance" type="text" placeholder="Search..">
                        {{-- 符合資格者區塊 --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn_window btn_no" data-dismiss="modal" data-toggle="modal"
                         data-target="#lottery">上一步</button>
                    <button type="button" id="btn_luckydraw" class="btn btn-primary btn_window btn_next" >完成</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal " id="editProduct" tabindex="-1" role="dialog" aria-labelledby="editProductLabel"
    aria-hidden="true">
        <div class="modal-dialog modal-lg" role=" document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductLabel"><i class="fas fa-plus-circle"></i>&nbsp;修改後臺商品</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="float-right w-75 pl-4" id="editProductContent">
                        <div class="form-group ">
                            <label for="GoodsName">商品名稱</label>
                            <input type="text" class="form-control br-10 row_inp_style" id="Goods_Name"
                                placeholder="請輸入商品名稱 ..." required>
                        </div>
                        <div class="w-100">
                            <label class="w-25 mr-4">規格</label>
                            <label class="w-25 mr-4">價格</label>
                            <label class="w-25 mr-4">庫存</label>
                        </div>
                        <div class="w-100 " id="editCategory">
                            <div id="editEvent" onclick="editEvent()" style="color:#0f7867;font-size: 18px;cursor: pointer;">
                                + 增加商品規格
                            </div>
                            <span id="error_text_edit" class="text-danger d-none">
                                (商品種類至多七種)
                            </span>
                        </div>
                    </form>
                    <div id="blah_edit" class="New_Img w-25">
                        <input type="file" class="custom-file-input" value="" id="Edit_Input" name="image"
                            accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn_window btn_no" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary btn_window btn_next" type="submit" id="btn_editproduct"  onclick="btn_editproduct()"
                        style="background-color: #0f7867">完成</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 查詢目前賣況區塊 -->
    <div class="modal " id="Sales" tabindex="-1" role="dialog" aria-labelledby="SalestLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role=" document">
            <div class="modal-content">
            <div class="modal-header">
                    <h5 class="modal-title" id="addProductLabel">
                        <i class="fas fa-eye"></i>&nbsp; 查看目前賣況
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
                <div class="m-2">
                    <ul class="nav nav-tabs">
                        <li class="nav-item " style="font-size: 17px;letter-spacing:2px;font-weight:bold;margin-left: 10px;"  >
                            <a class="nav-link active br-t-10" data-toggle="pill" href="#Repo">最近三天回訪名單</a>
                        </li>
                        <li class="nav-item" style="font-size: 17px;letter-spacing:2px;font-weight:bold" onclick="top_five()">
                            <a class="nav-link br-t-10" data-toggle="pill" href="#TopFive">本日購物前五狂</a>
                        </li>
                        <li class="nav-item" style="font-size: 17px;letter-spacing:2px;font-weight:bold">
                            <a class="nav-link br-t-10" data-toggle="pill" href="#SalesList" onclick="commodity_sales_list()">商品銷售榜</a>
                        </li>
                        <li class="nav-item ml-auto">
                            
                        </li>
                    </ul>
                </div>
                <div class="modal-body" style="max-height: 355px;overflow: auto;">
                    <div class="row-fluid">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="Repo"><!-- 最近三天回訪名單開始 -->
                                    {{-- 三天回頭客名單 --}}
                            </div><!-- 最近三天回訪名單結尾 -->
                            <div class="tab-pane" id="TopFive" ><!-- 本日購物前五狂開始 -->
                                <p id='msg_empty_sales'></p>
                                <div class=" TF_L ">
                                    {{-- 第一名區塊 --}}
                                </div>
                                <div class="TF_line" id="TF_line"></div>
                                <div class="TF_R ">
                                    <!-- 2-5名 -->
                                    <div class="TF_RT ">
                                        {{-- 2-5名區塊 --}}
                                    </div>
                                    <!-- 2-5名結尾 -->
                                    <!-- 第六名以後 -->
                                        {{-- 6名之後區塊 --}}
                                    <!-- 第六名以後結尾 -->
                                </div>
                            </div><!-- 本日購物前五狂結尾 -->
                            <div class="tab-pane" id="SalesList"><!-- 商品銷售榜開始 -->
                            </div><!-- 商品銷售榜結尾 -->
                            
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn_window btn_next" data-dismiss="modal" style="background-color: #e22835;">完成</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal " id="manually_awarded" tabindex="-1" role="dialog" aria-labelledby="manually_awardedLabel"
    aria-hidden="true">
        <div class="modal-dialog modal-lg" role=" document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="manually_awardedLabel"><i class="fas fa-plus-circle"></i>&nbsp;手動得標商品
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding-top: 0;">
                    <div class="row pt-2 ">
                        <ul class="list-group w-100 live_row" id="live_shop">
                            <li class="list-group-item d-flex justify-content-between align-items-center  live_li live_top"
                                style="background-color: #eeeeee;">
                                <span style="font-size: 18px;"><i
                                        class="fa fa-gavel fa-flip-horizontal mr-2"></i>直播拍賣商品</span>
                                <div><i class="fas fa-search pt-1"></i><input class="" type="text" placeholder="商品關鍵字查詢" onkeyup="ManuallySearch(this)"
                                        aria-label="Search"></div>
                            </li>
                            <div class="live_box" id="bid_live_box">
                            </div>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer" id="bid_footer">

                </div>
            </div>
        </div>
    </div>

    <div class="right_bottom rounded-circle shadow " onclick="location.href='{{ route('streaming_excel',['page_id'=>$page_id,'live_video_id'=>$live_video_id]) }}';"  data-toggle="tooltip"
    data-placement="top" title="點選下載得標者資料">
        <img src="img/ecxel.png" class="w-100">
    </div>
    
</div>
        @stop 
@section('footer')    

@stop