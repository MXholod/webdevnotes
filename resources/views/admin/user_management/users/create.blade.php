@extends('admin.layouts.admin_app')
@section('content')
    @push('webdev_scripts')
        <script src="{{ asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
        <script>
            window.onload=function(){
                //CKEDITOR.replace( 'description' );
                CKEDITOR.replace( 'description',
            {
                customConfig : 'config.js',
                toolbar : 'simple'
            });
                CKEDITOR.replace( 'descriptionFull' );
            };
        </script>
    @endpush
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                @component('admin.components.breadcrumbs')
                    @slot('title') Создание пользователя @endslot
                    @slot('parent') Главная @endslot
                    @slot('active') Пользователь @endslot
                @endcomponent
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form action="{{route('admin.user_management.user.store')}}" method="post">
                    {{ csrf_field() }}
                    @include('admin.user_management.users.partitions.form')
                </form>
            </div>
        </div>
    </div>
@endsection