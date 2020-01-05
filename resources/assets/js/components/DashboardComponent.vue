<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <h1>Главная таблица</h1>
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
                <div v-for="(order, index) in ALL_ORDERS" :key="index">
                    {{ order.id }}
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
        computed: mapGetters(['ALL_STATUSES', 'ALL_ORDERS']),
        methods: {
            ...mapActions([
                    'SELECTED_ALL_STATUSES',
                    'SELECTED_ORDERS',
                    'SELECTED_ORDERS_BY_STATUS'
                ]),

            changeOrdersByStatus(id) {
                this.SELECTED_ORDERS_BY_STATUS(id)
            }
        }
    }
</script>

<style>
    .count {
        padding: 4px;
        background: #ffac92;
        color: red;
        border-radius: 3px;
    }

    .mt-50 {
        margin-top: 50px;
    }
</style>
