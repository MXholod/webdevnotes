@extends('layouts.app')

@section('title',$title ?? "404")
@section('meta_description'){{ $meta_description ?? "Error 404"}} @endsection
@section('meta_keywords'){{ $meta_keywords ?? "Error 404"}} @endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div>{!!$description ?? "404" !!}</div>
                @if(isset($exception) && !isset($description))
                    <p>{{$exception->getMessage()}}</p>
                @endif
                <div>{!!$full_text ?? "Error 404"!!}</div>
                <div style="text-align:center;font-size:32px;font-weight:bold;">
                    {{$status ?? $exception->getMessage()}}
                </div>
            </div>
        </div>
    </div>
@endsection