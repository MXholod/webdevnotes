@extends('layouts.app')

@section('title') {{$post->title}} @endsection
@section('meta_description') {{$post->meta_description}} @endsection
@section('meta_keywords') {{$post->meta_keywords}} @endsection

@section('content')

    <div class="container">
        
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                   <h2>{{$post->title}}</h2>
                    <div>
                        {!! $post->full_text !!}
                    </div>
                </div>
            </div>
        
    </div>

@endsection