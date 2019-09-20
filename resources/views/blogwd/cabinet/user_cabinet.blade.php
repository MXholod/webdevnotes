@extends('layouts.app')

@section('content')

    <h1>User's cabinet</h1>
    @if(Auth::check())
        <p>Hello {{ Auth::user()->login }} this is your cabinet</p>
    @endif
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        You are logged in!
    </div>
@endsection