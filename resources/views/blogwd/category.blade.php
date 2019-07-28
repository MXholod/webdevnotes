@extends('layouts.app')

@section('title', $category->title)
@section('meta_description') {{$category->meta_description}} @endsection
@section('meta_keywords') {{$category->meta_keywords}} @endsection

@section('content')

    <div class="container">
        @forelse($posts as $post)
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <a href="{{route('post',$post->slug)}}">{{$post->title}}</a>
                    <div>
                        {!! $post->description !!}
                    </div>
                </div>
            </div>
        @empty
            <h2 class="text-center">There are not posts</h2>
        @endforelse
        <div>
            {{ $posts->links() }}
        </div>
    </div>
<pre>
    {{--print_r($category)--}}
</pre>

@endsection