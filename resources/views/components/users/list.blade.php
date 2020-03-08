@extends('layouts.body')

@section('user')
    <user></user>
@endsection()

@section('content')
    <div class="row content">
        <div class="col-md-12 title">
            <div class="panel panel-default">
                <h1>Список пользователей</h1>
            </div>
        </div>

        <div class="list-group">
            <div class="navbar-collapse">
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif()

                <div class="add-to-table">
                    <a href="/create/account">
                        Добавить пользователя
                    </a>
                </div>

                <table>
                    <tr class="table-title" style="text-align: center;">
                        <td class="number-phone">Номер телефона</td>
                        <td class="level">Уровень</td>
                        <td>Редактировать</td>
                        <td class="address">Черный список</td>
                    </tr>

                    @foreach($accounts as $acc)
                        <tr class="table-list">
                            <td class="number-phone">{{ $acc->user->name }}</td>
                            <td class="level">{{ $acc->role[0]->role->name }}</td>
                            <td>
                                <form action="/edit/account/{{ $acc->id }}" method="POST">
                                    {{ method_field('PUT') }}
                                    {{ csrf_field() }}

                                    <button>редактировать</button>
                                </form>
                            </td>
                            <td>
                                @if(empty($acc->black_list[0]))
                                    <form action="/list/account/black/{{ $acc->id }}" method="POST">
                                        {{ method_field('PUT') }}
                                        {{ csrf_field() }}

                                        <button><i class="fa fa-window-close" aria-hidden="true"></i></button>
                                    </form>
                                @else
                                    <form action="/list/account/unblack/{{ $acc->id }}" method="POST">
                                        {{ method_field('PUT') }}
                                        {{ csrf_field() }}

                                        <button><i class="fa fa-check" aria-hidden="true"></i></button>
                                    </form>
                                @endif()
                            </td>
                        </tr>
                    @endforeach()
                </table>
            </div>
        </div>
    </div>
@endsection()