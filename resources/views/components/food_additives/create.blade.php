@extends('control')

@section('user')
    <user></user>
@endsection()

@section('content')
    <div class="row content">
        <div class="col-md-12 title">
            <div class="panel panel-default">
                <h1>Новая связь</h1>
            </div>
        </div>

        <div class="form-add">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif()

            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    Данные заполнены некоректно
                </div>
            @endif()

            <form action="/store/fadditive" method="POST">
                {{ method_field('POST') }}
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="food">Блюдо</label>
                    <select name="food" id="food" class="form-control">
                        @foreach($foods as $food)
                            <option value="{{ $food->id }}">{{ $food->name }}</option>
                        @endforeach()
                    </select>
                </div>

                <div class="form-group">
                    <label for="type">Добавка</label>
                    <select name="additive" id="additive" class="form-control">
                        @foreach($additive as $additive)
                            <option value="{{ $additive->id }}">{{ $additive->name }}</option>
                        @endforeach()
                    </select>
                </div>

                <div class="form-group">
                    <input type="submit" value="Добавить" class="btn btn-default">
                </div>
            </form>
        </div>
    </div>
@endsection()