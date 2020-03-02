@extends('layouts.app')

@section('title',$title ?? "500")
@section('meta_description'){{ $meta_description ?? "Error 500"}} @endsection
@section('meta_keywords'){{ $meta_keywords ?? "Error 500"}} @endsection

@isset($styles)
    @foreach($styles as $style)
        @push('styles_header')
            <link href="{{ asset($style) }}" type="text/css" rel="stylesheet" />
        @endpush
    @endforeach
@endisset
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
                <div>{!!$description ?? ""!!}</div>
                @if(isset($exception) && !isset($description))
                    <p>{{$exception->getMessage()}}</p>
                @endif
                <div>{!!$full_text ?? "Internal server error 500"!!}</div>
                <div style="text-align:center;font-size:32px;font-weight:bold;">
                    {{$status ?? $exception->getMessage()}}
                </div>
            </div>
        </div>
    </div>
@endsection