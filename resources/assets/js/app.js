
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import store from './store/index';

import VueCountdownTimer from 'vuejs-countdown-timer';
window.Vue.use(VueCountdownTimer);

window.moment = require('moment');

const settings = {
    apiKey: '38ec5068-da01-4278-9dab-69c6ccfa0954',
    lang: 'ru_RU',
    coordorder: 'latlong',
    version: '2.1',
};


import YmapPlugin from 'vue-yandex-maps';
import { yandexMap, ymapMarker } from 'vue-yandex-maps';
window.Vue.config.productionTip = false;
window.Vue.use(YmapPlugin, settings);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('board', require('./components/DashboardComponent.vue'));
Vue.component('user', require('./components/UserComponent.vue'));
Vue.component('navigation', require('./components/NavigationComponent.vue'));

const app = new Vue({
    el: '#app',
    store,
    components: { yandexMap, ymapMarker },
});
