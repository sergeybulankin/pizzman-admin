<template>
    <div class="container">
        <div class="row">

            <vue-countdown-timer
                    @start_callback="startCallBack('Начало')"
                    @end_callback="endCallBack('Конец')"
                    :interval="100"
                    :start-time="startTime"
                    :end-time="endTime"
                    :start-label="'Till starts'"
                    :end-label="'Till ends'"
                    :end-text="'Ended'"
                    :day-txt = null
                    :hour-txt = null
                    :minutes-txt= null
                    :seconds-txt="'секунд'">
            </vue-countdown-timer>


            <div class="col-md-12">
                <div class="panel panel-default">
                    <h1>Срочная готовка</h1>
                    <ul class="nav">
                        <li class="nav-item" v-for="(status, index) in ALL_STATUSES" :key="index">
                            <a class="nav-link active" href="#" @click="changeOrdersByStatus(status.id)">
                                {{ status.status_name }} <span class="count">{{ status.count }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-12 mt-50">
                <div v-if="LOADER" class="load">
                    <img src="images/loader.gif" alt="" width="20px">
                    <h4>Загружаем заказы...</h4>
                </div>

                <table>
                    <tr class="table-title">
                        <td class="number-order">Номер заказа</td>
                        <td class=number-phone>Номер телефона</td>
                        <td class="list-foods">Список блюд</td>
                        <td class="address">Адрес доставки</td>
                        <td class="next-step"></td>
                    </tr>
                    <tr class="list" v-for="(order, index) in ALL_ORDERS" :key="index">
                        <td class="number-order"># {{ order.id }}</td>
                        <td class=number-phone>{{ order.user.name }}</td>
                        <td class="list-foods">
                            Здесь будут блюда
                        </td>
                        <td class="address">
                            {{ order.address.address }} - {{ order.address.kv }}

                            <div v-if="order.status[0].status_id == 5">
                                {{ order.courier }}
                            </div>
                        </td>
                        <td>
                            <div v-if="order.status[0].status_id == 4">
                                <select name="driver" class="form-control" v-model="driver">
                                    <option :value="driver.id" v-for="(driver, i) in ALL_DRIVERS" :key="i">{{ driver.name }}  {{ driver.second_name }}</option>
                                </select>
                                <br>

                                <button class="btn btn-danger" @click="passOrder(order.id, order.status[0].status_id, driver)">Дальше</button>
                            </div>

                            <div v-else>
                                <button class="btn btn-danger" @click="nextStep(order.id, order.status[0].status_id)" v-if="order.status[0].status_id <= 5">Дальше</button>
                            </div>

                        </td>
                    </tr>
                </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {
        data() {
            const now = new Date();
            return {
                driver: '',

                startTime: new Date(now.getTime() + (1000 * 10)),
                endTime: new Date(now.getTime() + (1000 * 20)),
            }
        },
        mounted() {
            this.SELECTED_ALL_STATUSES();
            this.SELECTED_ORDERS();
            this.SELECTED_ALL_DRIVERS();
        },
        computed: mapGetters([
            'ALL_STATUSES',
            'ALL_ORDERS',
            'ALL_DRIVERS',
            'LOADER'
        ]),
        methods: {
            ...mapActions([
                    'SELECTED_ALL_STATUSES',
                    'SELECTED_ORDERS',
                    'SELECTED_ORDERS_BY_STATUS',
                    'SELECTED_ALL_DRIVERS',
                    'TRANSITION_TO_A_NEW_STAGE',
                    'SEND_ORDER_TO_COURIER'
                ]),

            changeOrdersByStatus(id) {
                this.SELECTED_ORDERS_BY_STATUS(id)
            },

            passOrder(id, status_id, driver){
                var data = {id, driver}
                this.SEND_ORDER_TO_COURIER(data);

                this.nextStep(id, status_id);
            },

            nextStep(id, status_id){
                this.TRANSITION_TO_A_NEW_STAGE(id);
                this.SELECTED_ALL_STATUSES();
                this.SELECTED_ORDERS_BY_STATUS(status_id)
            },

            updateOrders() {
                this.SELECTED_ALL_STATUSES();
                this.SELECTED_ORDERS();
                this.SELECTED_ALL_DRIVERS();
                console.log('Данные обновились');
            },

            startCallBack: function (x) {
                console.log(x)
            },

            endCallBack: function (x) {
                console.log(x)
            }
        }
    }
</script>