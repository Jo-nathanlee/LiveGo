
@extends('layouts.master')

@section('title','商品')

@section('head_extension')
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var CSRF_TOKEN= $('meta[name="csrf-token"]').attr('content');
        $('#btn_addproduct').click(function(e) {
            e.preventDefault();
            var bg = $("#blah").css('background-image');
            bg = bg.replace(/(url\(|\)|'|")/gi, '');
            var res = bg.split('base64,', 2 );
            var upload_image = res[1];
            var product_name = $('input[name="ProductName"]').val();

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
            
            $.LoadingOverlay("show");
            $.ajax({
                url: '/create_product',
                type: 'POST',
				dataType: 'JSON',
                data:{ 
					page_id:'{{$page_id}}',
					upload_image:upload_image,
                    product_name:product_name,
					product_category:product_category,
					product_price:product_price,
                    product_num:product_num,
					_token:CSRF_TOKEN
						
				},

                success: function (data) {
                    $.LoadingOverlay("hide");
                    alertify.alert('系統訊息',"新增成功！");
                    $('#addProductInformation').modal('toggle');      
                },
                
                error: function(XMLHttpRequest, status, error) {
                    console.log(XMLHttpRequest.responseText);
					$.LoadingOverlay("hide");
					//alertify.alert('123');
                }
            });
            
        });

        $("#btn_ProductList").click(function(e){
            $.LoadingOverlay("show");
            $.ajax({
                url: '/ProductSalesList',
                type: 'get',
                data: { page_id:'{{$page_id}}',_token:CSRF_TOKEN},
                dataType: 'JSON',
                success: function (data) {
                    $.LoadingOverlay("hide");
                    $("#saleshot").children().remove();
                   $.each(data,function( index, data ) {
                        var head="";
                        if(index==0){
                            head = '<div class="sales_top_box">1\
                                        <div class="sales_top_i"><i class="fas fa-caret-up" style="color:#2fc36d"></i>\
                                        </div>\
                                        <img src="img/crown.png" alt="crown" class="sales_no1_C">\
                                    </div>';
                        }else if(index==1){
                            head =  '<div class="sales_top_box">2\
                                        <div class="sales_top_i"><i class="fas fa-sort-down" style="color:#e22835"></i>\
                                        </div>\
                                    </div>';
                        }else if(index==2 ){
                            head = '<div class="sales_top_box">3\
                                        <div class="sales_top_i"><i class="fas fa-minus"\
                                                style="color:#9f9d9e;font-size:50%"></i></div>\
                                    </div>';
                        }else{
                            head = '<div class="sales_top_box">'+(index+1)+'\
                                        <div class="sales_top_i"></div>\
                                    </div>';
                        }

                        $("#saleshot").append('\
                                <div class="media sales_box">\
                                    '+head+'\
                                    <div class="sales_photo"><img src="'+data['pic_url']+'" alt="photo"></div>\
                                    <div class="sales_w_box">\
                                        <span class="sales_T">'+data['goods_name']+'<small>(單價： $'+data['goods_price']+')</small></span><br>\
                                        <span\
                                            class="sales_w">共銷售&nbsp;:&nbsp;'+data['sell']+'個&nbsp;&nb\sp;&nbsp;總銷售&nbsp;:&nbsp;'+data['total']+'</span>\
                                    </div>\
                                </div>');
                    });

                },
                
                error: function(XMLHttpRequest, status, error) {
                        console.log(XMLHttpRequest.responseText);
                }
            });
        });  
        
        $("#btn_editproduct").click(function(e){
            $.LoadingOverlay("show");

            var product_id = new Array();
            $('input[name^="product_id"]').each(function() {
                product_id.push($(this).val());
            });

            var product_price = new Array();
            $('input[name^="edit_price"]').each(function() {
                product_price.push($(this).val());
            });

            var product_category = new Array();
            $('input[name^="edit_category"]').each(function() {
                product_category.push($(this).val());
            });

            var product_num = new Array();
            $('input[name^="edit_num"]').each(function() {
                product_num.push($(this).val());
            });

            $.ajax({
                url: '/edit_product',
                type: 'POST',
                data: { page_id:'{{$page_id}}',_token:CSRF_TOKEN,
                        product_id:product_id,product_num:product_num,
                        product_price:product_price,product_category:product_category},
                dataType: 'JSON',
                success: function (data) {
                    $.LoadingOverlay("hide");
                    $('#editProduct').modal('toggle');     
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('<i class="fa mr-2">&#xf14a;</i>'+"更改成功");
                    setTimeout(function(){
                        location.reload(); 
                    }, 1000); 
                },
                error: function(XMLHttpRequest, status, error) {
                        console.log(XMLHttpRequest.responseText);
                }
            });
        });

    });
</script>
    
<style>
    .switch_box{
    width: auto !important;
    height: auto !important;
    padding: .5rem 0 !important;
    border-bottom-right-radius: 10px !important;
    border-top-right-radius: 10px !important;
    background-color: #ababab ;
    }
    .switch_box span{
        /*background-color: green;*/
        display: inline-block !important;
        vertical-align: top !important;
        line-height: 15px !important;
        font-size: .8rem !important;
        color: #FFFFFF !important;
    }
    .custom-switch .custom-control-label::after{
        background-color: #FFFFFF !important;
        border-style: none !important;
    }
    .custom-control-label::before{
        background-color: #d6d6d6 !important;
        border-style: none !important;
    }
    .custom-control-input:checked~.custom-control-label::before{
        background-color:#87fc8a !important;
    }
    .custom-switch {
        padding-left: 2.25rem;
    }
    .custom-control-label {
        position: relative;
        margin-bottom: 0;
        vertical-align: top;
    }
    .custom-switch .custom-control-label::before {
        left: -2.25rem;
        width: 1.75rem;
        pointer-events: all;
        border-radius: .5rem;
    }
    .custom-switch .custom-control-input:checked~.custom-control-label::after {
        background-color: #fff;
        -webkit-transform: translateX(.75rem);
        transform: translateX(.75rem);
    }
    .custom-switch .custom-control-label::after {
        top: calc(.25rem + 2px);
        left: calc(-2.25rem + 2px);
        width: calc(1rem - 4px);
        height: calc(1rem - 4px);
        background-color: #adb5bd;
        border-radius: .5rem;
        transition: background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-transform .15s ease-in-out;
        transition: transform .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        transition: transform .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-transform .15s ease-in-out;
    }
</style>
@stop

@section('wrapper')
<div class="wrapper">
@stop
@section('navbar')
    <div id="content">
@stop
        @section('content')
        
        <div class="row" id="button_panel">
            <div class="col-md-4">
                <button type="button" class="btn  w-100 pt-4" style="background-image: url('img/b1.png')"
                    data-toggle="modal" data-target="#addProductImg">
                    <h1>
                        <img src="img/shopping-bag.png">
                        新增商品
                    </h1>
                </button>
            </div>
            <div class="col-md-4">
                <button type="button" class="btn w-100 pt-4" style="background-image: url('img/b2.png');"
                    data-toggle="modal" data-target="#addProductExcel">
                    <h1>
                        <img src="img/ecxel.png">
                        新增Excel
                    </h1>

                </button>
            </div>
            <div class="col-md-4">
                <button type="button" class="btn  w-100 pt-4" id="btn_ProductList" style="background-image: url('img/b3.png');"
                    data-toggle="modal" data-target="#ProductList">
                    <h1>
                        <img src="img/sale-list.png">
                        商品銷售單
                    </h1>
                </button>
            </div>
        </div>
        <div class="row" style="position: relative;">
		
            <div class="col-md-12">
                <div class="card-body">
                    <table class="table" id="Product">
                        <thead>
                            <tr>
                                <th></th>
                                <th>商品名稱</th>
                                <th>新增商品時間</th>
                                <th>規格</th>
                                <th>售價</th>
                                <th>可售數量</th>
                                <th>待確定數</th>
                                <th>庫存</th>
                                <th style="opacity: 0;cursor: auto;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($goods as $data)
								@foreach($data as $product)
									@if($product['index'] == 1)
                                        <tr id="{{$product['goods_key']}}">
                                            <td>
                                                <div class="d-flex float-left" style="flex-flow: row wrap;">
                                                    <span class="or_ck_label" style="margin-left:0!important;position: relative!important;">
                                                            {{-- 下面input 跟 label ID 跟 FOR地方規則order_ck + $loop->iteration --}}
                                                            <input id="order_ck{{$product['product_id']}}" name='chk_goods' type="checkbox" class="chkbox" goodskey="{{ $product['goods_key'] }}"/>
                                                            <label for="order_ck{{$product['product_id']}}"></label>
                                                    </span>
                                                    <break></break>
                                                    <i class="fa fa-edit h5 mt-2" data-dismiss="modal" data-toggle="modal" goodskey="{{$product['goods_key']}}" onclick="EditProductShow(this)"  data-target="#editProduct"></i>
                                                </div>
                                                <img src="{{$product['pic_url']}}" style="height: 5rem;width: 5rem">
                                            </td>
                                            <td><p class="text-center over-text h4" style=" max-width: 15rem;">{{$product['goods_name']}}</p></td>
                                            <td>
                                                {{$product['created_at']}}
                                            </td>
                                            <td>
                                                @if($product['diverse']>1)
                                                    <div class="h6">
                                                        <div class="op_goods" product_ids="{{$product['product_id_list']}}" onclick="collapseProduct(this)" style="margin-left:-5rem ">
                                                            <span class="product_S float-left over-text" style=" max-width: 10rem;width:auto;">
                                                                {!!$product['all_category']!!}
                                                            </span>
                                                            <div class="op_goods_i float-right"><i class="fas fa-sort-down"></i></div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="over-text d-block" style=" max-width: 10rem;width:auto ">
                                                        {!!$product['all_category']!!}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="currencyField">{{$product['goods_price']}}</td>
                                            <td>{{$product['goods_num']-$product['pre_sale']}}</td>
                                            <td>{{$product['selling_num']}}</td>
                                            <td>{{$product['goods_num']}}</td>
                                            <td style="padding: 0;background-color: #eeeeee;border-style: none;">
                                                @if($product['shop'] == 'true')
                                                    <div class="switch_box" style="background-color: rgb(137, 201, 151)!important;" >
                                                        <div class="custom-control custom-switch" style="transform:rotate(-90deg)!important;display: inline-block!important;">
                                                        <input type="checkbox" class="custom-control-input turn_onoff cus_switch" id="switch1{{$product['product_id']}}" name="{{$product['goods_key']}}" checked="">
                                                        <label class="custom-control-label" for="switch1{{$product['product_id']}}"></label>
                                                        </div>
                                                        <span class="switch_w">已<br>上<br>架</span>
                                                    </div>
                                                @else
                                                    <div class="switch_box" >
                                                        <div class="custom-control custom-switch" style="transform:rotate(-90deg)!important;display: inline-block;!important">
                                                        <input type="checkbox" class="custom-control-input turn_onoff cus_switch" id="switch1{{$product['product_id']}}" name="{{$product['goods_key']}}">
                                                        <label class="custom-control-label" for="switch1{{$product['product_id']}}"></label>
                                                        </div>
                                                        <span class="switch_w">未<br>上<br>架</span>
                                                    </div>
                                                @endif
                                           </td>
                                        </tr>
									@endif
								@endforeach
							@endforeach
                        </tbody>
                    </table>
                </div>
            </div>
			
        </div>
            <!-- 新增商品圖片區塊 -->
        <div class="modal" id="addProductImg" tabindex="-1" role="dialog" aria-labelledby="addProductImgLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductImgLabel">新增商品</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h6 class="font-weight-bold">
                            步驟一：新增商品圖片
                            <small>
                                <p class="mt-3">商品檔案格式：JPG, JPEG, PNG <br>
                                    照片建議尺寸： 800 * 800 <br>
                                    如非上傳正方形圖片 ,系統會自動裁切為正方形 <br>
                                    最多上傳 9 張照片，每張檔案大小不得超過 4.0 MB</p>
                            </small>
                        </h6>
                        <div id="Upload_Img">
                            <input type="file" class="custom-file-input" value=""  id="Upload_Input" name="image"
                            accept='image/*'>
                        </div>
                        <div id="blah">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn_window btn_no" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-primary btn-blue btn_window" data-dismiss="modal"
                            data-toggle="modal" data-target="#addProductInformation">下一步</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- 新增直播拍賣商品區塊 -->
        <div class="modal" id="addProductInformation" tabindex="-1" role="dialog"
            aria-labelledby="addProductInformationLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductInformationLabel">新增商品</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h6 class="font-weight-bold">
                            步驟二：編輯商品
                        </h6>
                        <form class="" id="addProductContent">
                            <div class="form-group ">
                                <label for="GoodsName">商品名稱</label>
                                <input type="text" class="form-control br-10 row_inp_style" name="ProductName" id="GoodsName"
                                    placeholder="請輸入商品名稱 ..." required>
                            </div>
                            <div class="w-100">
                                <label class="w-25 mr-4">規格</label>
                                <label class="w-25 mr-4">價格</label>
                                <label class="w-25 mr-4">庫存</label>
                            </div>
                            <div class="w-100 " id="addCategory">
                                <div class="mb-2 br-10">
                                    <input type="text" name="product_category[]"
                                        class="form-control mr-4 w-25 d-inline-block category br-10 row_inp_style"
                                        placeholder="請輸入商品規格 ..." required>
                                    <input type="number" name="product_price[]"
                                        class="form-control mr-4 w-25 d-inline-block price br-10 row_inp_style" min="0"
                                        value="0" required>
                                    <input type="number" name="product_num[]"
                                        class="form-control mr-4 w-25 d-inline-block stock br-10 row_inp_style" min="0"
                                        value="0" required>
                                </div>
                                <div id="addEvent" style="color:#0f7867;font-size: 18px;cursor: pointer;">
                                    + 增加商品規格
                                </div>
                            </div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal"
									data-target="#addProductImg">上一步</button>
								<button type="button" id="btn_addproduct" class="btn btn-primary">完成</button>
							</div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!-- Excel新增直播拍賣商品區塊 -->
        <div class="modal" id="addProductExcel" tabindex="-1" role="dialog" aria-labelledby="addProductExcelLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductExcelLabel">匯入商品(Excel)</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('excel_upload') }}" enctype="multipart/form-data" method="POST">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="input-group input-group-sm">
                                <h5 class="font-weight-bold mt-2 pr-2">
                                    新增商品Excel
                                </h5>

                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="excelFile" id="excelFile" accept=".xls, .xlsx">
                                        <label class="custom-file-label" for="customFile"></label>
                                    </div>
                            
                            </div>
                            <div class="small">
                                <p>＊商品批次匯入，請照範例格式填寫下載範例。 <a href="download/LiveGO上傳範例.xlsx" class="excel_font">範例Excel下載</a></p>
                                <p>＊圖片需為 JPEG、JPG 或 PNG 格式，建議可使用Imgur圖庫或第三方服務，請確保網址是公開可取得的</p>
                                <p>＊此商品匯入功能僅為新增商品使用,無法更新原有商品</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn_window btn_no" data-dismiss="modal">取消</button>
                            <input type="submit" class="btn btn-primary btn_window btn-green"  value="完成">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal" id="ProductList" tabindex="-1" role="dialog" aria-labelledby="ProductList" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ProductListLabel"><i class="fas fa-clipboard-list"></i>商品銷售單</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="saleshot">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn_window btn_no" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-secondary btn-yellow btn_window"
                            data-dismiss="modal">完成</button>
                    </div>
                </div>
            </div>
        </div>  

            <!-- 修改商品區塊 -->
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
                                    placeholder="請輸入商品名稱 ..." disabled>
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
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn_window btn_no" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-primary btn_window btn_next" type="submit" id="btn_editproduct" 
                            style="background-color: #0f7867">完成</button>
                    </div>
                </div>
            </div>
        </div>
        @stop 
@section('footer')    

<script>
    $(document).ready(function () {
        $('#Product').DataTable({
            "pagingType": "full_numbers",
            "oLanguage": {
                "sLengthMenu": "顯示 _MENU_ 筆資料 <button class='btn btn-secondary btn-sm' style='cursor: pointer;' disabled id='showcheck' onclick='btn_delete()'>刪除商品</button>",
                "sInfo": "共 _TOTAL_ 筆資料",
                "sSearch": "",

                "oPaginate": {
                    "sFirst": " ",
                    "sPrevious": " ",
                    "sNext": " ",
                    "sLast": " "
                }
            }
        });

        
        $('#excelFile').on('change',function(){
            //get the file name
            var fileName = $(this).val();
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName.replace('C:\\fakepath\\', " "));
        })
    });
    var CSRF_TOKEN= $('meta[name="csrf-token"]').attr('content');


    function btn_delete(){
        selectedGoods = new Array();
        $("input:checkbox[name=chk_goods]:checked").each(function(){
            selectedGoods.push( [$(this).attr('goodskey')] );
        });
        

        $.ajax({
            url: '/delete_product',
            type: 'POST',
            data: {goods_key:selectedGoods,page_id:'{{$page_id}}',_token:CSRF_TOKEN},
            dataType: 'JSON',
            success: function (data) {
                alertify.set('notifier','position', 'top-center');
                alertify.success('<i class="fa mr-2">&#xf14a;</i>'+"刪除成功");
                setTimeout(function(){
                    location.reload(); 
                }, 1000); 
            },
            error: function(xhr, status, error) {
                alertify.error('刪除失敗！請聯繫客服！');
            }
        });
    }

    function EditProductShow(element){
        $("#editCategory").empty();
                $("#editCategory").append('<div id="editEvent" onclick="editEvent()"  style="color:#0f7867;font-size: 18px;cursor: pointer;">\
                + 增加商品規格\
                </div>\
                <span id="error_text_edit" class="text-danger d-none">\
                    (商品種類至多七種)\
                </span>');
        goods_key = $(element).attr('goodskey');
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
                                value="'+data.goods_price+'" name="edit_price[]" required disabled>\
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
                                placeholder="請輸入商品規格 ..." name="edit_category[]" value="'+data.category+'" required disabled>\
                            <input type="number"\
                                class="form-control mr-4 w-25 d-inline-block price br-10 row_inp_style" min="0"\
                                value="'+data.goods_price+'" name="edit_price[]" required disabled>\
                            <input type="number"\
                                class="form-control mr-4 w-25 d-inline-block stock br-10 row_inp_style" min="0"\
                                value="'+data.goods_num+'" name="edit_num[]" productid="'+data.product_id+'" required>\
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

    function collapseProduct(element){
        var product_ids = $(element).attr('product_ids');
        var parant_td = $(element).parent().parent().parent();
        var tr_len = parant_td.length
        $.LoadingOverlay("show");
        $.ajax({
            url: '/collapseProduct',
            type: 'GET',
            data: { product_ids:product_ids,_token:CSRF_TOKEN},
            dataType: 'JSON',
            success: function (data) {          
                $.LoadingOverlay("hide");
                var len_goodskey  = $('tr[goodskey ="'+data[0]['goods_key']+'"]').length ;
                if( len_goodskey == 0 ){
                    $.each(data,function( index, data ) {
                        $("#"+data['goods_key']).after('<tr goodskey='+data['goods_key']+'>\
                                <td>\
                                </td>\
                                <td>'+data['goods_name']+'\
                                </td>\
                                <td>'+data['created_at']+'</td>\
                                <td>\
                                    <div class="h6">\
                                            <b>'+data['category']+'</b>\
                                    </div>\
                                </td>\
                                <td class="currencyField">'+data['goods_price']+'</td>\
                                <td>'+ (data['goods_num']-data['selling_num']) +'</td>\
                                <td>'+data['selling_num']+'</td>\
                                <td>'+data['goods_num']+'</td>\
                        </tr>');
                    });
                }  
            },
            
            error: function(XMLHttpRequest, status, error) {
                    console.log(XMLHttpRequest.responseText);
            }
        });
    }

    //商品上下架
    $(document).on('click','.turn_onoff',function(){
        
        $.ajax({
            type: 'POST',
            url: '/product_onoff',
            dataType: 'JSON',
            data: {goods_key: $(this).attr('name'), on_off: $(this).prop('checked')},
            cache: false,
            success: function(response){
                
            },
            error: function(xhr){
                console.log(xhr.responseText);
            }

        });
    });

    //控制項變換
    $(function() {
        $('.cus_switch').change(function() {
        // $('#console-event').html('Toggle: ' + $(this).prop('checked'))
        // alert("HI");
            if(this.checked) {
                // alert("HI");
                $( this ).parent().parent().find( "span" ).html("已<br>上<br>架");
                $( this ).parent().parent().parent().find( "div.switch_box" ).css({'background-color':'#89c997'}); 
   
            }
            else{
                $( this ).parent().parent().find( "span" ).html("未<br>上<br>架");
                $( this ).parent().parent().parent().find( "div.switch_box" ).css({'background-color':'#ababab'}); 

                
            }
        })
    })
    $( "input[name='chk_goods']" ).change(function() {
        selectedGoods = new Array();
        $("input:checkbox[name=chk_goods]:checked").each(function(){
            selectedGoods.push( [$(this).attr('goodskey')] );
        });
        if(selectedGoods!=[]){
            $("#showcheck").removeClass().addClass('btn-sm btn btn-danger');
            $("#showcheck").removeAttr('disabled');
        
        }else{
            $("#showcheck").removeClass().addClass('btn-sm btn btn-secondary');
            $("#showcheck").attr('disabled', 'disabled');
        }
    });
    //changefunction

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
            <input type="hidden" name="product_id[]" class="form-control mr-4 w-25 d-inline-block stock br-10 row_inp_style"\
            value="add">\
            <i class="fas fa-times-circle text-danger cancel_add_goods"  onclick="cancelProduct(this)"></i>\
            </div>' );
        } else {
            $("#error_text_edit").removeClass().addClass('text-danger');
        }
    }
  
</script>
@stop

