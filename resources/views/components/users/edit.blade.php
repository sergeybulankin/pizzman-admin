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

        <form action="/update/account/{{ $account_user->id }}" method="POST">
            {{ method_field('PUT') }}
            {{ csrf_field() }}

            <div class="form-group">
                <input type="hidden" name="user_id" id="user_id" placeholder="Телефон" class="form-control" value="{{ $account_user->user_id }}">
            </div>

            <div class="form-group">

            </div>

            <div class="form-group">
                <input type="text" name="name" id="name" placeholder="Телефон" class="form-control" value="{{ $account_user->user->name }}">
            </div>

            <div class="form-group">
                <input type="text" name="name_account" id="name_account" placeholder="Имя" class="form-control" value="{{ $account_user->name }}">
            </div>

            <div class="form-group">
                <select name="role" id="role" class="form-control">
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach()
                </select>
            </div>

            <div class="form-group">
                <select name="point" id="point" class="form-control">
                    <option value="0">Без точки</option>
                    @foreach($points as $point)
                        <option value="{{ $point->id }}">{{ $point->address_delivery->address }}</option>
                    @endforeach()
                </select>
            </div>

            <div class="form-group" class="form-control">
                <input type="password" name="password" id="password" placeholder="Пароль" class="form-control">
            </div>

            <div class="form-group">
                <input type="submit" value="Обновить" class="btn btn-default">
            </div>
        </form>
    </div>
@endsection()