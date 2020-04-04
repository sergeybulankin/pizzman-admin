<template>
    <div class="row content">
        <div class="col-md-12 title">
            <div class="panel panel-default">
                <h1>Режим доставки <span class="timer">{{ countDown }}</span></h1>
            </div>
        </div>

        <div class="col-md-12 working-field">
            <ul class="nav nav-statuses mb-20">
                <li class="nav-item">
                    <a class="nav-link active" href="/dashboard">
                        Текущие <span class="count-orders"> {{ COUNT_ORDERS }} </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="/driver/archive">
                        Архив
                    </a>
                </li>
            </ul>

            <div class="order" v-for="(list, i) in ORDERS" :key="i">
                <div class="points">
                    <div class="pizzman-point">
                        <div class="point-from"></div>
                        <div class="address">
                            <span class="address-info">Адрес:</span> {{ list[0].pizzman_address.address }}
                        </div>
                    </div>

                    <div>
                        <div class="point-to"></div>
                        <div class="address" v-for="(address, address_id) in list[0].address.address">
                            <span class="address-info">Адрес:</span> {{ address.address }} &nbsp;&nbsp;
                            <span class="address-info">Квартира:</span> {{ address.kv }}
                        </div>
                    </div>

                    <div class="time-order">
                        <div class="time"></div>
                        <div class="time-info"> {{ list[0].time_order.date | moment }} </div>
                    </div>
                </div>

                <div v-for="(order, order_i) in list" :key="order_i">
                    <div class="food-position" v-for="(food, food_i) in order.food" :key="food_i">
                        {{ food.name }}
                        <div class="additive-position" v-for="(additive, additive_i) in order.additive" :key="additive_i">
                            {{ additive.name }}
                        </div>
                        <div class="count-food">
                            количество - {{ order.count }}
                        </div>
                    </div>
                </div>

                <div class="map-info">
                    <span class="map" @click="openMap">{{ list[0].phone.name }}</span>
                </div>

                <button class="btn btn-default" @click="orderDelivered(list[0].order_status_id)">Доставлено</button>
            </div>
        </div>

    </div>
</template>

<script>
    moment.locale('ru');

    import { mapGetters, mapActions } from 'vuex';

    export default {
        data() {
            return {
                countDown: 100
            }
        },
        created() {
            this.updateOrders();
            this.countDownTimer();
        },
        mounted() {
            var id = document.querySelector("meta[name='user-id']").getAttribute('content');

            setTimeout(() => {
                this.SELECTED_ORDERS_FOR_DRIVER(id)
            }, 1000),

            this.COUNT_ACTIVE_ORDERS(id);
        },
        computed: mapGetters([
            'ORDERS',
            'COUNT_ORDERS'
        ]),
        filters: {
            moment: (date) => {
                return moment(date).format('D MMMM, H:mm');
            }
        },
        methods: {
            ...mapActions([
                'SELECTED_ORDERS_FOR_DRIVER',
                'COUNT_ACTIVE_ORDERS',
                'ORDER_DELIVERED'
            ]),

            orderDelivered(order_status_id) {
                var id = document.querySelector("meta[name='user-id']").getAttribute('content');

                this.ORDER_DELIVERED(order_status_id);

                this.SELECTED_ORDERS_FOR_DRIVER(id);
                this.COUNT_ACTIVE_ORDERS(id);
                console.log('Данные обновились');
            },

            openMap() {
                console.log('MAP');
            },

            updateOrders() {
                var id = document.querySelector("meta[name='user-id']").getAttribute('content');

                setInterval(() => {
                    this.SELECTED_ORDERS_FOR_DRIVER(id);
                    this.COUNT_ACTIVE_ORDERS(id);
                    console.log('Данные обновились');
                }, 100000);
            },

            countDownTimer() {
                if(this.countDown > 0) {
                    setTimeout(() => {
                        this.countDown -= 1
                        this.countDownTimer()
                    }, 1000)
                }

                if(this.countDown <= 0) {
                    this.countDown = 100;
                    this.countDownTimer();
                }
            }
        }
    }
</script>