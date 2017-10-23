
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import EventBus from './event-bus'

window.Vue = require('vue');

Vue.use(EventBus);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('command', require('./components/Command.vue'));
Vue.component('newcube', require('./components/NewCube.vue'));
Vue.component('flash', require('./components/Flash.vue'));

const app = new Vue({
    el: '#app'
});
