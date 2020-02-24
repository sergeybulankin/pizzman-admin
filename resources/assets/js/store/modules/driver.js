export default {
    actions: {
        SELECTED_ORDERS_FOR_DRIVER(ctx, id) {
            axios.post('/api/selected-orders-for-driver', {user: id})
                .then(res => {ctx.commit('SELECTED_ORDERS_FOR_DRIVER_MUTATION', res.data)})
                .catch(error => {console.log(error)})
        }
    },
    mutations: {
        SELECTED_ORDERS_FOR_DRIVER_MUTATION(state, orders) {
            state.orders = orders
        }
    },
    state: {
        orders: []
    },
    getters: {
        ORDERS(state) {
            return state.orders
        }
    }
}