@extends('layouts.master')

@section('title','月營收')
@section('heads')
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
@stop
@section('navbar')
    <div id="content">
    @stop
    @section('content')
    @if (session('alert'))
    <script>
        message_danger();
    </script>
    @endif
        <div class="container-fluid all_content overflow-auto" id="Day_Neticome">
            <div class="row">
                <div class="col-md-7 all_content">
                    <canvas id="canvas"></canvas>
                </div>
                <div class="col-md-5 all_content  overflow-auto">
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
                                @if( $amount[$i]!=0)
                                <td>
                                <a href="{{route('daily_revenue_pdf', ['key' =>$month[$i] ])}}" class="btn btn-info">列印</a>
                                </td>
                                @else
                                    <td>
                                        <button type="button" class="btn btn-info" disabled>列印</button>
                                    </td>
                                @endif
                            </tr>
                             @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $( document ).ready(function() {
        const driver = new Driver();

        driver.defineSteps([
                {
                    element: '#canvas',
                    popover: {
                        title: '月成長報表',
                        description: '可以觀看每月收益情形',
                        position: 'right'
                    }
                },
                {
                    element: '.dataTables_length',
                    popover: {
                        title: '選取資料筆數',
                        description: '調整月營收筆數',
                        position: 'bottom'
                    }
                },
                {
                    element:'#table_normal_filter',
                    popover: {
                        title: '快速尋找日期',
                        description: '只需輸入關鍵字即可！',
                        position: 'bottom'
                    }
                },
                {
                    element: '#table_normal',
                    popover: {
                        title: '查看每月收益情況',
                        description: '可以查看每月營收資訊',
                        position: 'left'
                    }
                },
                {
                    element: '.btn.btn-info',
                    popover: {
                        title: '點選列印',
                        description: '列印當月收益情形，如無收益則無法列印',
                        position: 'left-bottom'
                    }
                }
            ]);

        document.querySelector('#help_me').addEventListener('click', function (e) {
            e.preventDefault();
        e.stopPropagation();
        driver.start();
        });
    });

   
</script>
@stop

@section('footer')
 <!-- chart data -->
    <script src="js/Chart.bundle.min.js"></script>
    <script src="js/utils.js"></script>
    <script>
        var chart_title = 'Watch Live Boxer - 月成長報表';
        // 月份(如十月辯十一月時 自動產生 '十一月'))
        var month_data = [];
        // 每個月的總收益
        var month_income_data = [];

        @for($i=0;$i<(count($month));$i++)
            month_data.push('{{ date("Y-m", strtotime( (string)$month[$i]))  }} ');
            month_income_data.push( {{ $amount[$i] }} );
        @endfor


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

@stop  