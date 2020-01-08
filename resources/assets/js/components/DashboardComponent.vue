<template>
    <div class="container">
        <div class="row">
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
                        <td class="address">{{ order.address.address }} - {{ order.address.kv }}</td>
                        <td>
                            <button class="btn btn-danger" @click="nextStep(order.id, order.status[0].status_id)">Дальше</button>

                            <div v-if="order.status[0].status_id == 5">
                                <h5>выбрать водителя</h5>
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
        mounted() {
            this.SELECTED_ALL_STATUSES();
            this.SELECTED_ORDERS();
        },
        computed: mapGetters(['ALL_STATUSES', 'ALL_ORDERS', 'LOADER']),
        methods: {
            ...mapActions([
                    'SELECTED_ALL_STATUSES',
                    'SELECTED_ORDERS',
                    'SELECTED_ORDERS_BY_STATUS',
                    'TRANSITION_TO_A_NEW_STAGE'
                ]),

            changeOrdersByStatus(id) {
                this.SELECTED_ORDERS_BY_STATUS(id)
            },

            nextStep(id, status_id){
                this.TRANSITION_TO_A_NEW_STAGE(id);
                this.SELECTED_ALL_STATUSES();
                this.SELECTED_ORDERS_BY_STATUS(status_id)
            }
        }
    }
</script>

<style>
    .table-title {
        background: #f5f5f5;
    }
    .table-title td {
        padding: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .list td {
        padding: 12px;
        font-size: 14px;
    }
    .number-order {
        width: 150px;
        text-align: center;
    }
    .number-phone {
        width: 150px;
    }
    .list-foods {
        width: 250px;
    }

    .list > .address {
        font-size: 12px;
    }

    .count {
        padding: 4px;
        background: #ffac92;
        color: red;
        border-radius: 3px;
    }

    .load {
        text-align: center;
    }

    .mt-50 {
        margin-top: 50px;
    }
</style>
