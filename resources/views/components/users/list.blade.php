@extends('control')

@section('content')
    <h1>Список пользователей</h1>

    <div class="list-group">
        <div class="navbar-collapse">
            <ul class="navbar-nav">
                @foreach($accounts as $acc)
                    <li class="nav-item">
                        {{ $acc->user->name }}
                    </li>
                @endforeach()

            </ul>
        </div>
    </div>
@endsection()