export default {
    state: {
        role: []
    },

    mutations: {
        setAuthUser(state, role) {
            state.role = role;
        }
    },

    getters: {
        ROLE(state) {
            return state.role;
        }
    }
}