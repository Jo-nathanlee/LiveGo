@extends('layouts.master')

@section('title','商城商品總覽')

@section('wrapper')
<div class="wrapper">
@stop
@section('navbar')
    <!-- Page Content  -->
    <div id="content">
        <!--Nav bar end-->
        @stop
        @section('content')
        @if (session('alert'))
        <script>
            message_danger();
        </script>
        @endif
        <div class="container-fluid all_content overflow-auto" id="Product_Manage">
            <div class="row"> 
                <div class="col-md-12 mb-4">
                    <ul class="nav nav-tabs ">
                        <li class="nav-item">
                            <a class="nav-link text-dark font-weight-bold active" id="product_overview" href="{{ route('product_overview') }}">全部</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-black-50" id="product_overview_on" href="{{ route('product_overview_on') }}">已上架
                                <sub class="text-danger ml-1">{{ $countOnProduct }}</sub>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-black-50" id="product_overview_out" href="{{ route('product_overview_out') }}">已售完
                                <sub class="text-danger ml-1">{{ $countOutProduct }}</sub>
                            </a>
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
                    <div class="Add_Product_warp" onclick="location.href='{{ route('AddProduct_show') }}'">
                        <div class="Add_Product_Content text-center">
                            <div>
                                <i class='fas mr-2'>&#xf067;</i>點選新增商品
                            </div>
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
                    <div class="Product_warp shadow" data-index="{{$product->goods_name}}" onclick="location.href='{{route('EditProduct_show', ['key' =>$product->pic_url ])}}';">
                        <div class="Product_Img" style="background-image: url('{{$product->pic_url }}')"></div>
                        <div class="Product_Content pt-3">
                            <P class ="text-truncate">商品名稱： {{$product->goods_name}}</P>
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
    $( document ).ready(function() {
        const driver = new Driver();

        driver.defineSteps([
                {
                    element: '.nav.nav-tabs ',
                    popover: {
                        title: '點選加價購商品頁籤查看狀況',
                        description: '已售完商品會被自動放入已售完區域！',
                        position: 'bottom'
                    }
                },
                {
                    element: '.form-group.row',
                    popover: {
                        title: '快速尋找加價購商品',
                        description: '輸入關鍵字查詢商品',
                        position: 'bottom'
                    }
                },
                {
                    element: '.Add_Product_warp',
                    popover: {
                        title: '點選新增商品以新增加價購商品',
                        description: '買價就可以購買加價購商品來湊滿免運費',
                        position: 'bottom'
                    }
                },
                {
                    element: '.Product_warp.shadow',
                    popover: {
                        title: '點選商品可以更改商品資訊',
                        description: '補貨時直接更改商品數量即可！',
                        position: 'bottom'
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
    @stop 
@section('footer')

@stop