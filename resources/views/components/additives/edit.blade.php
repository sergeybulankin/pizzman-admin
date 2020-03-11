@extends('control')

@section('content')
    <div class="row content">
        <div class="col-md-12 title">
            <div class="panel panel-default">
                <h1>Редактирование добавки</h1>
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

            <form action="/update/additive/{{ $additive->id }}" method="POST">
                {{ method_field('PUT') }}
                {{ csrf_field() }}

                <div class="form-group">
                    <input type="hidden" name="additive_id" id="additive_id" placeholder="Добавка" class="form-control" value="{{ $additive->id }}">
                </div>

                <div class="form-group">
                    <input type="text" name="name_additive" id="name_additive" placeholder="Название" class="form-control" value="{{ $additive->name }}">
                </div>

                <div class="form-group">
                    <input type="text" name="price" id="price" placeholder="Цена" class="form-control" value="{{ $additive->price }}">
                </div>

                <div class="form-group">
                    <input type="submit" value="Обновить" class="btn btn-default">
                </div>
            </form>
        </div>
    </div>
@endsection()