@extends('layouts.master')

@section('title','付款方式設定')


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
                @foreach($pay_methods as $pay_methods)
                    <div class="col-md-12">
                        <div class="media bg-white p-4 rounded border">
                            <div class="media-body">
                                {{ $pay_methods->pay_cht }}
                            </div>
                            <div class="m-auto">
                                <div class="custom-control custom-checkbox">
                                    @if ($pay_methods->is_active == 'true')
                                        <input type="checkbox"  class="custom-control-input set_pay" pay_id="{{ $pay_methods->pay_id }}" id="{{ $pay_methods->pay_id }}" checked>
                                        <label class="custom-control-label" for="{{ $pay_methods->pay_id }}"></label>
                                    @endif
                                    @if ($pay_methods->is_active == 'false')
                                        <input type="checkbox" class="custom-control-input set_pay" pay_id="{{ $pay_methods->pay_id }}" id="{{ $pay_methods->pay_id }}">
                                        <label class="custom-control-label" for="{{ $pay_methods->pay_id }}"></label>
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </form>
                <label style="margin:0px auto;">若未勾選任何一個選項，將預設為信用卡</label>
            </div>
        </div>
    </div>
    <!-- Cotent end-->
</div>
@stop 
@section('footer')
    
@stop