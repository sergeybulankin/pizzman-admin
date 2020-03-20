@extends('layouts.body')

@section('user')
    <user></user>
@endsection()

@section('content')
    <div class="row content">
        <div class="col-md-12 title">
            <div class="panel panel-default">
                <h1>Сводная таблица</h1>
            </div>
        </div>

        <div class="col-md-12 working-field">
            <div class="navbar-collapse">
                <table class="pivot-table">
                    <tr class="pivot-table-title">
                        <td class="pivot-number-order">#</td>
                        <td class="pivot-food-order">Блюдо</td>
                        <td class="pivot-address-order">Адрес</td>
                        <td class="pivot-date-start-order">Время заказа</td>
                        <td class="pivot-date-end-order">Последнее время</td>
                        <td class="pivot-status-order">Стадия</td>
                    </tr>

                    @foreach($orders as $order)
                        <tr class="pivot-table-data">
                            <td class="pivot-number-order">
                                {{ $order->id }}
                            </td>
                            <td class="pivot-food-order">
                                {{ $order->food[0]->food_additives[0]->food[0]->name }}
                                @foreach($order->food as $food_additive)
                                    <!-- TODO вывести само блюдо -->
                                    @foreach($food_additive->food_additives as $food)
                                        @foreach($food->additive as $additive)
                                            <div class="pivot-additive-order">
                                            {{ $additive->name }}
                                            </div>
                                        @endforeach()
                                    @endforeach()
                                @endforeach()
                                <span class="pivot-count-food">Количество:</span> {{ $order->food[0]->count }}

                                <div style="width: 100px;">
                                    @if(empty($order->type_time))
                                        <div class="type-of-time" style="font-size: 10px;">Срочная</div>
                                    @else
                                        <div class="type-of-time" style="font-size: 10px;">
                                            Ко времени <br>
                                            {{ $order->date }}
                                        </div>
                                    @endif()
                                </div>
                            </td>
                            <td class="pivot-address-order">
                                @foreach($order->address as $address)
                                    <span class="pivot-address-field">улица</span> {{ $address->address }} <br>
                                    <span class="pivot-address-field">кв</span> {{ $address->kv }}
                                @endforeach()


                                @foreach($order->courier_info as $courier)
                                    <div class="pivot-courier-order">
                                        {{ $courier->account->name }} <br>
                                        <strong>{{ $courier->name }}</strong>
                                    </div>
                                @endforeach()
                            </td>
                            <td class="pivot-date-start-order">
                                {{ $order->created_utc }}
                            </td>
                            <td class="pivot-date-end-order">
                                @if($order->order_status_last->status->id == 5)
                                    {{ $order->order_status_last->updated_utc }}
                                @endif()
                            </td>

                            <td class="pivot-status-order">
                                {{ $order->order_status_last->status->name }}
                            </td>

                        </tr>
                    @endforeach()
                </table>
            </div>
        </div>
    </div>
@endsection()