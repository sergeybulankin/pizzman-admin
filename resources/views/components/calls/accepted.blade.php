@extends('calls')

@section('calls')
    <h1>Просьбы позвонить</h1>

    <div class="list-group">
        <div class="navbar-collapse">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif()

            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    Запрос неудался
                </div>
            @endif()

            <div style="margin: 5px 0">
                <a href="/calls/accepted">принятые звонки</a>
            </div>

            <table>
                <tr class="table-title" style="text-align: center;">
                    <td class="number-phone">Номер телефона</td>
                    <td class="level">Имя</td>
                    <td>Время принятия</td>
                </tr>

                @foreach($calls as $call)
                    <tr class="table-list">
                        <td class="number-phone">{{ $call->phone }}</td>
                        <td class="level">{{ $call->name }}</td>
                        <td class="level">{{ $call->updated_at }}</td>
                    </tr>
                @endforeach()
            </table>
        </div>
    </div>
@endsection()