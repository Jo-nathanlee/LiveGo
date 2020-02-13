@extends('layouts.master')

@section('title','直播')

@section('head_extension')

@stop

@section('wrapper')
<div class="wrapper">
@stop
@section('navbar')
    <div id="content">
@stop
        @section('content')
            <div class="row " style="position: relative">
                <div class="container mt-4 mb-4">
                    <div id="order_detail_S1" class="stepwizard mt-4 container-fluid S1 mb-4">
                        <div class="S1_R1">
                            <span style="font-size: 1.5em;">訂單編號：&nbsp;尚未成立訂單</span>
                        </div>
                    </div>
                    <div class="progressbar-wrapper">
                        <ul class="progressbar">
                            <li class="active">待確定</li>
                            <li class="">待付款</li>
                            <li class="">待出貨</li>
                            <li class="">運送中</li>
                            <li class="">已完成</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-12 " style=" background-color: #c4c8cc26;">
                    <div class="card-deck p-4 ">
                        <div class="card rounded-lg" style=" border-color: #6c757d2d;border-width: medium;">
                            <div class="card-body">
                                <h3 class="card-title text-muted text-center">訂單資訊</h3>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    <hr style=" border-color: #6c757d2d;border-width: medium;">
                                </h6>
                                <p class="card-text font-weight-bold">訂單狀態 <span
                                        class="ml-2 badge badge-pill badge-danger" style="opacity: 0.7">待確定</span></p>
                                <p class="card-text font-weight-bold">訂購人&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="ml-2 badge badge-pill  badge-secondary" style="opacity: 0.6">
                                        <img src="https://graph.facebook.com/{{ $orders[0]->ps_id }}/picture?type=normal&access_token={{$token}}"
                                            class="rounded-circle mr-1" style="height:1.1rem">{{ $orders[0]->fb_name }}</span></p>
                                <p class="card-text font-weight-bold">訂購日期 <span
                                        class="ml-2 badge badge-pill  badge-secondary" style="opacity: 0.6"></span></p>
                            </div>
                        </div>
                        <div class="card rounded-lg" style=" border-color: #6c757d2d;border-width: medium;">
                            <div class="card-body">
                                <h3 class="card-title text-muted text-center">付款資訊</h3>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    <hr style=" border-color: #6c757d2d;border-width: medium;">
                                </h6>
                                <p class="card-text font-weight-bold">付款方式 <span
                                        class="ml-2 badge badge-pill badge-secondary" style="opacity: 0.6"></span></p>
                                <p class="card-text font-weight-bold">繳款金額<span
                                        class="ml-2 badge badge-pill  badge-secondary currencyField"  style="opacity: 0.6"></span></p>
                                <p class="card-text font-weight-bold">付款狀態 <span
                                        class="ml-2 badge badge-pill  badge-success" style="opacity: 0.6"></span></p>
                            </div>
                        </div>
                        <div class="card rounded-lg" style=" border-color: #6c757d2d;border-width: medium;">
                            <div class="card-body ">
                                <h3 class="card-title text-muted text-center">收件資訊</h3>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    <hr style=" border-color: #6c757d2d;border-width: medium;">
                                </h6>
                                <p class="card-text font-weight-bold">付款方式 <span
                                        class="ml-2 badge badge-pill badge-secondary" style="opacity: 0.6"></span></p>
                                <p class="card-text font-weight-bold">連絡電話 <span
                                        class="ml-2 badge badge-pill  badge-secondary" style="opacity: 0.6"></span></p>
                                <p class="card-text font-weight-bold">寄件地址 
                                    <span class="ml-2 badge badge-pill over-text badge-secondary " style="opacity: 0.6"></span>
                                </p>
                            </div>
                        </div>
                        <div class="card rounded-lg" style=" border-color: #6c757d2d;border-width: medium;">
                            <div class="card-body">
                                <h3 class="card-title text-muted text-center">出貨資訊</h3>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    <hr style=" border-color: #6c757d2d;border-width: medium;">
                                </h6>
                                <p class="card-text font-weight-bold">物流公司 
                                    <span class="ml-2 badge badge-pill  badge-secondary" style="opacity: 0.6"></span>
                                </p>
                                <p class="card-text font-weight-bold">出貨狀態 
                                    <span class="ml-2 badge badge-pill  badge-secondary" style="opacity: 0.6"></span>
                                </p>
                                <p class="card-text font-weight-bold">出貨日期 
                                    <span class="ml-2 badge badge-pill badge-secondary" style="opacity: 0.6"></span>
                                </p>
                                        
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row pt-4 pb-4" style=" background-color: #c4c8cc26;">
                <div class="col-md-12" style="max-height: 50vh;overflow-y: auto;overflow-x: hidden">
                    <table class="table" id="member_order_detail"  >
                        <thead>
                            <th>商品名稱</th>
                            <th>規格</th>
                            <th>售價</th>
                            <th>數量</th>
                            <th>小計</th>
                        </thead>
                        <tbody id="order_table">
                            @foreach($orders as $order)
                                <tr>
                                    <td><img class="product mr-2" src="{{$order->pic_url}}" >{{ $order->goods_name }}</td>
                                    <td>{{ $order->category}}</td>
                                    <td>{{ $order->bid_price }}</td>
                                    <td>{{ $order->bid_num }}</td>
                                    <td>{{ $order->bid_price * $order->bid_num }}
                                    <div class="d-flex float-right" style="flex-flow: row wrap;">
                                            <i class="fa fa-close" index="{{$order->id}}" onclick="deleteOrder(this)" ></i>
                                            <break></break>
                                            <i class="fa fa-edit" product_id="{{$order->product_id}}" index="{{$order->id}}"  data-target='#edit_product' data-toggle='modal' onclick='editproduct(this)' ></i>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr >
                                <td colspan="5" class="border-0 text-center">                                    
                                    <button style="border: none;background: none;color: #BABABA" psid="{{ $orders[0]->ps_id }}" data-target='#addproduct' data-toggle='modal' onclick='addproduct(this)'>
                                        <span style="color: #BABABA"><i class="fa fa-plus-circle"></i>&nbsp;點擊新增商品</span>
                                    </button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        @stop 
@section('footer')    
    <div class="modal " id="addproduct" tabindex="-1" role="dialog" aria-labelledby="addproduct_awardedLabel"
    aria-hidden="true">
        <div class="modal-dialog modal-lg" role=" document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addproduct_awardedLabel"><i class="fas fa-plus-circle"></i>&nbsp;新增商品
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
                                        class="fa fa-gavel fa-flip-horizontal mr-2"></i>商品總攬</span>
                                <div><i class="fas fa-search pt-1"></i><input class="" type="text" placeholder="商品關鍵字查詢" onkeyup="ManuallySearch(this)"
                                        aria-label="Search"></div>
                            </li>
                            <div class="live_box" id="bid_live_box">
                            </div>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer" >
                    <div class="w" style="display: inline-block;text-align: center;margin-left: 10px;">
                    </div>
                    <div style="display: inline-block;margin-left: auto;">
                        <button type="button" class="btn btn-secondary btn_window btn_no" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-primary btn_window btn_next" 
                            style="background-color: #4db67d;margin-left: 10px;" onclick="submitAddProduct(this)" >送出</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="edit_product" tabindex="-1" role="dialog"
    aria-labelledby="edit_productLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:0!important;background-color: #ffffff!important;">
            <table class="text-center table m-0">
                <tr>
                    <td rowspan="2"><img src="img/goods.jpg" class="product mr-2" style="width: 5em !important; height: 5em !important;"></td>
                    <td class="border-bottom">名稱</td>
                    <td class="border-bottom">規格</td>
                    <td class="border-bottom">售價</td>
                    <td class="border-bottom">數量</td>
                    <td class="border-bottom">小計</td>
                    <td rowspan="2">
                        <button class="btn btn-danger btn-sm mb-3" data-dismiss="modal">取消</button>
                        <button class="btn btn-success btn-sm" onclick="submitEditProduct(this)" id="btn_edit_product" >修改</button>
                    </td>
                </tr>
                <tr>
                    <td><input type="text" name="product_name" class="form-control mr-4 d-inline-block category br-10 row_inp_style" value="商品名稱" disabled></td>
                    <td>
                        <select class="custom-select form-control mr-4 d-inline-block category br-10" onchange="getGoodsNum(this)" id="goods_category">
                        </select>
                    </td>
                    <td><input type="number" name="product_price" min="0" class="form-control mr-4 d-inline-block category br-10 " value="商品價格" ></td>
                    <td><input type="number" name="product_num" class="form-control mr-4 d-inline-block category br-10 " value="商品數量" ></td>
                    <td><input type="text" name="product_sum" class="form-control mr-4 d-inline-block category br-10 row_inp_style" value="小計" disabled></td>
                </tr>
            </table>
        </div>
    </div>
    </div>
<script>
     var CSRF_TOKEN= $('meta[name="csrf-token"]').attr('content');
     alertify.set('notifier','position', 'top-center');
        function addproduct(element){
            $.LoadingOverlay("show");
            var psid = $(element).attr('psid');
            $.ajax({
                url: '/show_product',
                type: 'GET',
                success: function (data) {
                    $("#bid_live_box").children().remove();
                    if(data!="")
                    {
                        $.each(data, function( index, value ) {
                            if(value['index'] == 1)
                            {
                                if(value['goods_num']>0)
                                {
                                    $( "#bid_live_box" ).append(
                                    "<div class='media bg-white  live_bor' data='"+value['goods_name']+"' >"+
                                        "<div class='live_QB'>"+
                                            "<div class='QB_get'>得標數</div>"+
                                            "<div class='QB_get_N'>"+value['bid_num']+"</div>"+
                                            "<div class='QB_Q'>庫存數</div>"+
                                            "<div class='QB_Q_N' >"+value['goods_num']+"</div>"+
                                            "<div class='live_line'></div>"+
                                        "</div>"+
                                        "<img class='d-flex mr-3 rounded live_goods' src='"+value['pic_url']+"' style='margin-left: 5px;'>"+
                                        "<div class='media-body'>"+
                                            "<div class='mt-0 pt-2 product_name'>"+value['goods_name']+
                                                "<div class='product_edit'><i class='fas fa-edit' style='display: inline-block;'></i></div>"+
                                                "<div class='product_cg_num_w'>選擇得標數量</div>"+
                                            "</div>"+
                                            "<div class='h6'><span class='badge badge-warning product_M'>NT$ "+value['goods_price']+"</span>"+ 
                                                "<div class='op_goods' data-toggle='collapse' data-target='.live_"+value['goods_key']+"' aria-expanded='false' aria-controls='live_"+value['goods_key']+"'>"+
                                                    "<span class='product_S'>"+value['all_category']+"</span>"+
                                                    "<div class='op_goods_i'><i class='fas fa-sort-down'></i></div>"+
                                                "</div>"+
                                                "<div class='product_cg_num'><input class='form-control' type='number' value='0' price='"+value['goods_price']+"' product_id='"+value['product_id']+"'  keyword='"+value['keyword']+"' min='0' max='"+value['goods_num']+"' name='bid_num' ></div>"+
                                            "</div>"+
                                        "</div>"+
                                    "</div>");
                                }
                            }
                            else
                            {
                                if(value['goods_num']>0)
                                {
                                    $( "#bid_live_box" ).append("<div class='card collapse live_"+value['goods_key']+"' style='margin-left: 30px;'>"+
                                    "<ul class='list-group list-group-flush '>"+
                                        "<li class='list-group-item d-flex justify-content-between align-items-center' style='padding:5px;'>"+
                                            "<div class='live_QB'>"+
                                                "<div class='QB_get'>得標數</div>"+
                                                "<div class='QB_get_N'>"+value['bid_num']+"</div>"+
                                                "<div class='QB_Q'>庫存數</div>"+
                                                "<div class='QB_Q_N' >"+value['goods_num']+"</div>"+
                                                "<div class='live_line'></div>"+
                                            "</div>"+
                                            "<img class='d-flex mr-3 rounded live_goods' src='"+value['pic_url']+"' style='margin-left: 5px;'>"+
                                            "<div class='media-body ' style='padding:5 '>"+
                                                "<div class='mt-0 pt-2 product_name'>"+value['goods_name']+
                                                    "<div class='product_edit'><i class='fas fa-edit' style='display: inline-block;'></i></div>"+
                                                    "<div class='product_cg_num_w'>選擇得標數量</div>"+
                                                "</div>"+
                                                "<div class='h6'>"+
                                                    "<span class='badge badge-warning product_M'>NT$ "+value['goods_price']+"</span>"+
                                                    "<span class='product_S'>"+value['all_category']+"</span>"+
                                                    "<div class='product_cg_num'><input class='form-control' type='number' value='0' min='0'  price='"+value['goods_price']+"' product_id='"+value['product_id']+"'  keyword='"+value['keyword']+"'  max='"+value['goods_num']+"' name='bid_num' ></div>"+
                                                "</div>"+
                                            "</div>"+
                                        "</li>"+
                                    "</ul>"+
                                "</div>");
                                }                           
                            }
                        });
                    }else{
                        $( "#bid_live_box" ).append('<P>尚無商品，請至商品中點選新增商品。</P>') 
                    }
                    $.LoadingOverlay("hide");
                },
                error: function(XMLHttpRequest, status, error) {
                    console.log(XMLHttpRequest.responseText);
                }
            });
        }

        function getGoodsNum(element){
            $.LoadingOverlay("show");
            var optionSelected = $(element).find("option:selected").attr('product_id');
            $.ajax({
                url: '/get_ProductNum',
                type: 'GET',
                data: {_token:CSRF_TOKEN , product_id:optionSelected},
                dataType: 'JSON ',
                success: function (data) {
                    var maxvalue= data['goods_num'] - data['pre_sale'];
                    $("input[name=product_num]").attr({
                        "max" : maxvalue, 
                        "min" : 0  
                    });
                    $.LoadingOverlay("hide");
                },
                error: function(XMLHttpRequest, status, error) {
                    console.log(XMLHttpRequest.responseText);
                }
            });
        }

        function editproduct(element){
            $.LoadingOverlay("show");
            var product_id = $(element).attr('product_id');
            var index = $(element).attr('index');
            $("#btn_edit_product").attr({
                "id" : index, 
            });

            $.ajax({
                url: '/edit_product',
                type: 'POST',
                data: {_token:CSRF_TOKEN , index:index , product_id:product_id },
                dataType: 'JSON',
                success: function (data) {             
                    $("input[name=product_name]").val(data['goods_name']);
                    $("input[name=product_price]").val(data['goods_price']);
                    $("input[name=product_num]").val(data['get_num']);
                    $("input[name=product_num]").attr({
                        "max" : data['stock'], 
                        "min" : 0  
                    });
                    $("#goods_category").children().remove();
                    $("#goods_category").append('<option class="d-none" selected>請選擇屬性</option>');
                    $.each(data['keyword'], function( index, value ){
                        $("#goods_category").append('<option product_id="'+value['product_id']+'" >'+value['category']+'</option>');
                    });
                    $("input[name=product_sum]").val(data['goods_price']*data['get_num']);
                    $.LoadingOverlay("hide");
                },
                error: function(XMLHttpRequest, status, error) {
                    console.log(XMLHttpRequest.responseText);
                }
            });
        }

        function submitEditProduct(element){
            $.LoadingOverlay("show");
            var index = $(element).attr('id');             
            var goods_category = $("#goods_category :selected").text();
            var product_id = $("#goods_category :selected").attr('product_id');
            var goods_price =$("input[name=product_price]").val();
            var goods_num = $("input[name=product_num]").val();

            if(product_id == undefined){
                alertify.error('請確認是否選取商品屬性！');
                $.LoadingOverlay("hide");
            }else{
                $.ajax({
                url: '/submit_EditProduct',
                type: 'POST',
                data: {_token:CSRF_TOKEN , index:index ,product_id:product_id , goods_price:goods_price , goods_num:goods_num },
                dataType: 'TEXT',
                success: function (data) {
                    alertify.success('成功更改此筆訂單資訊！');
                    refreshOrder();
                    $('#edit_product').modal('hide');                
                    $.LoadingOverlay("hide");
                },
                error: function(XMLHttpRequest, status, error) {
                    console.log(XMLHttpRequest.responseText);
                }
            });
            }

        }

        function submitAddProduct(element){
            $.LoadingOverlay("show");
            var addProductList = [];
            var arr;
            $("input[name=bid_num]").each(function(){
                if($(this).val()>0){
                    arr = {
                    "price" : $(this).attr('price'),
                    "product_id" : $(this).attr('product_id'),
                    "num" : $(this).val()
                    };
                    addProductList.push(arr);
                }
            });
            if(addProductList == 0){
                //訊息提示
                alertify.error('請確認是否新增商品數量！');
                $.LoadingOverlay("hide");
            }else{
                $.ajax({
                    url: '/submit_AddProduct',
                    type: 'POST',
                    data: {_token:CSRF_TOKEN , addProductList:addProductList ,ps_id:'{{ $orders[0]->ps_id }}' },
                    dataType: 'JSON',
                    success: function (data) {
                        alertify.success('成功新增商品至此筆訂單！');
                        refreshOrder();
                        $('#addproduct').modal('hide');                
                        $.LoadingOverlay("hide");
                    },
                    error: function(XMLHttpRequest, status, error) {
                        console.log(XMLHttpRequest.responseText);
                    }
                });
            }
        }

        function deleteOrder(element){
            $.LoadingOverlay("show");
            var index = $(element).attr('index');
            $.ajax({
                url: '/delete_order',
                type: 'POST',
                data: {_token:CSRF_TOKEN , index:index },
                dataType: 'TEXT',
                success: function (data) {
                    alertify.success('成功刪除此筆訂單之商品！');
                    $('#addproduct').modal('hide');                
                    $.LoadingOverlay("hide");
                    refreshOrder();
                },
                error: function(XMLHttpRequest, status, error) {
                    console.log(XMLHttpRequest.responseText);
                }
            });
        }

        function refreshOrder(){
            $.ajax({
                url: '/refresh_order',
                type: 'POST',
                data: {_token:CSRF_TOKEN,ps_id:{{ $orders[0]->ps_id }} },
                dataType: 'JSON',
                success: function (data) {
                    $("#order_table").children().remove();
                    $.each(data['orders'], function( index, value ) {
                        $("#order_table").append('<tr>\
                            <td><img class="product mr-2" src="'+value['pic_url']+'" >'+value['goods_name']+'</td>\
                            <td>'+value['category']+'</td>\
                            <td>'+value['bid_price']+'</td>\
                            <td>'+value['bid_num']+'</td>\
                            <td>'+value['bid_price']*value['bid_num']+'\
                                <div class="d-flex float-right" style="flex-flow: row wrap;">\
                                    <i class="fa fa-close" index="'+value['id']+'" onclick="deleteOrder(this)" ></i>\
                                    <break></break>\
                                    <i class="fa fa-edit" product_id="'+value['product_id']+'" index="'+value['id']+'"  data-target="#edit_product" data-toggle="modal" onclick="editproduct(this)" ></i>\
                                </div>\
                            </td>\
                        </tr>\
                        ')
                    });
                    $.each(data['prize'], function( index, value ) {
                        $("#order_table").append('<tr>\
                            <td><img class="product mr-2" src="'+value['image_url']+'" >'+value['product_name']+'</td>\
                            <td></td>\
                            <td>贈品</td>\
                            <td>ㄅ</td>\
                            <td>贈品\
                                <div class="d-flex float-right" style="flex-flow: row wrap;">\
                                    <i class="fa fa-close" index="'+value['id']+'" onclick="deleteOrder(this)" ></i>\
                                    <break></break>\
                                    <i class="fa fa-edit" product_id="'+value['product_id']+'" index="'+value['id']+'"  data-target="#edit_product" data-toggle="modal" onclick="editproduct(this)" ></i>\
                                </div>\
                            </td>\
                        </tr>\
                        ')
                    });
                },
                error: function(XMLHttpRequest, status, error) {
                    console.log(XMLHttpRequest.responseText);
                }
            });
        }
        $(document).ready(function () {

            $('#member_order_detail').DataTable({
                "paging": false,
                "searching": false,
                "info": false,
            });
        });
</script>
@stop



