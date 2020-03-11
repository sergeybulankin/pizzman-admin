@extends('layouts.body')

@section('user')
    <user></user>
@endsection()

@section('content')
    <div class="row content">
        <div class="col-md-12 title">
            <div class="panel panel-default">
                <h1>Связь типов с блюдами</h1>
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
                    <a href="/create/ftype">
                        Добавить связь
                    </a>
                </div>

                <table>
                    <tr class="table-title" style="text-align: center;">
                        <td class="number-phone">Блюдо</td>
                        <td class="number-phone" style="text-align: right;">Тип</td>
                    </tr>

                    @foreach($food_types as $food)
                        <tr class="table-list" style="border-bottom: 1px solid #2B1B35;">
                            <td class="food-name" style="vertical-align: top">{{ $food->name }}</td>
                            <td class="food-type">
                                @foreach($food->type as $type)
                                    <div style="margin-bottom: 15px; text-align: right;">
                                        <form action="/delete/ftype/{{ $food->id }}/{{ $type->id }}" method="POST">
                                            {{ method_field('PUT') }}
                                            {{ csrf_field() }}

                                            <span class="food-type-delete">
                                            {{ $type->name }}
                                        </span>
                                            <button class="btn btn-default">x</button>
                                        </form>
                                    </div>
                                @endforeach()
                            </td>
                        </tr>
                    @endforeach()
                </table>
            </div>
        </div>
    </div>
@endsection()