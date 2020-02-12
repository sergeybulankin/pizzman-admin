import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

Vue.config.debug = true;

const debug = process.env.NODE_ENV !== 'production';

import dashboard from './modules/dashboard';
import user from './modules/user';

export default new Vuex.Store({
    modules: {
        dashboard,
        user
    },
    strict: debug
});