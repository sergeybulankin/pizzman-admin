@extends('layouts.body')

@section('content')
    <a href="/dashboard">на главную</a> <br>
    <h1>Архив заказов</h1>

    <div class="list-group">
        <div class="navbar-collapse">
            <table>
                <tr class="table-title" style="text-align: center;">
                    <td class="number-phone">Номер заказа</td>
                    <td class="level">Адрес доставки</td>
                    <td class="address">Время доставки</td>
                </tr>

                @foreach($user_orders as $order)
                    <tr class="table-list">
                        <td class="number-phone">{{ $order->order->user->name }}</td>
                        <td class="level">{{ $order->order->address[0]->address }}</td>
                        <td>{{ $order->order_status[0]->updated_at }}</td>
                    </tr>
                @endforeach()
            </table>
        </div>
    </div>
@endsection()