

require('./bootstrap');

window.Vue = require('vue');


import User from './helpers/User';
window.User = User;

window.axios = require('axios');
//Vue.component('home', require('./components/Home.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));

Vue.component('app-home', require('./AppHome.vue').default);
import router from './routes/routes.js';

const app = new Vue({
    el: '#app',
    router
});
