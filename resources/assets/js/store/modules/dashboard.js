export default {
    actions: {
        SELECTED_ALL_STATUSES(ctx) {
            axios.get('/api/selected-all-statuses')
                .then(res => {ctx.commit('SELECTED_ALL_STATUSES_MUTATION', res.data.data)})
                .catch(error => {console.log(error)})
        },

        SELECTED_ORDERS(ctx) {
            setTimeout(() => {
                axios.get('/api/selected-orders')
                    .then(res => {ctx.commit('SELECTED_ORDERS_MUTATION', res.data.data)})
                    .catch(error => {console.log(error)})
                    .finally (() => { ctx.commit('LOADER_MUTATION') })
            }, 2000)
        },

        SELECTED_ORDERS_BY_STATUS(ctx, id) {
            ctx.commit('LOADER_VISIBILITY_MUTATION');

            setTimeout(() => {
                axios.post('/api/selected-orders-by-status', {id: id})
                    .then(res => {ctx.commit('SELECTED_ORDERS_MUTATION', res.data.data)})
                    .catch(error => {console.log(error)})
                    .finally (() => { ctx.commit('LOADER_MUTATION') })
            }, 1000)
        },

        TRANSITION_TO_A_NEW_STAGE(ctx, id) {
            axios.post('/api/transition-to-a-new-stage', {id: id})
                .then(res => {console.log('Заказ перешел на новую стадию')})
                .catch(error => {console.log(error)})
        }
    },
    mutations: {
        SELECTED_ALL_STATUSES_MUTATION(state, statuses) {
            state.statuses = statuses
        },

        SELECTED_ORDERS_MUTATION(state, orders) {
            state.orders = orders
        },

        LOADER_MUTATION(state) {
            state.loading = false
        },

        LOADER_VISIBILITY_MUTATION(state) {
            state.loading = true
        }
    },
    state: {
        statuses: [],
        orders: [],
        loading: true
    },
    getters: {
        ALL_STATUSES(state) {
            return state.statuses
        },

        ALL_ORDERS(state) {
            return state.orders
        },

        LOADER(state) {
            return state.loading
        }
    }
}