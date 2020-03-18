export default {
    actions: {
        SELECTED_ALL_INFO_FOR_USER(ctx) {
            var id = document.querySelector("meta[name='user-id']").getAttribute('content');

            axios.post('/api/info-for-user', {user: id})
                .then(res => {ctx.commit('SELECTED_ALL_FOR_USER_MUTATION', res.data.data)})
                .catch(error => {console.log(error)})
        },

        SELECTED_CALLS(ctx) {
            setInterval(() => {
                axios.get('/api/selected-calls')
                    .then(res => {ctx.commit('SELECTED_CALLS_MUTATION', res.data)})
                    .then(console.log('Обновился счетчик звонков'))
                    .catch(error => {console.log(error)})
            }, 100000);
        }
    },

    state: {
        role: [],
        user: [],
        calls: 0
    },

    mutations: {
        setAuthUser(state, role) {
            state.role = role;
        },

        SELECTED_ALL_FOR_USER_MUTATION(state, user) {
            state.user = user;
        },

        SELECTED_CALLS_MUTATION(state, calls) {
            state.calls = calls
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
            return state.calls
        }
    }
}