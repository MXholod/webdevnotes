@extends('layouts.app')

@section('title', $pageData->title)
@section('meta_description') {{$pageData->meta_description}} @endsection
@section('meta_keywords') {{$pageData->meta_keywords}} @endsection

@isset($scripts['header'])
    @foreach($scripts['header'] as $script)
        @push('scripts_header')
            <script src="{{ asset($script) }}" defer></script>
        @endpush
    @endforeach
@endisset
@isset($scripts['footer'])
    @foreach($scripts['footer'] as $script)
        @push('scripts_footer')
            <script src="{{ asset($script) }}"></script>
        @endpush
    @endforeach
@endisset
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
