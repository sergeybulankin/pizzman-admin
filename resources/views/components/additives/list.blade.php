@extends('layouts.body')

@section('user')
    <user></user>
@endsection()

@section('content')
    <div class="row content">
        <div class="col-md-12 title">
            <div class="panel panel-default">
                <h1>Список добавок</h1>
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
                    <a href="/create/additive">
                        Добавить добавку
                    </a>
                </div>

                <table>
                    <tr class="table-title" style="text-align: center;">
                        <td class="number-phone">Добавка</td>
                        <td class="level">Цена</td>
                        <td>Редактировать</td>
                    </tr>

                    @foreach($additives as $additive)
                        <tr class="table-list">
                            <td class="number-phone">{{ $additive->name }}</td>
                            <td class="level">{{ $additive->price }}</td>
                            <td>
                                <form action="/edit/additive/{{ $additive->id }}" method="POST">
                                    {{ method_field('PUT') }}
                                    {{ csrf_field() }}

                                    <button>редактировать</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach()
                </table>
            </div>
        </div>
    </div>
@endsection()