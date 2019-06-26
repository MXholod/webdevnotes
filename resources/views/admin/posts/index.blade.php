@extends('admin.layouts.admin_app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                @component('admin.components.breadcrumbs')
                    @slot('title') Список статей @endslot
                    @slot('parent') Главная @endslot
                    @slot('active') Статьи @endslot
                @endcomponent
            </div>
        </div>
        <div class="row">
            <div class="wd-admin-content col-sm-12">
                <hr />
                <a href="{{route('admin.post.create')}}" class="btn btn-primary">
                    <i class="far fa-plus-square"></i>
                    Создать статью
                </a>
                <table class="table table-striped">
                    <thead>
                        <th>Наименование</th>
                        <th>Описание Статьи</th>
                        <th>Публикация</th>
                        <th class="text-right">Действие</th>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                            <tr>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->description ?? "Описание отсутствует" }}</td>
                                <td>{{ $post->published }}</td>
                                <td>
                                    <form style="display:inline-block;"
                                        onsubmit="if(confirm('Want to delete?')){
                                            return true;
                                        }else{
                                            return false;
                                        }"
                                        action="{{route('admin.post.destroy',$post)}}"
                                        method="POST"
                                    >
                                        <input type="hidden" name="_method" value="DELETE" />
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn" />
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    <a href="{{route('admin.post.edit', $post)}}">
                                        <i class="fa fa-edit"></i>
                                        {{ $post->published }}
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
                                    <li>{{$posts->links()}}</li>
                                </ul>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection