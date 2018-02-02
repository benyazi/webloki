
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

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('admin-website-edit', require('./components/AdminWebsiteEditComponent.vue'));
Vue.component('admin-website-add', require('./components/AdminWebsiteAddComponent.vue'));
Vue.component('admin-website-page-add', require('./components/AdminWebsitePageAddComponent.vue'));
Vue.component('admin-website-media', require('./components/AdminWebsiteMediaComponent.vue'));


const app = new Vue({
    el: '#app'
});
