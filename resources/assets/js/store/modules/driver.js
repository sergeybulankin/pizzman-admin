export default {
    actions: {
        SELECTED_ORDERS_FOR_DRIVER(ctx, id) {
            axios.post('/api/selected-orders-for-driver', {user: id})
                .then(res => {ctx.commit('SELECTED_ORDERS_FOR_DRIVER_MUTATION', res.data)})
                .catch(error => {console.log(error)})
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
        }
    },
    state: {
        orders: [],
        count_orders: null
    },
    getters: {
        ORDERS(state) {
            return state.orders
        },

        COUNT_ORDERS(state) {
            return state.count_orders
        }
    }
}