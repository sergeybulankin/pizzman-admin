@extends('layouts.body')

@section('user')
    <user></user>
@endsection()

@section('content')
    <div class="row content">
        <div class="col-md-12 title">
            <div class="panel panel-default">
                <h1>Список блюд</h1>
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
                    <a href="/create/food">
                        Добавить блюдо
                    </a>
                </div>

                <table>
                    <tr class="table-title" style="text-align: center;">
                        <td class="number-phone">Фото</td>
                        <td class="number-phone">Название</td>
                        <td class="number-phone">Категория</td>
                        <td class="number-phone">Тип</td>
                        <td class="number-phone">БЖУ</td>
                        <td class="number-phone">Цена</td>
                        <td class="number-phone">Описание</td>
                        <td class="number-phone">Рекомендуем</td>
                        <td class="number-phone">Видимость</td>
                        <td>Редактировать</td>
                    </tr>

                    @foreach($foods as $food)
                        <tr class="table-list">
                            <td class="number-phone">

                            </td>
                            <td class="level">{{ $food->name }}</td>
                            <td class="level">{{ $food->category->name }}</td>
                            <td>
                                @foreach($food->type as $type)
                                    <span class="type"> {{ $type->name }} </span>
                                @endforeach()
                            </td>
                            <td>
                                <div class="structure">
                                    {{ $food->protein }} | {{ $food->fat }} | {{ $food->carbohydrates }} <br>
                                    ({{ $food->calories }})
                                </div>
                            </td>
                            <td class="level">{{ $food->price }} руб</td>
                            <td class="level">{{ $food->structure }}</td>
                            <td class="level">
                                <form action="/list/food/recomend/{{ $food->id }}" method="POST">
                                    {{ method_field('PUT') }}
                                    {{ csrf_field() }}

                                    @if($food->recommend == 1)
                                        <button>👎</button>
                                    @else
                                        <button>👍</button>
                                    @endif()
                                </form>
                            </td>
                            <td class="level">
                                <form action="/list/food/visibility/{{ $food->id }}" method="POST">
                                    {{ method_field('PUT') }}
                                    {{ csrf_field() }}

                                    @if($food->visibility == 1)
                                        <button>👀</button>
                                    @else
                                        <button>😭</button>
                                    @endif()
                                </form>
                            </td>
                            <td>
                                <form action="/edit/food/{{ $food->id }}" method="POST">
                                    {{ method_field('PUT') }}
                                    {{ csrf_field() }}

                                    <button>✏</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach()
                </table>
            </div>
        </div>
    </div>
@endsection()