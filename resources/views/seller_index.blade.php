@extends('layouts.master')

@section('title','Live GO')
@section('heads')
    <!--chart js-->
    <script src="js/Chart.bundle.js"></script>
    <script src="js/utils.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
@stop

@section('wrapper')
<div class="wrapper">
    <div class="chart_place d-none" id="Chart_Place">
        <div class="chart_content" id="Chart_Content"> 
        </div>
    </div>
    <div id="sidebar_page"></div>
@stop
@section('navbar')
    <!-- Page Content  -->
    <div id="content">
        <div id="navbar_page"></div>
        <!--Nav bar end-->
@stop
@section('content')
 <!-- main -->
 <div class="main bg-light shadow">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <i class="icofont icofont-eye-alt h1 d-flex align-self-center mr-3"></i>
                            <div class="media-body">
                                <h5 class="mt-0">粉絲瀏覽次數</h5>
                                123
                                <small class="text-black-50 ml-2">( 粉絲專頁總瀏覽次數
                                    <font class="text-success">▲123</font> )</small>
                            </div>
                            <div class="d-flex ml-3 align-self-center">
                                <button type="button" class="btn btn-outline-dark " onclick="Line_chart('粉絲遊覽次數', [ '1/1' , '1/2', '1/3', '1/4'],[1, 1, 1, 1])">
                                    <i class="icofont icofont-chart-histogram mr-2 "></i>點選查看</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <i class="icofont icofont-look h1 d-flex align-self-center mr-3"></i>
                            <div class="media-body">
                                <h5 class="mt-0">粉絲專業預覽</h5>
                                132
                                <small class="text-black-50 ml-2">( 粉絲專頁總遊覽次數
                                    <font class="text-success">▲123</font> )</small>
                            </div>
                            <div class="d-flex ml-3 align-self-center">
                                <button type="button" class="btn btn-outline-dark" onclick="Line_chart('粉絲遊覽次數', [ '2/1' , '1/2', '1/3', '1/4'],[1, 1, 1, 1])">
                                    <i class="icofont icofont-chart-histogram mr-2"></i>點選查看</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <i class="icofont icofont-like h1 d-flex align-self-center mr-3"></i>
                            <div class="media-body">
                                <h5 class="mt-0">粉絲專業的讚</h5>
                                9453
                                <small class="text-black-50 ml-2">( 粉絲專頁總遊覽次數
                                    <font class="text-success">▲123</font> )</small>
                            </div>
                            <div class="d-flex ml-3 align-self-center">
                                <button type="button" class="btn btn-outline-dark"  onclick="Line_chart('粉絲遊覽次數', [ '2/1' , '1/2', '1/3', '1/4'],[1, 1, 1, 1])">
                                    <i class="icofont icofont-chart-histogram mr-2"></i>點選查看</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <i class="icofont icofont-touch h1 d-flex align-self-center mr-3"></i>
                            <div class="media-body">
                                <h5 class="mt-0">觸及人數</h5>
                                69
                                <small class="text-black-50 ml-2">( 粉絲專頁總遊覽次數
                                    <font class="text-success">▲123</font> )</small>
                            </div>
                            <div class="d-flex ml-3 align-self-center">
                                <button type="button" class="btn btn-outline-dark" onclick="Line_chart('粉絲遊覽次數', [ '1/1' , '1/2', '1/3', '1/4'],[1, 1, 1, 1])">
                                    <i class="icofont icofont-chart-histogram mr-2"></i>點選查看</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <i class="icofont icofont-speech-comments h1 d-flex align-self-center mr-3"></i>
                            <div class="media-body">
                                <h5 class="mt-0">貼文互動次數</h5>
                                888
                                <small class="text-black-50 ml-2">( 粉絲專頁總遊覽次數
                                    <font class="text-success">▲123</font> )</small>
                            </div>
                            <div class="d-flex ml-3 align-self-center">
                                <button type="button" class="btn btn-outline-dark" onclick="Line_chart('粉絲遊覽次數', [ '1/1' , '1/2', '1/3', '1/4'],[1, 1, 1, 1])">
                                    <i class="icofont icofont-chart-histogram mr-2"></i>點選查看</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <i class="icofont icofont-ui-video-play h1 d-flex align-self-center mr-3"></i>
                            <div class="media-body">
                                <h5 class="mt-0">影片</h5>
                                96
                                <small class="text-black-50 ml-2">( 粉絲專頁總遊覽次數
                                    <font class="text-success">▲123</font> )</small>
                            </div>
                            <div class="d-flex ml-3 align-self-center">
                                <button type="button" class="btn btn-outline-dark"  onclick="Line_chart('粉絲遊覽次數', [ '1/1' , '1/2', '1/3', '1/4'],[1, 1, 1, 1])">
                                    <i class="icofont icofont-chart-histogram mr-2"></i>點選查看</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <i class="icofont icofont-rss-feed h1 d-flex align-self-center mr-3"></i>
                            <div class="media-body">
                                <h5 class="mt-0">粉絲專頁追蹤者</h5>
                                123
                                <small class="text-black-50 ml-2">( 粉絲專頁總遊覽次數
                                    <font class="text-success">▲123</font> )</small>
                            </div>
                            <div class="d-flex ml-3 align-self-center">
                                <button type="button" class="btn btn-outline-dark" onclick="Line_chart('粉絲遊覽次數', [ '1/1' , '1/2', '1/3', '1/4'],[1, 1, 1, 1])" >
                                    <i class="icofont icofont-chart-histogram mr-2 Fan_visits"></i>點選查看</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- main end -->
        </div>

    </div>
@stop 
@section('footer')
<!-- jQuery CDN - Slim version (=without AJAX) -->
<script>
        // 標題 ， 資料 ， 日期
        function Line_chart(date_type, labels_item , date_item) {
            var config = {
                type: 'line',
                data: {
                    labels: labels_item,
                    datasets: [{
                        label: date_type,
                        backgroundColor: window.chartColors.blue,
                        borderColor: window.chartColors.blue,
                        data: date_item,
                        fill: false,
                        borderDash: [5, 5],
                    }]
                }
            };

                $("#Chart_Content").prepend(" <canvas id='canvas'>");
                var ctx = document.getElementById('canvas').getContext('2d');
                window.myLine = new Chart(ctx, config);
                $('#canvas').addClass("pb-5");
            $("#Chart_Place").removeClass("d-none");
        };

        $(".chart_place").click(function () {
            $("#Chart_Place").addClass("d-none");
        });

    </script>
    <!--   -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
        crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
        crossorigin="anonymous"></script>
    <!-- copping picture js -->
    <script src="js/Cropping.js"></script>
    <!-- My JS -->
    <script src="js/Live_go.js"></script>
    <script defer src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@stop