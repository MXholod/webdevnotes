@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User's cabinet</h1>
    @if(Auth::check())
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <p>Hello {{ Auth::user()->login }} this is your cabinet</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8 col-md-12 col-lg-12 col-xl-12">
              <p>{{ Auth::user() }}</p>
            </div>
            <div class="col-sm-4 col-md-12 col-lg-12 col-xl-12">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                You are logged in!
            </div>
        </div>
    @endif
        <div class="row">
            <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
              
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <h3>{{ Auth::user()->login }}, это твои роли:</h3>
                <ul>
                    @foreach(Auth::user()->roles as $role)
                        <li>{{ $role->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection