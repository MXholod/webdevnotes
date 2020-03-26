@extends('admin.layouts.admin_app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                @component('admin.components.breadcrumbs')
                    @slot('title') Список категорий @endslot
                    @slot('parent') Главная @endslot
                    @slot('active') Категории @endslot
                @endcomponent
            </div>
        </div>
        <div class="row">
            <div class="wd-admin-content col-sm-12">
                <hr />
                <a href="{{route('admin.category.create')}}" class="btn btn-primary">
                    <i class="far fa-plus-square"></i>
                    Создать категорию
                </a>
                <table class="table table-striped">
                    <thead>
                        <th>Наименование</th>
                        <th>Описание категории</th>
                        <th>Публикация</th>
                        <th>Удалить</th>
                        <th class="text-right">Редактировать</th>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->title }}</td>
                                <td>{{ $category->description ?? "Описание отсутствует" }}</td>
                                <td>{{ $category->published }}</td>
                                <td>
                                    @can('delete',$category)
                                    <form style="display:inline-block;"
                                        onsubmit="if(confirm('Want to delete?')){
                                            return true;
                                        }else{
                                            return false;
                                        }"
                                        action="{{route('admin.category.destroy',$category)}}"
                                        method="POST"
                                    >
                                        <input type="hidden" name="_method" value="DELETE" />
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn" />
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </td>    
                                <td style="padding-left:60px;">    
                                    <a href="{{route('admin.category.edit', $category)}}">
                                        <i class="fa fa-edit"></i>
                                        {{ $category->published }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    <h2>Категории отсутствуют</h2>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-center">
                                <ul class="pagination pull-right">
                                    <li>{{$categories->links()}}</li>
                                </ul>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection