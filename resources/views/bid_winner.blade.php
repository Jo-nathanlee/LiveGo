@extends('layouts.master')

@section('title','得標者清單')
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
        <div id="bidder_list" class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                @if(count($winner)==0)
                    <table id="table_source" class="table text-truncate table_source">
                        <thead>
                            <tr>
                                <th></th>
                                <th>得標者姓名</th>
                                <th>商品圖片</th>
                                <th>得標商品</th>
                                <th>得標金額</th>
                                <th>得標數量</th>
                                <th>得標總價</th>
                                <th>留言內容</th>
                                <th>備註</th>
                                <th>得標時間</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="10" class="text-center">無資料</td>
                            </tr>
                        </tbody>
                    </table>
                @else
                <table id="table_source" class="table text-truncate table_source">
                    <thead>
                        
                            <tr>
                                <th></th>
                                <th>得標者姓名</th>
                                <th>商品圖片</th>
                                <th>得標商品</th>
                                <th>得標金額</th>
                                <th>得標數量</th>
                                <th>得標總價</th>
                                <th>留言內容</th>
                                <th>備註</th>
                                <th>得標時間</th>
                            </tr>
                    </thead>
                    <tbody>
                            @foreach($winner as $winner)
                                <tr>
                                    <td><img src="https://graph.facebook.com/{{  $winner->fb_id }}/picture" class="rounded-circle user_pic" ></td>
                                    <td>{{$winner->name}}</td>
                                    <td> <img id="order_img" src="{{$winner->pic_path}}" style="height:50px;width:50px" ></td>
                                    <td>{{$winner->goods_name}}</td>
                                    <td>{{$winner->goods_price}}</td>
                                    <td>{{$winner->goods_num}}</td>
                                    <td>{{$winner->total_price}}</td>
                                    <td>{{$winner->comment}}</td>
                                    <td>{{$winner->note}}</td>
                                    <td>{{$winner->created_time}}</td>
                                </tr>
                            @endforeach
                    </tbody>
                </table>                       
                @endif
                <!-- 頁碼 -->
                <span id="list_table_page" class="list_table_page"></span>
                <!-- 頁碼end -->
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
