@extends('admin.layouts.admin_app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                @component('admin.components.breadcrumbs')
                    @slot('title') Список статических страниц (формируют меню) @endslot
                    @slot('parent') Главная @endslot
                    @slot('active') Статические страницы @endslot
                @endcomponent
            </div>
        </div>
        <div class="row">
            <div class="wd-admin-content col-sm-12">
                <hr />
                <table class="table table-striped">
                    <thead>
                        <th>Наименование</th>
                        <th>Описание Статьи</th>
                        <th>Публикация</th>
                        <th class="text-right">Действие</th>
                    </thead>
                    <tbody>
                        @forelse($staticPages as $stPage)
                            <tr>
                                <td>{{ $stPage->title }}</td>
                                <td>{!! $stPage->description ?? "Описание отсутствует" !!}</td>
                                <td>{{ $stPage->published }}</td>
                                <td>
                                    <a href="{{route('admin.static-page.edit', $stPage)}}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    <h2>Статьи отсутствуют</h2>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-center">
                                <ul class="pagination pull-right">
                                    <li>{{$staticPages->links()}}</li>
                                </ul>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection