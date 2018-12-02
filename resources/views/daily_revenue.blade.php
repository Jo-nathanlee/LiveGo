@extends('layouts.master')

@section('title','日營收')
@section('heads')
    <!-- datatable + bootstrap 4  -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <!--chart js-->
    <script src="js/Chart.bundle.js"></script>
    <script src="js/utils.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <style>
        canvas {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
        }
    </style>
   
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
            <div class="col-offset-1 col-md-10 chartheight mb-4">
                <canvas id="canvas"></canvas>
            </div>
            <div class="col-offset-1 col-md-10 charttable mb-4">
                <table class="table table-striped " id="table_source">
                    <thead>
                        <tr>
                            <th scope="col">日期</th>
                            <th scope="col">日收益</th>
                            <th scope="col">日成長額</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i=0;$i<(count($date));$i++)
                        <tr>
                            <th scope="row">{{ $date[$i] }}</th>
                            <td>{{ $amount[$i] }}</td>
                            <td>/</td>
                            <td>
                                <button type="button" class="btn btn-info">列印</button>
                            </td>
                        </tr>
                       @endfor
                       <?php echo $date[0];?>
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

        var day_income_data = [];
        var average_income_data = [];
        var chart_title = '2018 強大體育用品 - 月成長報表';


        
        var daily_date=[];
        console.log(<?php echo $date[0];?>);
        @for($i=0;$i<(count($date));$i++)
            daily_date.push( {{ date("m-d", strtotime($date[$i]))  }} );
            day_income_data.push( {{ $amount[$i] }} );
        @endfor

        var average_income=0;
        for(var i =0;i<day_income_data.length;i++){
            average_income+=parseInt(day_income_data[i]);
        }
        for(var i =0;i<day_income_data.length;i++){
            average_income_data.push(average_income/(day_income_data.length));
        }
        
            // 5 取代 平均值


        var config = {
            type: 'line',
            data: {
                labels: daily_date,
                datasets: [{
                    label: '平均收益',
                    backgroundColor: window.chartColors.gray,
                    borderColor: window.chartColors.gray,
                    data: average_income_data,
                    fill: false,
                    borderDash: [5, 5],
                }, {
                    label: '當天收益',
                    fill: false,
                    backgroundColor: window.chartColors.blue,
                    borderColor: window.chartColors.blue,
                    data: day_income_data,
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                title: {
                    display: true,
                    text: chart_title
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: '日期'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: '收益'
                        }
                    }]
                }
            }
        };

        window.onload = function () {
            var ctx = document.getElementById('canvas').getContext('2d');
            window.myLine = new Chart(ctx, config);
        };

    </script>
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