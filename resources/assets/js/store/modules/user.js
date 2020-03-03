export default {
    actions: {
        SELECTED_ALL_INFO_FOR_USER(ctx) {
            var id = document.querySelector("meta[name='user-id']").getAttribute('content');

            axios.post('/api/info-for-user', {user: id})
                .then(res => {ctx.commit('SELECTED_ALL_FOR_USER_MUTATION', res.data)})
                .catch(error => {console.log(error)})
        }
    },

    state: {
        role: [],
        user: []
    },

    mutations: {
        setAuthUser(state, role) {
            state.role = role;
        },

        SELECTED_ALL_FOR_USER_MUTATION(state, user) {
            state.user = user;
        }
    },

    getters: {
        ROLE(state) {
            return state.role;
        },

        USER(state) {
            return state.user;
        }
    }
}