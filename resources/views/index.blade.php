@extends('layouts.master')

@section('title','Live GO 直播')

   
@section('heads')
    <!-- emoji css & js  -->
    <link rel="stylesheet" href="css/emojionearea.css">
    <script src="js/emojionearea.js"></script>
    <script src="js/index_controller.js"></script>
@stop
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
                <div class="col-md-6">
                    <div class="row">
                        <div id="main-top" class="col-md-12 row" >
                            <div class="col-md-7" id="ifrFB">
                                <!-- <iframe src="{!! $url !!}" class="float-left" width="300" height="400" style="border:none;overflow:hidden" scrolling="no"
                                    frameborder="0" allowTransparency="true" allow="encrypted-media" allowFullScreen="true"></iframe> -->
                                    {!! $url !!}
                            </div>
                            <div class="col-md-5" id="croDiv">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">商品名稱 :</span>
                                    </div>
                                    <input type="text" class="form-control" id="goods_name">
                                    <div class="input-group-append dropright">
                                        <button type="button" class="btn btn-outline-secondary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="choose_product">
                                            <i class="icofont icofont-plus"></i>
                                        </button>
                                        <div class="dropdown-menu" id="drp_product">
                                            @foreach($drp_product as $streaming_product)
                                            <a class="dropdown-item" href="#">{{$streaming_product->goods_name}}</a>  
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">成交價格 :</span>
                                    </div>
                                    <input type="text" class="form-control" id="goods_price">
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">商品備註 :</span>
                                    </div>
                                    <input type="text" class="form-control" id="note">
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">得標模式 :</span>
                                    </div>
                                    <select class="custom-select h-100" id="type">
                                        <option class="dropdown-item" value="1" selected>+1</option>
                                        <option class="dropdown-item" value="2">競標</option>
                                    </select>
                                </div>
                                <div class="input-group">
                                    <button type="button" id="time_start" class="btn btn-outline-secondary col-md-12 d-block ">開始競標</button>
                                    <button type="button" id="time_end" class="btn btn-outline-secondary col-md-12 d-none ">結束競標</button>
                                </div>
                            </div>
                        </div>
                        <div id="main-down " class="col-md-12 pt-4">
                            <ul class="list-group float-right border-bottom bid-list " id="buyer_list">
                                <li class="list-group-item list-group-item-action list-group-item-info sticky-top winner_list">
                                    <B>得標清單</B>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div id="fb-comments" class="row">
                        <table class="table" id="table">
                            <tbody class="border-right border-left rounded-top" id="tbody">



                            </tbody>
                            <tfoot class="border">
                                <tr>
                                    <td class="form-inline ">
                                        <div class="col-md-1">
                                            <img src="https://graph.facebook.com/ {!! $page_id !!}/picture"
                                                class="rounded-circle" />
                                        </div>
                                        <div class="col-md-11">
                                            <div id="comment_icon">
                                                <i class="icofont icofont-audio"></i>
                                            </div>
                                            <input type="text" id="comment-message" class="ml-3 mr-4" placeholder="留言 ..." onkeypress="enter_event(event)">

                                            <script type="text/javascript">
                                                $(document).ready(function () {
                                                    $("#comment-message").emojioneArea({
                                                        autocomplete: true,
                                                        tones: true,
                                                        shortnames: true,
                                                        search: false
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cotent end-->
    </div>
@stop 
@section('footer')
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js " integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ "
        crossorigin="anonymous "></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js " integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm "
        crossorigin="anonymous "></script>
    <!-- My JS -->
    <script src="js/Live_go.js "></script>
@stop


