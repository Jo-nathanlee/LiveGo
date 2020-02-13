@extends('layouts.master')

@section('title','您沒有粉絲團!')

@section('wrapper')
<div class="wrapper">
@stop
    <!-- Page Content  -->
    @section('navbar')   
    <div id="content">     
            <!--Nav bar end-->
        @stop
        @section('content')     
        @if (session('alert'))
        <script>
            message_danger();
        </script>
        @endif       
        <div class="container-fluid all_content overflow-auto" id="ChooseFanGroup">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">請前往facebook新增一個粉絲團</h4>
                        Please go to facebook and create a fan page.
                    </div>
                </div>
            </div>
        </div>
        <!-- Cotent end-->
    </div>
</div>
@stop 
@section('footer')

@stop
