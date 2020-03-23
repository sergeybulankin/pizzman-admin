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

                @if(count($errors) > 0)
                    <div class="alert alert-danger">
                        Данные заполнены некоректно
                    </div>
                @endif()

                <div>
                    <form action="/statistics/upload" method="POST">
                        {{ csrf_field() }}

                        <button type="submit" class="upload-statistic">Скачать отчет</button>
                    </form>
                </div>

                <div class="statistics-date">
                    <form action="/statistics/dates" method="POST">
                        {{ csrf_field() }}

                        <input type="date" name="from" class="date-between">

                        <input type="date" name="to" class="date-between">

                        <button type="submit">Просмотреть</button>
                    </form>
                </div>

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
                                @foreach($order->food as $food_additives)
                                        @foreach($food_additives->food_additives as $food)
                                            <div style="margin: 5px 0;">
                                                @foreach($food->food as $food_item)
                                                    {{ $food_item->name }}

                                                    @foreach($food->additive as $additive)
                                                        <div class="pivot-additive-order">
                                                            {{ $additive->name }}
                                                        </div>
                                                    @endforeach()
                                                    <span class="pivot-count-food">Количество:</span> {{ $food_additives->count }}
                                                @endforeach()
                                            </div>

                                        @endforeach()
                                @endforeach()

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