@extends('admin.layouts.admin_app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                @component('admin.components.breadcrumbs')
                    @slot('title') Редактирование пользователя @endslot
                    @slot('parent') Главная @endslot
                    @slot('active') Пользователи @endslot
                @endcomponent
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form action="{{route('admin.user_management.user.update', $user->id)}}" method="post">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    @include('admin.user_management.users.partitions.form')
                </form>
            </div>
        </div>
    </div>
@endsection