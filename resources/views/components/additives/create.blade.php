@extends('control')

@section('user')
    <user></user>
@endsection()

@section('content')
    <div class="row content">
        <div class="col-md-12 title">
            <div class="panel panel-default">
                <h1>Новая добавка</h1>
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

            <form action="/store/additive" method="POST">
                {{ method_field('POST') }}
                {{ csrf_field() }}

                <div class="form-group">
                    <input type="text" name="name_additive" id="name_additive" placeholder="Название" class="form-control">
                </div>

                <div class="form-group">
                    <input type="text" name="price" id="price" placeholder="Цена" class="form-control">
                </div>

                <div class="form-group">
                    <input type="submit" value="Добавить" class="btn btn-default">
                </div>
            </form>
        </div>
    </div>
@endsection()