@extends('layouts.body')

@section('user')
    <user></user>
@endsection()

@section('content')
    <div class="row content">
        <div class="col-md-12 title">
            <div class="panel panel-default">
                <h1>Список категорий</h1>
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
                    <a href="/create/category">
                        Добавить категорию
                    </a>
                </div>

                <table>
                    <tr class="table-title" style="text-align: center;">
                        <td class="number-phone">Иконка</td>
                        <td class="number-phone">Категория</td>
                        <td>Редактировать</td>
                    </tr>

                    @foreach($categories as $category)
                        <tr class="table-list">
                            <td class="number-phone">
                                <img src="../images/categories/{{ $category->icon }}" alt="">
                            </td>
                            <td class="level">{{ $category->name }}</td>
                            <td>
                                <form action="/edit/category/{{ $category->id }}" method="POST">
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