@extends('layouts.master_demo')

@section('title','綁定粉絲團')

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
            <form id="Chose_fan" action="{{ route('save_page') }}" method="POST">
                {{ csrf_field() }} 
                @foreach($page as $key)
                <div class="media bg-white p-4 rounded border">
                    <img class="d-flex mr-3" src="{{$key[2]}}">
                    <div class="media-body">
                        <h5 class="mt-0">{{$key[0]}}</h5>
                        粉絲團ID：{{$key[1]}}
                    </div>
                    <div class="m-auto">
                        <div class="custom-control custom-checkbox">
                            <!-- if($key[4])
                            <input type="checkbox" class="custom-control-input"  id="{{$key[1]}}" name="id" value="{{$key[1]}},{{$key[0]}},{{$key[3]}},{{$key[2]}}" checked>
                            else -->
                            <input type="checkbox" class="custom-control-input"  id="{{$key[1]}}" name="id" value="{{$key[1]}},{{$key[0]}},{{$key[3]}},{{$key[2]}}">
                            <!-- endif -->
                            <!--id擺放粉絲團ID-->
                            <label class="custom-control-label" for="{{$key[1]}}"></label>
                            <!--for擺放粉絲團ID-->
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="text-center mt-2">
                    <input type="submit" class="btn btn-secondary " value="確定">
                </div>
            </form>
        </div>
    </div>
</div>

     </div>
</div>
@stop 
@section('footer')

@stop