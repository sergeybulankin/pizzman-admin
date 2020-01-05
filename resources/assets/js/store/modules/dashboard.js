export default {
    actions: {
        SELECTED_ALL_STATUSES(ctx) {
            axios.get('/api/selected-all-statuses')
                .then(res => {ctx.commit('SELECTED_ALL_STATUSES_MUTATION', res.data.data)})
                .catch(error => {console.log(error)})
        },

        SELECTED_ORDERS(ctx) {
            axios.get('/api/selected-orders')
                .then(res => {ctx.commit('SELECTED_ORDERS_MUTATION', res.data.data)})
                .catch(error => {console.log(error)})
        },

        SELECTED_ORDERS_BY_STATUS(ctx, id) {
            axios.post('/api/selected-orders-by-status', {id: id})
                .then(res => {ctx.commit('SELECTED_ORDERS_MUTATION', res.data.data)})
                .catch(error => {console.log(error)})
        }
    },
    mutations: {
        SELECTED_ALL_STATUSES_MUTATION(state, statuses) {
            state.statuses = statuses
        },

        SELECTED_ORDERS_MUTATION(state, orders) {
            state.orders = orders
        }
    },
    state: {
        statuses: [],
        orders: []
    },
    getters: {
        ALL_STATUSES(state) {
            return state.statuses
        },

        ALL_ORDERS(state) {
            return state.orders
        }
    }
}