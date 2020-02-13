@extends('layouts.master')

@section('title','日營收')
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
    <!-- Page Content  -->
    <div id="content">
        <!--Nav bar end-->
        @stop
        @section('content')
        <div class="container-fluid all_content overflow-auto" id="Day_Neticome">
            <div class="row">
                <div class="col-md-7 all_content">
                    <canvas id="canvas"></canvas>
                </div>
                <div class="col-md-5 all_content  overflow-auto">
                    <table class="table table-striped " id="table_source">
                        <thead>
                            <tr>
                                <td class="d-none">1</td>
                                <th scope="col">日期</th>
                                <th scope="col">日收益</th>
                                <th scope="col">日成長額</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i=0;$i<(count($date));$i++)
                            <tr>
                                <td class="d-none">1</td>
                                <th scope="row">{{ $date[$i] }}</th>
                                <td>{{ $amount[$i] }}</td>
                                @if(($i+1)!=count($date))
                                    <td>{{ (int)($amount[$i])-(int)($amount[$i+1]) }}</td>
                                @else
                                    <td>0</td>
                                @endif
                                @if($amount[$i]!=0)
                                    <td>
                                        <a href="{{route('daily_revenue_pdf', ['key' =>$date[$i] ])}}" class="btn btn-info">列印</a>
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
    <!-- Cotent end-->
</div>
<script>
    $( document ).ready(function() {
        const driver = new Driver();

        driver.defineSteps([
                {
                    element: '#canvas',
                    popover: {
                        title: '日成長報表',
                        description: '可以觀看每日收益情形，進而分析直播適合日期與時間',
                        position: 'right'
                    }
                },
                {
                    element: '.dataTables_length',
                    popover: {
                        title: '選取資料筆數',
                        description: '調整日營收筆數',
                        position: 'bottom'
                    }
                },
                {
                    element:'#table_source_filter',
                    popover: {
                        title: '快速尋找日期',
                        description: '只需輸入關鍵字即可！',
                        position: 'bottom'
                    }
                },
                {
                    element: '#table_source',
                    popover: {
                        title: '查看每日收益情況',
                        description: '可以查看每日營收資訊',
                        position: 'left'
                    }
                },
                {
                    element: '.btn.btn-info',
                    popover: {
                        title: '點選列印',
                        description: '列印當日收益情形，如無收益則無法列印',
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
<script src="js/Chart.bundle.min.js"></script>
    <script src="js/utils.js"></script>
    <script>
        var day_income_data = [];
        var average_income_data = [];
        var chart_title = 'Watch Live Boxer - 日成長報表';


        
        var daily_date=[];
        @for($i=0;$i<(count($date));$i++)
            daily_date.push('{{ date("m-d", strtotime( (string)$date[$i]))  }} ');
            day_income_data.push( {{ $amount[$i] }} );
        @endfor
        daily_date = daily_date.reverse();
        day_income_data= day_income_data.reverse();
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

@stop            