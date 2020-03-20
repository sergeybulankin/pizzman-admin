<template>
    <div class="row content">
        <div class="col-md-12 title">
            <div class="panel panel-default">
                <h1>Таблица заказов <span class="timer">{{ countDown }}</span></h1>
            </div>
        </div>

        <div class="col-md-12 working-field">
            <ul class="nav nav-statuses mb-20">
                <li class="nav-item" v-for="(status, index) in ALL_STATUSES" :key="index">
                    <a class="nav-link active" href="#" @click="changeOrdersByStatus(status.id)">
                        {{ status.status_name }} <span class="count" v-if="status.count > 0">{{ status.count }}</span>
                    </a>
                </li>
            </ul>

            <div v-if="LOADER" class="load">
                <img src="images/loader.gif" alt="" width="20px">
                <h4>Загружаем заказы...</h4>
            </div>

            <div class="not-work" v-if="ALL_ORDERS.length == 0">
                ¯\_(ツ)_/¯ Работы на этой  стадии нет
            </div>

            <table>
                <tr class="table-title">
                    <td class="number-order">Номер заказа</td>
                    <td class=number-phone>Номер телефона</td>
                    <td class="list-foods">Список блюд</td>
                    <td class="address">Адрес доставки</td>
                    <td class="next-step"></td>
                </tr>
                <tr class="list" v-for="(order, index) in ALL_ORDERS" :key="index"
                    :style="order.type_of_time == 1 ? 'background-color: #D4F7F0;' : 'background-color: white;' ">
                    <td class="number-order"># {{ order.id }}</td>
                    <td class=number-phone>
                        {{ order.user.name }}

                        <div class="type-of-time" v-if="order.type_of_time == 1">
                            {{ order.date }}
                        </div>
                    </td>
                    <td class="list-foods">
                        <span class="list-food" @click="listFood(order.id)">просмотреть</span>
                    </td>
                    <td class="address"
                        :style="order.type_of_delivery == 1 ? 'background-color: #E7F7CA;' : 'background-color: white;' ">
                        <div v-for="(address, i) in order.address" :key="i">
                            {{ address.address }} - {{ address.kv }}
                        </div>

                        <div v-if="order.type_of_delivery == 0">
                            <div v-if="order.last_status.status_id == 5">
                                <div class="view-driver" @click="viewDriver(order.courier.user_id, order.id)">Посмотреть водителя ▼</div>
                                <div :class="'driver-'+order.id" style="display: none;">
                                    <div class="driver-phone">{{ DRIVER.name }} </div>
                                    <div class="driver-name" v-for="(driver, i) in DRIVER"> {{ driver.name }} </div>
                                    <div class="hide-driver" @click="hideDriver(order.id)">▲</div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div v-if="order.type_of_delivery == 0">
                            <div v-if="order.last_status.status_id == 4">
                                <select name="driver" class="form-control" v-model="driver">
                                    <option :value="driver.user_id" v-for="(driver, i) in ALL_DRIVERS" :key="i">{{ driver.name }}  {{ driver.second_name }}</option>
                                </select>
                                <br>

                                <button class="btn btn-default" @click="passOrder(order.id, order.status[0].status_id, driver)">Дальше</button>
                            </div>

                            <div v-else>
                                <button class="btn btn-default" @click="nextStep(order.id, order.status[0].status_id)" v-if="order.last_status.status_id < 4">Дальше ➜</button>
                            </div>
                        </div>

                        <div v-else>
                            <button class="btn btn-default" @click="nextStep(order.id, order.status[0].status_id)">Дальше ➜</button>
                        </div>
                    </td>
                </tr>
            </table>
        </div>


        <div class="modal-mask" v-show="showModal">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-header">
                        Описание заказа
                    </div>

                    <div v-for="(list, i) in LIST" :key="i">
                        <div v-for="(food, food_i) in list.food" :key="food_i">
                            <div class="food-position">
                                <div class="food-name">
                                    {{ food.name }}
                                </div>
                                <div class="additive-position" v-for="(additive_block, additive_block_i) in list.additive" :key="additive_block_i">
                                    <span v-for="(additive, additive_i) in additive_block">{{ additive.name }}</span>
                                </div>
                                <div class="count-food">
                                    количество - {{ list.count }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-default" @click="showModal = false">
                            закрыть
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {
        data() {
            return {
                driver: '',
                countDown: 100,
                showModal: false
            }
        },
        created() {
            this.updateOrders();
            this.countDownTimer();
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
            'LOADER',
            'DRIVER',
            'LIST'
        ]),
        methods: {
                ...mapActions([
                    'SELECTED_ALL_STATUSES',
                    'SELECTED_ORDERS',
                    'SELECTED_ORDERS_BY_STATUS',
                    'SELECTED_ALL_DRIVERS',
                    'LIST_FOOD',
                    'TRANSITION_TO_A_NEW_STAGE',
                    'SEND_ORDER_TO_COURIER',
                    'VIEW_DRIVER'
                ]),

        changeOrdersByStatus(id) {
            this.SELECTED_ORDERS_BY_STATUS(id)
        },

        listFood(id) {
            this.showModal = !this.showModal;
            this.LIST_FOOD(id);
        },

        passOrder(id, status_id, driver){
            console.log(driver);
            var data = {id, driver};
            this.SEND_ORDER_TO_COURIER(data);

            this.nextStep(id, status_id);
        },

        nextStep(id, status_id){
            this.TRANSITION_TO_A_NEW_STAGE(id);
            this.SELECTED_ALL_STATUSES();
            this.SELECTED_ORDERS_BY_STATUS(status_id)
        },

        updateOrders() {
            setInterval(() => {
                this.SELECTED_ALL_STATUSES();
                this.SELECTED_ORDERS();
                this.SELECTED_ALL_DRIVERS();
                console.log('Данные обновились');
            }, 100000);
        },

        viewDriver(driver, order) {
            this.VIEW_DRIVER(driver);
            $('.driver-' + order).css('display', 'block');
        },

        hideDriver(order) {
            $('.driver-' + order).css('display', 'none');
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