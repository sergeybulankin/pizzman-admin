<template>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <h1>Режим доставки</h1>
                <ul class="nav">
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
            </div>
        </div>

        <div>
            <div v-for="(list, i) in ORDERS" :key="i">
                <div v-for="(address, address_id) in list[0].address.address">
                    {{ address.address }} / {{ address.kv }}
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

                <div class="map">
                    <span @click="openMap">Показать адрес на карте</span>
                </div>

                <span class="btn btn-danger" @click="orderDelivered(list[0].order_status_id)">Доставлено</span>
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

<style>
    .count-orders {
        padding: 5px 10px;
        background-color: #2B1B35;
        color: white;
        font-weight: 600;
        font-size: 12px;
    }

    .map {
        margin: 10px 0;
        background-color: #2B1B35;
        color: white;
        padding: 5px;
        cursor: pointer;
    }
</style>