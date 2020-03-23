/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2019/12/24
 */

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue';
import axios from 'axios';
import store from '@/js/store';
import router from '@/js/router';
import App from '@/js/components/pages/App.vue';
import vuetify from '@/js/config/vuetify';
import i18n from '@/js/i18n';
import validate from '@/js/validate';
import '@mdi/font/css/materialdesignicons.css';
import 'vuetify/dist/vuetify.min.css';

require('./bootstrap');

// axios
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Content-Type'] = 'application/json';

const crsfToken = document.head.querySelector('meta[name="csrf-token"]');
if (crsfToken) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = crsfToken.content;
}

// const accessToken = localStorage.getItem('keyAccessToken');

// if (accessToken) {
//     axios.defaults.headers.common['token'] = accessToken;
// }

// $http
Vue.prototype.$http = axios;

// router
Vue.router = router;

// store
Vue.store = store;

App.router = Vue.router;
App.store = Vue.store;

Vue.config.productionTip = false;

new Vue({
    vuetify,
    i18n,
    render: h => h(App),
}).$mount('#app');
