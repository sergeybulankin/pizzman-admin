export default {
    actions: {
        SELECTED_ALL_STATUSES(ctx) {
            var id = document.querySelector("meta[name='user-id']").getAttribute('content');
            var success = 'Статусы: работают в фоновом режиме';
            var error_message = 'Статусы: произошел сбои в работе';

            axios.post('/api/selected-all-statuses', {user: id})
                .then(res => {ctx.commit('SELECTED_ALL_STATUSES_MUTATION', res.data.data)})
                .then(res => {ctx.commit('SYSTEM_WORK_STATUSES_MUTATION', success)})
                .catch(error => {ctx.commit('SYSTEM_WORK_STATUSES_MUTATION', error_message)})
        },

        SELECTED_ORDERS(ctx) {
            var id = document.querySelector("meta[name='user-id']").getAttribute('content');
            var success = 'Заказы: работают в фоновом режиме';
            var error_message = 'Заказы: произошел сбои в работе';

            setTimeout(() => {
                axios.post('/api/selected-orders', {user: id})
                    .then(res => {ctx.commit('SELECTED_ORDERS_MUTATION', res.data.data)})
                    .then(res => {ctx.commit('SYSTEM_WORK_ORDERS_MUTATION', success)})
                    .then(res => {ctx.commit('SYSTEM_WORK_ORDERS_UPDATE_MUTATION', Date.now())})
                    .catch(error => {ctx.commit('SYSTEM_WORK_ORDERS_MUTATION', error_message)})
                    .finally (() => { ctx.commit('LOADER_MUTATION') })
            }, 2000)
        },

        SELECTED_ORDERS_BY_STATUS(ctx, id) {
            ctx.commit('LOADER_VISIBILITY_MUTATION');

            var user = document.querySelector("meta[name='user-id']").getAttribute('content');

            setTimeout(() => {
                axios.post('/api/selected-orders-by-status', {id: id, user: user})
                    .then(res => {ctx.commit('SELECTED_ORDERS_MUTATION', res.data.data)})
                    .catch(error => {console.log(error)})
                    .finally (() => { ctx.commit('LOADER_MUTATION') })
            }, 1000)
        },

        SELECTED_ALL_DRIVERS(ctx) {
            axios.get('/api/selected-all-drivers')
                .then(res => {ctx.commit('SELECTED_ALL_DRIVERS_MUTATION', res.data.data)})
                .catch(error => {console.log(error)})
        },

        LIST_FOOD(ctx, id) {
            axios.post('/api/selected-list-food', {id: id})
                .then(res => (ctx.commit('LIST_FOOD_MUTATION', res.data)))
                .catch(error => {console.log(error)})
        },

        TRANSITION_TO_A_NEW_STAGE(ctx, id) {
            axios.post('/api/transition-to-a-new-stage', {id: id})
                .then(res => {console.log('Заказ перешел на новую стадию')})
                .catch(error => {console.log(error)})
        },

        SEND_ORDER_TO_COURIER(ctx, data) {
            axios.post('/api/send-order-to-courier', {order_id: data.id, driver: data.driver})
                .then(res => {console.log('Заказ закреплен за курьером')})
                .catch(error => {console.log(error)})
        },

        VIEW_DRIVER(ctx, driver) {
            axios.post('/api/view-driver', {driver: driver})
                .then(res => {ctx.commit('VIEW_DRIVER_MUTATION', res.data)})
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

        SELECTED_ALL_DRIVERS_MUTATION(state, drivers) {
            state.drivers = drivers
        },

        LOADER_MUTATION(state) {
            state.loading = false
        },

        LOADER_VISIBILITY_MUTATION(state) {
            state.loading = true
        },

        VIEW_DRIVER_MUTATION(state, driver) {
            state.driver = driver
        },

        LIST_FOOD_MUTATION(state, list) {
            return state.list = list
        },

        SYSTEM_WORK_STATUSES_MUTATION(state, message) {
            state.system_statuses = message
        },

        SYSTEM_WORK_ORDERS_MUTATION(state, message) {
            state.system_orders = message
        },

        SYSTEM_WORK_ORDERS_UPDATE_MUTATION(state, date) {
            state.system_date_update = date
        }
    },
    state: {
        statuses: [],
        orders: [],
        drivers: [],
        driver: [],
        list: [],
        system_statuses: '',
        system_orders: '',
        system_date_update: Date.now(),
        loading: true
    },
    getters: {
        ALL_STATUSES(state) {
            return state.statuses
        },

        ALL_ORDERS(state) {
            return state.orders
        },

        ALL_DRIVERS(state) {
            return state.drivers
        },

        DRIVER(state) {
            return state.driver
        },

        LOADER(state) {
            return state.loading
        },

        LIST(state) {
            return state.list
        },

        SYSTEM_WORK_STATUSES(state) {
            return state.system_statuses
        },

        SYSTEM_WORK_ORDERS(state) {
            return state.system_orders
        },

        SYSTEM_DATE_UPDATE(state) {
            return state.system_date_update
        }
    }
}