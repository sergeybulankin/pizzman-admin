<template>
    <div class="row content">
        <div class="col-md-12 title">
            <div class="panel panel-default">
                <h1>Режим доставки</h1>
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
                            Точка на Худайбердина
                        </div>
                    </div>

                    <div>
                        <div class="point-to"></div>
                        <div class="address" v-for="(address, address_id) in list[0].address.address">
                            <span class="address-info">Адрес:</span> {{ address.address }} &nbsp;&nbsp;
                            <span class="address-info">Квартира:</span> {{ address.kv }}
                        </div>
                    </div>
                </div>

                <div v-for="(order, order_i) in list" :key="order_i">
                    <div v-for="(food_additive, food_additive_i) in order.food" :key="food_additive_i">
                        <div class="food-position" v-for="(food, food_i) in food_additive.food" :key="food_i">
                            {{ food.name }}
                            <div class="additive-position" v-for="(additive, additive_i) in food_additive.additive" :key="additive_i">
                                добавки - {{ additive.name }}
                            </div>
                            <div class="count-food">
                                количество - {{ order.count }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="map-info">
                    <span class="map" @click="openMap">Показать адрес на карте</span>
                </div>

                <button class="btn btn-default" @click="orderDelivered(list[0].order_status_id)">Доставлено</button>
            </div>
        </div>


        <!--<yandex-map
                :coords="coords"
                :zoom="10"
                :settings="settings">
            <ymap-marker
                    :coords="coords"
                    marker-id="123"
                    hint-content="some hint"/>
        </yandex-map>-->


    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';
    import { yandexMap, ymapMarker } from 'vue-yandex-maps';

    export default {
        data() {
            return {
                settings: {
                    apiKey: '5bee05a1-94b7-46f1-a64f-5ed7d3b1f4cd',
                    lang: 'ru_RU',
                    coordorder: 'latlong',
                    version: '2.1'
                },

                coords: [
                    54.82896654088406,
                    39.831893822753904,
                ],
            }
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
        methods: {
            ...mapActions([
                'SELECTED_ORDERS_FOR_DRIVER',
                'COUNT_ACTIVE_ORDERS',
                'ORDER_DELIVERED'
            ]),

            orderDelivered(order_status_id) {
                this.ORDER_DELIVERED(order_status_id);
            },

            openMap() {
                console.log('MAP');
            }
        },
        components: { yandexMap, ymapMarker }
    }
</script>