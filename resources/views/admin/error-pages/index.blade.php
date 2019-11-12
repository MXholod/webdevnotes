@extends('admin.layouts.admin_app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                @component('admin.components.breadcrumbs')
                    @slot('title') Список страниц вывода ошибок @endslot
                    @slot('parent') Главная @endslot
                    @slot('active') Страницы ошибок @endslot
                @endcomponent
            </div>
        </div>
        <div class="row">
            <div class="wd-admin-content col-sm-12">
                <hr />
                <table class="table table-striped">
                    <thead>
                        <th>Наименование</th>
                        <th>Описание Страницы</th>
                        <th>Публикация</th>
                        <th class="text-right">Действие</th>
                    </thead>
                    <tbody>
                        @forelse($errorPages as $errPage)
                            <tr>
                                <td>{{ $errPage->title }}</td>
                                <td>{!! $errPage->description ?? "Описание отсутствует" !!}</td>
                                <td>{{ $errPage->published }}</td>
                                <td>
                                    <a href="{{route('admin.error-page.edit', $errPage)}}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    <h2>Страницы отсутствуют</h2>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-center">
                                <ul class="pagination pull-right">
                                    <li>{{$errorPages->links()}}</li>
                                </ul>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection