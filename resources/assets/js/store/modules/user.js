export default {
    actions: {
        SELECTED_ALL_INFO_FOR_USER(ctx) {
            var id = document.querySelector("meta[name='user-id']").getAttribute('content');

            axios.post('/api/info-for-user', {user: id})
                .then(res => {ctx.commit('SELECTED_ALL_FOR_USER_MUTATION', res.data.data)})
                .catch(error => {console.log(error)})
        },

        LOADED_CALLS(ctx) {
            var success = 'Звонки: работают в фоновом режиме';
            var error_message = 'Звонки: произошел сбои в работе';

            axios.get('/api/selected-calls')
                .then(res => {ctx.commit('SELECTED_CALLS_MUTATION', res.data)})
                .then(res => {ctx.commit('SYSTEM_WORK_CALLS_MUTATION', success)})
                .catch(error => {ctx.commit('SYSTEM_WORK_CALLS_MUTATION', error_message)})
        },

        SELECTED_INFO_POINT(ctx) {
            var id = document.querySelector("meta[name='user-id']").getAttribute('content');

            axios.post('/api/info-for-user-point', {user: id})
                .then(res => {ctx.commit('SELECTED_INFO_POINT_MUTATION', res.data.data)})
                .catch(error => {console.log(error)})
        },

        SELECTED_CALLS(ctx) {
            var success = 'Звонки: работают в фоновом режиме';
            var error_message = 'Звонки: произошел сбои в работе';
            
            setInterval(() => {
                axios.get('/api/selected-calls')
                    .then(res => {ctx.commit('SELECTED_CALLS_MUTATION', res.data)})
                    .then(console.log('Обновился счетчик звонков'))
                    .then(res => {ctx.commit('SYSTEM_WORK_CALLS_MUTATION', success)})
                    .catch(error => {ctx.commit('SYSTEM_WORK_CALLS_MUTATION', error_message)})
            }, 100000);
        }
    },

    state: {
        role: [],
        user: [],
        system_calls: '',
        calls: 0,
        point: []
    },

    mutations: {
        setAuthUser(state, role) {
            state.role = role;
        },

        SELECTED_ALL_FOR_USER_MUTATION(state, user) {
            state.user = user;
        },

        SELECTED_INFO_POINT_MUTATION(state, point) {
            state.point = point;
        },

        SELECTED_CALLS_MUTATION(state, calls) {
            state.calls = calls
        },

        SYSTEM_WORK_CALLS_MUTATION(state, message) {
            state.system_calls = message
        }
    },

    getters: {
        ROLE(state) {
            return state.role;
        },

        USER(state) {
            return state.user;
        },

        CALLS(state) {
            return state.calls;
        },

        SYSTEM_WORK_CALLS(state) {
            return state.system_calls;
        },

        POINT(state) {
            return state.point;
        }
    }
}