@extends('control')

@section('content')
    <h1>Редактирование пользователя</h1>

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

        <form action="/update/user/{{ $account->id }}" method="POST"  enctype="multipart/form-data">
            {{ method_field('PUT') }}
            {{ csrf_field() }}

            <div class="form-group">
                <input type="hidden" name="user_id" id="user_id" placeholder="Телефон" class="form-control" value="{{ $account->user_id }}">
            </div>

            <div class="form-group">
                <input type="text" name="name" id="name" placeholder="Телефон" class="form-control" value="{{ $account->user->name }}">
            </div>

            <div class="form-group">
                <input type="text" name="name_account" id="name_account" placeholder="Имя" class="form-control" value="{{ $account->name }}">
            </div>

            <div class="form-group" class="form-control">
                <input type="password" name="password" id="password" placeholder="Пароль" class="form-control">
            </div>

            <div class="form-group">
                <label for="image">Юзерпик</label>
                <div class="preview-image">
                    <input id="image" type="file" class="form-control" name="image">
                    <img src="#" id="onload-image" width="60px" />
                </div>
            </div>

            <div class="form-group">
                <input type="submit" value="Обновить" class="btn btn-default">
            </div>
        </form>
    </div>
@endsection()