@extends('admin.layouts.admin_app')
@section('content')
    <div class="container wd-admin-content">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <h2>Categories</h2>
                <p>Amount of Categories: {{ $amount_categories }}</p>
                <dl>
                    @foreach($categories as $category)
                        <dt>
                            <a href="{{ route('admin.category.edit',$category->id)}}">
                                    {{ $category->title }}
                                </a>
                        </dt>
                        <dd>
                            <span>Quantity posts in this category: </span>{{ $category->posts()->count() }}
                        </dd>
                    @endforeach
                </dl>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <h2>Posts</h2>
                <p>Amount of Posts: {{ $amount_posts }}</p>
                <dl>
                    @foreach($posts as $post)
                        <dt>
                            <a href="{{ route('admin.post.edit',$post->id)}}">
                                    {{ $post->title }}
                                </a>
                        </dt>
                        <dd>
                            {{ $post->categories()->pluck('title')->implode(", ") }}
                        </dd>
                    @endforeach
                </dl>
            </div>
        </div>
    </div>
@endsection

