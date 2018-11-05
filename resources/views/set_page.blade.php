@extends('layouts.master')

@section('title','Live GO 綁定粉絲團')

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
    <div class="alert alert-success">
        {{ session('alert') }}
    </div>
@endif       
        <div id="main" class="row">
            <div class="col-md-12">
                <h1 class="text-center"> 選擇綁定粉絲團</h1>
                <form id="Chose_fan" action="{{ route('save_page') }}" method="POST">
                    {{ csrf_field() }} @foreach($page as $key)
                    <div id="fan-group" class="col-md-12">
                        <div class="media border-bottom">
                            <img class="d-flex mr-3" src="{{$key[2]}}" alt="Generic placeholder image">
                            <div class="media-body">
                                <h5 class="mt-0">{{$key[0]}}</h5>
                                {{$key[1]}}
                            </div>
                            <div class="custom-control custom-checkbox d-flex align-self-center">
                                <input type="checkbox" class="custom-control-input" id="{{$key[1]}}" name="id" value="{{$key[1]}},{{$key[0]}},{{$key[3]}},{{$key[2]}}">
                                <label class="custom-control-label text-muted" for="{{$key[1]}}"></label>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="text-center">
                        <input type="submit" class="btn btn-secondary " value="確定">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Cotent end-->
</div>
@stop 
@section('footer')
    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
        crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
        crossorigin="anonymous"></script>
    <!-- My JS -->
    <script src="js/Live_go.js"></script>
@stop
