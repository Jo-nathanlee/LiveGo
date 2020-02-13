@extends('layouts.master')

@section('title','新增權限')
@section('heads')
@stop

@section('wrapper')
<div class="wrapper">
@stop
@section('navbar') 
    <!-- Page Content  -->
    <div id="content">
    @stop
    @section('content')
        <div class="container-fluid all_content overflow-auto" id="List_Manage_Detail">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <form action="/allpayCheckout"  enctype="multipart/form-data" method="POST">
                            {{ csrf_field() }}
                            <div class="text-center">
                                <button type="submit" class="btn btn-success">確認</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>     
        </div>
    </div>
    <!-- Cotent end-->
</div>
@stop

@section('footer')

@stop            