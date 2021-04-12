
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.axios = require('axios');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 * Importing ES Modules
 * As part of the vue-loader 15 updates, if your code uses the CommonJS syntax
 * for importing EcmaScript modules, you'll need to append .default, like so:
 * require('./components/ExampleComponent.vue').default
 **/

export const EventEmitter = new Vue();
export const EventEmitterCreate = new Vue();
export const EventEmitterCss = new Vue();
export const EventEmitterCreateCss = new Vue();

Vue.component('aditional-js-component', require('./components/additionalJS/AditionalJsComponent.vue').default);
Vue.component('create-aditional-js-component', require('./components/createAdditionalJS/AditionalJsComponent.vue').default);
Vue.component('additional-css-component', require('./components/additionalCSS/AdditionalCssComponent.vue').default);
Vue.component('create-additional-css-component', require('./components/createAdditionalCSS/AdditionalCssComponent.vue').default);

const app = new Vue({
    el: '#app_main_admin'
});
