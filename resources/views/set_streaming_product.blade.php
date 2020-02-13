@extends('layouts.master')

@section('title','設定直播商品')
@section('heads')
@stop

@section('wrapper')
<div class="wrapper">
@stop

@section('navbar')
    <div id="content">
        @stop
        @section('content')
        <div class="container-fluid all_content overflow-auto" id="Add_Product">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('set_product') }}" enctype="multipart/form-data" method="POST">
                    {{ csrf_field() }}
                        <div id="Upload_Img">
                            <input type="file"  class="custom-file-input" id="Upload_Input"  accept="image/*">
                        </div>
                        <div id="blah"></div>
                        <input type="hidden" id="blob_img" name="image">
                        <div class="form-group" id="goodsname">
                            <label for="exampleFormControlInput1"> 商品名稱<sup>*</sup></label>
                            <input type="text" name="name" maxlength="255" class="form-control form-control-sm" placeholder="請輸入商品名稱 ..." required>
                        </div>
                        <div class="form-group" id="goodsprice">
                            <label for="exampleFormControlInput1">商品價格</label>
                            <input type="number" min="0" name="price" maxlength="255" class="form-control form-control-sm" placeholder="請輸入商品價格 ...">
                        </div>
                        <div class="form-group" id="goodscategory">
                            <label for="exampleFormControlInput1"> 商品規格 </label>
                            <input type="text" name="category" maxlength="255" class="form-control form-control-sm" placeholder="請輸入商品規格 ..." >
                        </div>
                        <div class="form-group" id="goodsnote">
                            <label for="exampleFormControlTextarea1"> 商品備註</label>
                            <textarea class="form-control form-control-sm" maxlength="1024" name="description" placeholder="請輸入商品備註 ..."  rows="3"></textarea>
                        </div>
                        <div class="form-group" id="goodscount">
                            <label for="exampleFormControlInput1">商品數量<sup>*</sup></label>
                            <input type="number" min="0" name="num" maxlength="11" class="form-control form-control-sm" required placeholder="請輸入商品數量 ...">
                        </div>
                        <div class="text-center">
                            <input class="btn btn-secondary" type="submit" value="送出">
                        </div>
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
</div>
<script>
    $( document ).ready(function() {
        const driver = new Driver();

        driver.defineSteps([
                {
                    element: '#Upload_Img',
                    popover: {
                        title: '點選新增商品',
                        description: '新增直播商品圖片',
                        position: 'bottom'
                    }
                },
                {
                    element: '#goodsname',
                    popover: {
                        title: '新增商品名稱',
                        description: '新增直播商品名稱',
                        position: 'bottom'
                    }
                },
                {
                    element: '#goodsprice',
                    popover: {
                        title: '新增商品金額',
                        description: '新增直播商品金額，<font class="text-danger">競標制商品為直播時高價者</font>',
                        position: 'bottom'
                    }
                },
                {
                    element: '#goodscategory',
                    popover: {
                        title: '新增新增規格',
                        description: '新增直播商品規格，<font class="text-danger">競標制商品不適用，如需上價競標商品，規格欄位請空白<br>數量制時請告知買家留言得標為{規格+數量}</font>',
                        position: 'top'
                    }
                },
                {
                    element: '#goodsnote',
                    popover: {
                        title: '新增商品備註',
                        description: '新增直播商品備註',
                        position: 'top'
                    }
                },
                {
                    element: '#goodscount',
                    popover: {
                        title: '新增商品數量',
                        description: '新增直播商品數量',
                        position: 'top'
                    }
                },
                {
                    element: '.btn.btn-secondary',
                    popover: {
                        title: '點選送出',
                        description: '儲存商品資訊',
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
<!-- jQuery CDN - Slim version (=without AJAX) -->
@stop 
@section('footer')    

@stop

