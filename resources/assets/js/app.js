
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('buscar', require('./components/buscar.vue'));
Vue.component('estadisticas1', require('./components/estadisticas/e1'));
Vue.component('estadisticas2', require('./components/estadisticas/e2'));
Vue.component('estadisticas3', require('./components/estadisticas/e3'));
Vue.component('estadisticas4', require('./components/estadisticas/e4'));

const app = new Vue({
    el: '#app'
});
