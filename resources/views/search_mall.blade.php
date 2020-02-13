@extends('layouts.master_mall')

@section('title','來福商城')

@section('wrapper')
    <div class="wrapper">
@stop

    <div id="content">
        <!-- Page Content  -->
        <div id="content" style="background-color: #F5F5F5	">
            <div class="container">
                <div class="card rounded-0">
                    @section('navbar')
                    <div class="card-body p-0">
                    @stop
                        @section('content')
                        <!-- <div class="row justify-content-center">
                            <div class="col-md-10">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                      <a class="nav-link active" href="#!">全部</a>
                                    </li>
                                    <li class="nav-item">
                                      <a class="nav-link text-muted" href="#!">運動用品</a>
                                    </li>
                                    <li class="nav-item">
                                      <a class="nav-link text-muted" href="#!">XX用品</a>
                                    </li>
                                  </ul>
                            </div>
                        </div> -->
                        <div class="row text-center" style="min-height: 100vh ">
                            <div class="col-md-12">
                                <div class="data-container ml-0"></div>
                                <div id="pagination-demo1" class="pr-4 mr-4 float-right"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
        crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="js/bootstrap.min.js"></script>
    <!-- EMOJI JS -->
    <script src="js/emojionearea.js"></script>
    <!-- DataTable JS -->
    <script src="js/dataTables.min.js"></script>
    <!-- alterty JS -->
    <script src="js/alertify.js"></script>
    <!-- Chart js -->
    <script src="js/Chart.bundle.js"></script>
    <script src="js/utils.js"></script>
    <script src="js/pagination.js"></script>
    <!--My js-->
    <script src="js/main.js"></script>
    <script>
        $(function () {
            (function (name) {
                var container = $('#pagination-' + name);
                var sources = function () {
                    var result = [];

                    @foreach($products as $product)
                        result.push('<div class="Product shadow " data-index="' +
                            '{{$product->goods_name}}' + '" onclick="location.href=' +
                            'google.com.tw' + ';"><div class="Product_Img "  style="background-image: url(' +
                            '{{$product->pic_url }}' + ')"></div><div class="Product_Content pt-3"><P class="text-truncate">商品名稱： ' +
                            '{{$product->goods_name}}' + '</P><P class="text-truncate">商品價格：<a class="text-danger">$' +
                            '{{$product->goods_price}}' + '</a></P class="text-truncate"><small class="text-black-50">剩餘數量：' +
                            '{{$product->goods_num}}' + '</small><br><small class="text-black-50 text-truncate">銷售數量：' +
                            '{{$product->selling_num}}' + '</small></div></div>');
                    @endforeach
                   
                    return result;
                }();

                var options = {
                    dataSource: sources,
                    callback: function (response, pagination) {
                        var dataHtml = "";
                        $.each(response, function (index, item) {
                            dataHtml += item;
                        });
                        container.prev().html(dataHtml);
                    }
                };

                //$.pagination(container, options);
                container.pagination(options);


            })('demo1');

        })
    </script>
    <script>
        $(document).ready(function () {
            if (parseInt($("#msg_number").text()) > 99) {
                $("#msg_number").text('99+');
            }
        });
    </script>
@stop