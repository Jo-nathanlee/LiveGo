@extends('layouts.master')

@section('title','月營收')
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
                <table class="table table-striped " id="table_normal">
                    <thead>
                        <tr>
                            <th scope="col">月份</th>
                            <th scope="col">月收益</th>
                            <th scope="col">月成長額</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @for($i=0;$i<(count($month));$i++)
                        <tr>
                            <th scope="row">{{ $month[$i] }}</th>
                            <td>{{ $amount[$i] }}</td>
                            @if($i!=0)
                            <td>{{ (int)($amount[$i])-(int)($amount[$i-1]) }}</td>
                            @else
                            <td>0</td>
                            @endif
                            <td>
                                <button type="button" class="btn btn-info">列印</button>
                            </td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Cotent end-->
</div>
@stop

@section('footer')
 <!-- chart data -->
    <script>
        var chart_title = '2018 強大體育用品 - 月成長報表';
        // 月份(如十月辯十一月時 自動產生 '十一月'))
        var month_data = [];
        // 每個月的總收益
        var month_income_data = [];

        @for($i=0;$i<(count($month));$i++)
            month_data.push('{{ date("Y-m", strtotime( (string)$month[$i]))  }} ');
            month_income_data.push( {{ $amount[$i] }} );
        @endfor

        alert(month_income_data);


        var barChartData = {
            labels: month_data,
            datasets: [{
                label: '月收入',
                backgroundColor: [
                    window.chartColors.red,
                    window.chartColors.orange,
                    window.chartColors.yellow,
                    window.chartColors.green,
                    window.chartColors.blue,
                    window.chartColors.purple,
                    window.chartColors.red
                ],
                yAxisID: 'y-axis-1',
                data: month_income_data 
            }]
        };
        window.onload = function () {
            var ctx = document.getElementById('canvas').getContext('2d');
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    title: {
                        display: true,
                        text: chart_title
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: true
                    },
                    scales: {
                        yAxes: [{
                            type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                            display: true,
                            position: 'left',
                            id: 'y-axis-1',
                        }],
                    }
                }
            });
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