export default {
    actions: {
        SELECTED_ORDERS_FOR_DRIVER(ctx, id) {
            var success = 'Заказы: работают в фоновом режиме';
            var error_message = 'Заказы: произошел сбои в работе';

            axios.post('/api/selected-orders-for-driver', {user: id})
                .then(res => {ctx.commit('SELECTED_ORDERS_FOR_DRIVER_MUTATION', res.data)})
                .then(res => {ctx.commit('SYSTEM_WORK_ORDER_FOR_DRIVER_MUTATION', success)})
                .catch(error => {ctx.commit('SYSTEM_WORK_ORDER_FOR_DRIVER_MUTATION', error_message)})
        },

        COUNT_ACTIVE_ORDERS(ctx, id) {
            axios.post('/api/count-active-orders', {user: id})
                .then(res => {ctx.commit('COUNT_ACTIVE_ORDERS_MUTATION', res.data)})
                .catch(error => {console.log(error)})
        },

        ORDER_DELIVERED(ctx, id) {
            axios.post('/api/order-delivered', {order_status: id})
                .then(console.log('Товар доставлен'))
                .catch(error => {console.log(error)})
        }
    },
    mutations: {
        SELECTED_ORDERS_FOR_DRIVER_MUTATION(state, orders) {
            state.orders = orders
        },

        COUNT_ACTIVE_ORDERS_MUTATION(state, count) {
            state.count_orders = count
        },

        SYSTEM_WORK_ORDER_FOR_DRIVER_MUTATION(state, message) {
            state.system_orders_for_driver = message
        }
    },
    state: {
        orders: [],
        count_orders: null,
        system_orders_for_driver: ''
    },
    getters: {
        ORDERS(state) {
            return state.orders
        },

        COUNT_ORDERS(state) {
            return state.count_orders
        },

        SYSTEM_WORK_ORDERS_FOR_DRIVER(state) {
            return state.system_orders_for_driver
        },
    }
}