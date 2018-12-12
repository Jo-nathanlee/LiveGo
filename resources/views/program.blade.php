@extends('layouts.master_mall')

@section('title','節目表')
@section('heads')
    <!-- datatable + bootstrap 4  -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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
@if (session('alert'))
<script>
    message_danger();
</script>
@endif   
        <div id="main" class="row">
            <div class="col-md-12" id="Video_Shop">
                <!-- <div class="row"> -->
                    <!-- <div id="Slidebox" class="col-md-7">
                        <div id="carousel-shop" class="carousel slide " data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carousel-shop" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel-shop" data-slide-to="1"></li>
                            </ol>
                            <div class="carousel-inner" role="listbox">
                                <div class="carousel-item active">
                                    <img class="d-block w-100" data-src="holder.js/900x300?auto=yes&amp;bg=777&amp;fg=555&amp;text=First slide" alt="First slide [900x300]"
                                        src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22900%22%20height%3D%22300%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20900%20300%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_16487cfd3b8%20text%20%7B%20fill%3A%23555%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A45pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_16487cfd3b8%22%3E%3Crect%20width%3D%22900%22%20height%3D%22300%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22308.296875%22%20y%3D%22170.15625%22%3EFirst%20slide%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E"
                                        data-holder-rendered="true">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h3>First slide label</h3>
                                        <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" data-src="holder.js/900x300?auto=yes&amp;bg=666&amp;fg=444&amp;text=Second slide" alt="Second slide [900x300]"
                                        src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22900%22%20height%3D%22300%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20900%20300%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_16487cfd3bb%20text%20%7B%20fill%3A%23444%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A45pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_16487cfd3bb%22%3E%3Crect%20width%3D%22900%22%20height%3D%22300%22%20fill%3D%22%23666%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22264.953125%22%20y%3D%22170.15625%22%3ESecond%20slide%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E"
                                        data-holder-rendered="true">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h3>Second slide label</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                    </div>
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carousel-shop" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carousel-shop" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div> -->
                    <!-- <div class="col-md-5">
                        <div class="text-center">
                            <video controls id="ad_vdo" src="https://www.youtube.com/embed/N5BICBjffik">
                                <source src="https://www.youtube.com/embed/N5BICBjffik" type="video/mp4">
                                <source src="https://www.youtube.com/embed/N5BICBjffik" type="video/ogg"> Your browser does not support HTML5 video.
                            </video>
                        </div>
                    </div>
                </div>
                <hr> -->
                @if(isset($arr))
                <?php

                $arr = json_decode($arr);
                ?>
                @foreach($arr as $page)

                <div class="row">
                    <div class="col-md-2 mt-4 ">
                        <div class="col-md-12 shadow pt-3 pb-2">
                            <!-- <iframe src="{{ $page->url }}"
                                allowTransparency="true" allowFullScreen="true" class="video_list_item"></iframe> -->
                                <?php
                                dd($page->url);
                            ?>
                                {{ $page->url }}

                            <p class="video_shoptxt">
                               
                            </p>
                         
                            <h6 class="mb-2 text-muted">{{ $page->page_name }}</h6>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
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
<script src="js/list_mgnt.js"></script>
<!-- DataTable + Bootstrap 4  cdn引用-->
<script defer src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script defer src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@stop