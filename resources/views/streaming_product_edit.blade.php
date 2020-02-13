@extends('layouts.master')

@section('title','編輯直播商品')
@section('heads')

@stop

@section('wrapper')
<div class="wrapper">
@stop
@section('navbar')
    <div id="content">
@stop
@section('content')

 <!-- main -->
    <div class="container-fluid all_content overflow-auto" id="Add_Product">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('edit_streaming_product') }}" enctype="multipart/form-data" method="POST">
                {{ csrf_field() }}

                    <div id="blah" class="New_Img" style="background-image: url('{{$product->pic_url  }}')"></div>
                        <input type="file" class="custom-file-input d-none"  id="Upload_Input" name="image" accept="image/*">
                        <input type="hidden"  name="original_image" value="{{$product->pic_url  }}">
                    <input type="hidden" id="blob_img" name="new_pic">
                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                    <div class="form-group" id="goodsname">
                        <label for="exampleFormControlInput1"> 商品名稱<sup>*</sup></label>
                        <input type="text" name="name" maxlength="255" class="form-control form-control-sm" value="{{ $product->goods_name }}" required>
                    </div>
                    <div class="form-group" id="goodsprice">
                        <label for="exampleFormControlInput1">商品價格</label>
                        <input type="text" name="price" class="form-control form-control-sm" maxlength="255" value="{{ $product->goods_price }}">
                    </div>
                    <div class="form-group" id="goodscount">
                        <label for="exampleFormControlInput1">商品數量<sup>*</sup></label>
                        <input type="text" name="num" class="form-control form-control-sm" maxlength="11" value="{{ $product->goods_num }}" required>
                    </div>
                    <div class="form-group" id="goodscategory">
                        <label for="exampleFormControlInput1"> 商品規格 </label>
                        <input type="text" name="category" maxlength="255" value="{{ $category }}" class="form-control form-control-sm"  >
                    </div>
                    <div class="form-group" id="goodsnote">
                        <label for="exampleFormControlTextarea1"> 商品備註</label>
                        <textarea class="form-control form-control-sm" maxlength="1024" name="description" id="exampleFormControlTextarea1" rows="3">{{ $product->description }}</textarea>
                    </div>
                    <div class="text-center">
                        <input class="btn btn-info" type="submit" value="送出">
                        <input class="btn btn-danger ml-2" type="button" onclick="tt()" id="form_btn_delete" value="刪除">
                    </div>
                </form>
                <form action="{{ route('delete_streaming_product') }}" id="delete_streaming_product" name="delete_streaming_product" enctype="multipart/form-data" method="POST">
                    {{ csrf_field() }}
                    
                    <input type="hidden"  name="primary_key" value="{{ $product->product_id }}">
                </form>
            </div>
        </div>
        <div class="modal fade " id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">裁減圖片</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <img id="image" src="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="crop">確定</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main end -->
</div>
<!-- Cotent end-->
<script>
    $( document ).ready(function() {
        const driver = new Driver();

        driver.defineSteps([
                {
                    element: '#blah',
                    popover: {
                        title: '點選直播商品圖片',
                        description: '修改直播商品圖片',
                        position: 'bottom'
                    }
                },
                {
                    element: '#goodsname',
                    popover: {
                        title: '修改商品名稱',
                        description: '修改直播商品名稱',
                        position: 'bottom'
                    }
                },
                {
                    element: '#goodsprice',
                    popover: {
                        title: '修改商品金額',
                        description: '修改直播商品金額，<font class="text-danger">競標制商品為直播時高價者</font>',
                        position: 'bottom'
                    }
                },
                {
                    element: '#goodscount',
                    popover: {
                        title: '修改商品數量',
                        description: '修改直播商品數量',
                        position: 'top'
                    }
                },
                {
                    element: '#goodscategory',
                    popover: {
                        title: '修改修改規格',
                        description: '修改直播商品規格，<font class="text-danger">競標制商品不適用，如需上價競標商品規格欄位請空白<br>數量制時請告知買家留言得標為{規格+數量}</font>',
                        position: 'top'
                    }
                },
                {
                    element: '#goodsnote',
                    popover: {
                        title: '修改商品備註',
                        description: '修改直播商品備註',
                        position: 'top'
                    }
                },
                {
                    element: '.btn.btn-info',
                    popover: {
                        title: '點選送出',
                        description: '儲存商品資訊',
                        position: 'top'
                    }
                },
                {
                    element: '.btn.btn-danger.ml-2',
                    popover: {
                        title: '點選刪除',
                        description: '刪除此商品',
                        position: 'top'
                    }
                }
            ]);

        document.querySelector('#help_me').addEventListener('click', function (e) {
            e.preventDefault();
        e.stopPropagation();
        driver.start();
        });
    });

   
</script>
</div>
<!-- jQuery CDN - Slim version (=without AJAX) -->
@stop 
@section('footer')

<script>
    function tt(){
        $("#delete_streaming_product").trigger('submit');
    }
</script>
@stop