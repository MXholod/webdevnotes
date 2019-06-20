@extends('admin.layouts.admin_app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                @component('admin.components.breadcrumbs')
                    @slot('title') Редактирование категории @endslot
                    @slot('parent') Главная @endslot
                    @slot('active') Категории @endslot
                @endcomponent
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form action="{{route('admin.category.update', $category->id)}}" method="post">
                    <input type="hidden" name="_method" value="put" />
                    {{ csrf_field() }}
                    @include('admin.categories.partitions.form')
                </form>
            </div>
        </div>
    </div>
@endsection