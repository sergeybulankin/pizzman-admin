@extends('layouts.body')

@section('user')
    <user></user>
@endsection()

@section('content')
    <div class="row content">
        <div class="col-md-12 title">
            <div class="panel panel-default">
                <h1>Архив заказов</h1>
            </div>
        </div>

        <div class="col-md-12 working-field">
            <div class="list-group">
                <div class="navbar-collapse">
                    <table>
                        <tr class="table-title" style="text-align: center;">
                            <td class="number-phone">Номер заказа</td>
                            <td class="level">Адрес доставки</td>
                            <td class="address">Время последнего обновления</td>
                            <td class="address">Статус</td>
                        </tr>

                        @foreach($user_orders as $orders)
                            @foreach($orders as $order)
                                <tr style="text-align: center;">
                                    <td class="number-phone">{{ $order[0]['order']['user']['name'] }}</td>
                                    <td class="level">{{ $order[0]['order']['address'][0]['address'] }}</td>
                                    <td class="time-updated">{{ $order[0]['order']['order_status'][0]['updated_at'] }}</td>
                                    <td class="address"><strong> {{ $order[0]['status']['name'] }} </strong></td>
                                </tr>
                            @endforeach()
                        @endforeach()
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection()