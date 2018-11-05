@extends('layouts.master_mall')

@section('title','Live GO 來福商城')

@section('wrapper')
<div class="wrapper">
    <div id="sidebar_page"></div>
@stop
@section('navbar')
    <!-- Page Content  -->
    <div id="content">
        <div id="navbar_page"></div>
        <!--Nav bar end-->
@stop
@section('content')      
        <div id="main" class="row">
            <div class="col-md-12 bg-gray">
                <a class="mr-4 ml-4">篩選</a>
                <button type="button" class="btn btn-light mr-2">新品</button>
                <button type="button" class="btn btn-light mr-2">熱銷</button>
                <div class="dropdown mr-2">
                    <button class="btn btn-light " type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        價格
                        <i class="icofont icofont-caret-down"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <a class="dropdown-item" href="#!">Action</a>
                        <a class="dropdown-item" href="#!">Another action</a>
                    </div>
                </div>
                <div class="float-right">
                    <small class="align-middle mr-4">
                        <font class="now_page">1</font>/1</small>
                    <div class="list-inline-item align-middle btn btn-light">
                        <i class="icofont icofont-curved-left"></i>
                    </div>
                    <div class="list-inline-item align-middle btn btn-light l-lm-5">
                        <i class="icofont icofont-curved-right"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row" id="shop_product">
                    @foreach($products as $product)
                    <div class="col-md-2 ">
                        <div class="col-md-12 shadow  pb-1 mt-4">
                            <img src="{{$product->pic_url }}">
                            <P class="pt-2">
                                {{$product->goods_name}}
                            </P>
                            <P class="now_page">
                                ${{$product->goods_price}}
                            </P>
                            <div class="row">
                                <small class="col-md-12">
                                    <small class="float-left">
                                        <i class="icofont icofont-heart-alt"></i> 520
                                    </small>
                                    <small class="float-right">
                                        <i class="icofont icofont-star"></i>
                                        <i class="icofont icofont-star"></i>
                                        <i class="icofont icofont-star"></i>
                                        <i class="icofont icofont-star"></i>
                                        <i class="icofont icofont-star"></i> (573)
                                    </small>
                                </small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Cotent end-->
</div>    
@stop

@section('footer')
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
        crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
        crossorigin="anonymous"></script>
    <!-- My JS -->
    <script src="js/Live_go.js"></script>
    <!-- DataTable + Bootstrap 4  cdn引用-->
    <script defer src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@stop