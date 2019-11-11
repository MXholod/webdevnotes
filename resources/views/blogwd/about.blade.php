@extends('layouts.app')

@section('title', $pageData->title)
@section('meta_description') {{$pageData->meta_description}} @endsection
@section('meta_keywords') {{$pageData->meta_keywords}} @endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <h2>{!! $pageData->description !!}</h2>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <h2>{!! $pageData->full_text !!}</h2>
            </div>
        </div>
    </div>
@endsection