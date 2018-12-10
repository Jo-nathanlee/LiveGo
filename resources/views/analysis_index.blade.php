@extends('layouts.master')

@section('title','我的訂單')

   
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
  <!-- main -->
        <div class="main bg-light shadow">
            <h3 class="m-3">聲量趨勢分析</h3>
            <hr>
            <div class="row main">
                <div class="col-12 col-md-12">
                    <iframe src="{{ route('analysis') }}" scrolling="no"  style="border:none;height: 70vh" class="w-100" ></iframe>
                </div>
            </div>
        </div>
        <!-- main end -->
@stop
@section('footer')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
            crossorigin="anonymous"></script>
        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
            crossorigin="anonymous"></script>
        <!-- My JS -->
        <script src="js/Live_go.js"></script>
        <!-- 我新增的JS -->
        <script src="js/list_mgnt.js"></script>
        <!-- DataTable + Bootstrap 4  cdn引用-->
        <script defer src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script defer src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@stop