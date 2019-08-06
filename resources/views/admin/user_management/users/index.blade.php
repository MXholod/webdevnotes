@extends('admin.layouts.admin_app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                @component('admin.components.breadcrumbs')
                    @slot('title') Список пользователей @endslot
                    @slot('parent') Главная @endslot
                    @slot('active') Пользователи @endslot
                @endcomponent
            </div>
        </div>
        <div class="row">
            <div class="wd-admin-content col-sm-12">
                <hr />
                <a href="{{route('admin.user_management.user.create')}}" class="btn btn-primary">
                    <i class="far fa-plus-square"></i>
                    Создать пользователя
                </a>
                <table class="table table-striped">
                    <thead>
                        <th>Имя пользователя</th>
                        <th>Email пользователя</th>
                        <th class="text-right">Действие</th>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->login }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <form style="display:inline-block;"
                                        onsubmit="if(confirm('Want to delete?')){
                                            return true;
                                        }else{
                                            return false;
                                        }"
                                        action="{{route('admin.user_management.user.destroy',$user)}}"
                                        method="POST"
                                    >
                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn" />
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    <a href="{{route('admin.user_management.user.edit', $user)}}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">
                                    <h2>Пользователи отсутствуют</h2>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-center">
                                <ul class="pagination pull-right">
                                    <li>{{$users->links()}}</li>
                                </ul>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection