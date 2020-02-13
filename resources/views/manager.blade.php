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
                        <form action="{{ route('save_manager') }}"  enctype="multipart/form-data" method="POST">
                            {{ csrf_field() }}
                            <h4 class="card-title text-center">使用者清單</h4>
                            <ul class="list-group list-group-flush">
                                @foreach($user as $user)
                                <li class="list-group-item">
                                    <input type="checkbox" name="id" value="{{ $user->fb_id }},{{ $user->name }}" aria-label="Checkbox for following text input"> 
                                    <img class="d-inline-box mr-3" src="https://graph.facebook.com/{{  $user->fb_id }}/picture">

                                    {{ $user->name }}
                                </li>
                                @endforeach
                            </ul>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success">確認</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <h4 class="card-title text-center">系統權限者清單</h4>
                        <ul class="list-group list-group-flush">
                            @foreach($page as $page)
                            <li class="list-group-item">                                   
                                 <img class="d-inline-box mr-3" src="https://graph.facebook.com/{{  $page->fb_id }}/picture">
                                    {{ $page->name }}
                            </li>
                            @endforeach
                        </ul>
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