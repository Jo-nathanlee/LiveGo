@extends('layouts.master')

@section('title','直播商品總覽')

@section('wrapper')
<div class="wrapper">

@stop
@section('navbar')
    <!-- Page Content  -->
    <div id="content">
@stop
@section('content')
        <div class="container-fluid all_content overflow-auto" id="Product_Manage">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <ul class="nav nav-tabs ">
                        <li class="nav-item">
                            <a class="nav-link text-dark font-weight-bold active" id="StreamingProductOverview" href="{{ route('StreamingProductOverview')  }}">全部</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black-50" id="StreamingProductOverview_On" href="{{ route('StreamingProductOverview_On')  }}">已上架
                                <sub class="text-danger ml-1">{{ $countOnProduct }}</sub>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-black-50" id="StreamingProductOverview_Out" href="{{ route('StreamingProductOverview_Out')  }}">已售完
                                <sub class="text-danger ml-1">{{ $countOutProduct }}</sub>
                            </a>
                        </li>
                        <li class="nav-item ml-auto">
                            <form id="excel_Form" action="{{ route('excel_reader') }}" enctype="multipart/form-data" method="POST">
                                {{ csrf_field() }}
                                <div class="input-group">
                                    <div class="custom-file">
                                      <input type="file" class="custom-file-input" id="excelupload" name="excelupload" 
                                        aria-describedby="excelupload">
                                      <label class="custom-file-label" id="exceltext" for="excelupload">選擇excel檔</label>
                                    </div>
                                    <div class="input-group-prepend">
                                        <input type="submit" class="btn btn-secondary" value="送出">
                                      </div>
                                  </div>
                            </form>
                        </li>
                        <li class="nav-item  ml-auto">
                            <div class="form-group row">
                                <label for="InputSearch" class="col-sm-2 col-form-label">
                                    <i class='fas d-inline-block ml-4'>&#xf002;</i>
                                    <style id="search_style"></style>
                                </label>
                                <div class="col-sm-10">
                                    <input class="d-inline form-control mr-sm-2" type="text" id="InputSearch" placeholder="Search" aria-label="Search"> 
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="Add_Product_warp ">
                        <div class="Add_Product_Content text-center">
                            <div onclick="location.href='{{ route('SetProduct_show') }}'">
                                <i class='fas mr-2'>&#xf067;</i>點選新增商品</div>
                        </div>
                        <div class="Add_Product_note  pt-3">
                            <P>&nbsp;</P>
                            <P>&nbsp;</P>
                            <small>&nbsp;</small>
                            <br>
                            <small>&nbsp;</small>
                        </div>
                    </div>
                    @foreach($products as $product)
                    <div class="Product_warp shadow" data-index="{{$product->goods_name}}"  onclick="location.href='{{route('EditStreamingProduct_show', [ 'product_id'=>$product->product_id, 'key' =>$product->pic_url ])}}';">
                        <div class="Product_Img" style="background-image: url('{{$product->pic_url }}')"></div>
                        <div class="Product_Content pt-3">
                            <P class="text-truncate">商品名稱： {{$product->goods_name}}
                                @if( $product->category != "empty" )
                                    <small>{{$product->category}}</small>
                                @endif
                            </P>
                            <P class="text-truncate">商品價格：
                                <a class="text-danger currencyField">{{$product->goods_price}}</a>
                            </P>
                            <small class="text-black-50 text-truncate">剩餘數量：{{$product->goods_num}}</small>
                            <br>
                            <small class="text-black-50 text-truncate">銷售數量：{{$product->selling_num}}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById("excelupload").onchange = function () {
    document.getElementById("exceltext").innerText = this.value;
 };
</script>

@stop 
@section('footer')

@stop
