@extends('layouts.master')

@section('title','物流設定')


    @section('wrapper')
<div class="wrapper">
    @stop
    @section('navbar')
    <!-- Page Content  -->
    <div id="content">
        @stop
        @section('content')
        <div class="container-fluid all_content overflow-auto" id="LogisticsSetting">
            <div class="row">
                <form class="w-100">
                {{ csrf_field() }}
                @foreach($ship_set as $ship_set)
                    @if( $ship_set->ship_id < 50 || $ship_set->ship_id > 80)
                        <div class="col-md-12" id="{{ $ship_set->ship_type }}">
                            <div class="media bg-white p-4 rounded border">
                                <div class="media-body">
                                    {{ $ship_set->ship_type }}
                                </div>
                                <div class="mr-4" data-toggle="tooltip" data-placement="top" title="點選修改運費金額" onclick="Edit_Delivery_Price(this)">
                                    
                                    <span class="currencyField">{{ $ship_set->ship_price }}</span>
                                    <input type="hidden" value="{{ $ship_set->ship_id }}">
                                    <i class='fas'>&#xf044;</i>
                                </div>
                                <div class="m-auto">
                                    <div class="custom-control custom-checkbox">
                                        @if ($ship_set->is_active == 'true')
                                            <input type="checkbox"  class="custom-control-input is-active" ship_id="{{ $ship_set->ship_id }}" id="{{ $ship_set->ship_id }}" checked>
                                            <label class="custom-control-label" for="{{ $ship_set->ship_id }}"></label>
                                        @else
                                            <input type="checkbox" class="custom-control-input is-active" ship_id="{{ $ship_set->ship_id }}" id="{{ $ship_set->ship_id }}">
                                            <label class="custom-control-label" for="{{ $ship_set->ship_id }}"></label>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        @if($if_ecpay == 'true')
                        <div class="col-md-12" id="{{ $ship_set->ship_type }}">
                            <div class="media bg-white p-4 rounded border">
                                <div class="media-body">
                                    {{ $ship_set->ship_type }}
                                </div>
                                <div class="mr-4" >
                                    
                                </div>
                                <div class="m-auto">
                                    <div class="custom-control custom-checkbox">
                                        @if ($ship_set->is_active == 'true')
                                            <input type="checkbox"  class="custom-control-input is-active" ship_id="{{ $ship_set->ship_id }}" id="{{ $ship_set->ship_id }}" checked>
                                            <label class="custom-control-label" for="{{ $ship_set->ship_id }}"></label>
                                        @else
                                            <input type="checkbox" class="custom-control-input is-active" ship_id="{{ $ship_set->ship_id }}" id="{{ $ship_set->ship_id }}">
                                            <label class="custom-control-label" for="{{ $ship_set->ship_id }}"></label>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                        </div> 
                        @endif
                    @endif
                @endforeach
                </form>
            </div>
        </div>
    </div>
    <!-- Cotent end-->
</div>
<script>
    $( document ).ready(function() {
        const driver = new Driver();

        driver.defineSteps([
                // {
                //     element: '.col-md-12',
                //     popover: {
                //         title: '輸入滿額免運費優惠',
                //         description: '可以搭配加價購商品來提升銷售量'   ,
                //         position: 'bottom'
                //     }
                // },
                {
                    element: '.media .mr-4',
                    popover: {
                        title: '點選設定金額',
                        description: '輸入金額',
                        position: 'left-bottom'
                    }
                },
                {
                    element: '.media .m-auto',
                    popover: {
                        title: '是否開啟',
                        description: '勾選後為開啟此選項',
                        position: 'left-bottom'
                    }
                },
                {
                    element: '#本島常溫宅配',
                    popover: {
                        title: '設定運送模式',
                        description: '必須開啟一個選項，否則買家無法結帳',
                        position: 'bottom'
                    }
                },
                
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
    
@stop