@extends('control')

@section('content')
    <h1>Новый ползователь</h1>

    <div class="form-add">
        <form action="/store/account" method="POST">
            <div class="form-group">
                <input type="text" name="name" id="name" placeholder="Имя" class="form-control">
            </div>

            <div class="form-group">
                <input type="text" name="phone" id="phone" placeholder="Телефон" class="form-control">
            </div>

            <div class="form-group">
                <select name="role" id="role" class="form-control">
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach()
                </select>
            </div>

            <div class="form-group" class="form-control">
                <input type="password" name="password" id="password" placeholder="Пароль" class="form-control">
            </div>

            <div class="form-group">
                <input type="submit" value="Добавить" class="btn btn-default">
            </div>
        </form>
    </div>
@endsection()