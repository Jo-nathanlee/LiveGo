@extends('layouts.master')

@section('title','會員名單')
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
            <div class="col-md-12">
                <table class="table table-borderles" id="dtAccount">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Facebook 名稱</th>
                            <th>購物次數</th>
                            <th>棄標次數</th>
                            <th>總購物金額</th>
                            <th>評價</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($member as $member)
                        <tr >
                            <td>
                                <img src="https://graph.facebook.com/{{  $member->fb_id }}/picture"
                                    class="rounded-circle user_pic" >
                            </td>
                            <td>{{ $member->fb_name }}</td>
                            <td>{{ $member->checkout_times }}</td>
                            <td>{{ $member->blacklist_times }}</td>
                            <td>{{ $member->money_spent }}</td>
                            <td>
                                <div data-toggle="tooltip" title="得標次數 : {{ $member->checkout_times }} 、 棄標次數 : {{ $member->blacklist_times }}" class="figure ">
                                    <i class="icofont icofont-star"></i>
                                    <i class="icofont icofont-star"></i>
                                    <i class="icofont icofont-star"></i>
                                </div>
                            </td>
                            <td >
                                <a href="{{ route('member_detail',['fb_id' => json_encode($member->fb_id)]) }}"><button type="button" class="btn btn-primary">查看詳情</button></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Cotent end-->
</div>
@stop

@section('footer')
    <script>
        //talbe 分頁
        $("#dtAccount").tablepage($("#table_page"), 10);
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });

    </script>
    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- My JS -->
    <script src="js/Live_go.js" ></script>
    <!-- 我新增的JS -->
    <script src="js/list_mgnt.js"></script>
    <!-- <script src="js/jquery-tablepage-1.0.js"></script> -->
    <!-- <script src="js/moment.js"></script> -->
    <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script> -->
    <!-- DataTable + Bootstrap 4  cdn引用-->
    <script defer src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@stop            