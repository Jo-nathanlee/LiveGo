@extends('layouts.master')

@section('title','Live GO 我的訂單')

   
@section('heads')
    <!-- 我新增的 CSS -->
    <link rel="stylesheet" href="css/list_mgnt.css">
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
    <div id="content" class="Microsoft">
        <div id="navbar_page"></div>
        <!--Nav bar end-->
@stop
@section('content')
        <div class="container-fluid mt-3 mb-3 ">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="media">
                        <img class="d-flex mr-3 rounded-circle user_pic" src="https://graph.facebook.com/{{ $order_detail->buyer_fbid }}/picture">
                        <div class="media-body">
                            <h5 class="mt-0">
                                <font class="text-secondary"><b>{{ $order_detail->buyer_fbname }}</b></font>
                            </h5>
                            <font class="text-secondary">{{ $order_detail->buyer_fbid }}</font>
                        </div>
                    </div>
                  