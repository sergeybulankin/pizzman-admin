@extends('control')

@section('content')
    <div class="row content">
        <div class="col-md-12 title">
            <div class="panel panel-default">
                <h1>Редактирование типа</h1>
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

            <form action="/update/type/{{ $type->id }}" method="POST" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                {{ csrf_field() }}

                <div class="form-group">
                    <input type="hidden" name="type_id" id="type_id" placeholder="Категория" class="form-control" value="{{ $type->id }}">
                </div>

                <div class="form-group">
                    <input type="text" name="name_type" id="name_type" placeholder="Название" class="form-control" value="{{ $type->name }}">
                </div>

                <div class="form-group">
                    <label for="image">Иконка</label>
                    <div class="preview-image">
                        <input id="image" type="file" class="form-control" name="image">
                        <img src="../../images/types/{{ $type->icon }}" id="onload-image" width="60px" />
                    </div>
                </div>

                <div class="form-group">
                    <input type="submit" value="Обновить" class="btn btn-default">
                </div>
            </form>
        </div>
    </div>
@endsection()