@extends('admin.layouts.admin_app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                @component('admin.components.breadcrumbs')
                    @slot('title') Создание статьи @endslot
                    @slot('parent') Главная @endslot
                    @slot('active') Статьи @endslot
                @endcomponent
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form action="{{route('admin.post.store')}}" method="post">
                    {{ csrf_field() }}
                    @include('admin.posts.partitions.form')
                    <input type="hidden" name="created_by" value="{{Auth::id()}}" />
                </form>
            </div>
        </div>
    </div>
@endsection