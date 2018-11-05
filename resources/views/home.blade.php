@extends('layouts.app')

@section('content')
@if (session('alert'))
    <div class="alert alert-success">
        {{ session('alert') }}
    </div>
@endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                   <a href="{{ route('set_page') }}">Set Page</a><br>
                   <a href="{{ route('index_load') }}">Start Live Streaming</a><br>
                   <a href="{{ route('buyer_index') }}">Buyer</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


