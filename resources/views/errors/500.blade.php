@extends('layouts.app')

@section('title',$title)
@section('meta_description'){{ $meta_description }} @endsection
@section('meta_keywords'){{ $meta_keywords }} @endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <h2>{{$description}}</h2>
                @if(isset($exception))
                    <p>{{$exception->getMessage()}}</p>
                @endif
                <p>{{$full_text}}</p>
                <div style="text-align:center;font-size:32px;font-weight:bold;">
                    {{$status}}
                </div>
            </div>
        </div>
    </div>
@endsection