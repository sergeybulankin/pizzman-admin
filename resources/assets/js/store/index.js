import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

Vue.config.debug = true;

const debug = process.env.NODE_ENV !== 'production';

import dashboard from './modules/dashboard';

export default new Vuex.Store({
    modules: {
        dashboard
    },
    strict: debug
});