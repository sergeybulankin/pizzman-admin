@extends('control')

@section('user')
    <user></user>
@endsection()

@section('content')
    <div class="row content">
        <div class="col-md-12 title">
            <div class="panel panel-default">
                <h1>Новая категория</h1>
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

            <form action="/store/category" method="POST" enctype="multipart/form-data">
                {{ method_field('POST') }}
                {{ csrf_field() }}

                <div class="form-group">
                    <input type="text" name="name_category" id="name_category" placeholder="Название" class="form-control">
                </div>

                <div class="form-group">
                    <label for="image">Иконка</label>
                    <div class="preview-image">
                        <input id="image" type="file" class="form-control" name="image">
                        <img src="#" id="onload-image" width="60px" />
                    </div>
                </div>

                <div class="form-group">
                    <input type="submit" value="Добавить" class="btn btn-default">
                </div>
            </form>
        </div>
    </div>
@endsection()