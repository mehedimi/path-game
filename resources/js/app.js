require('./bootstrap');
import Vue from 'vue';
import VueChatScroll from 'vue-chat-scroll';

window.Vue = Vue;


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/GameBody.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('game-body', require('./components/GameBody.vue').default);
Vue.component('nav-bar', require('./components/Navbar').default);
Vue.component('invite', require('./components/Invite').default);
Vue.component('invitation', require('./components/Invitation').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(VueChatScroll);

const app = new Vue({
    el: '#app',
});
