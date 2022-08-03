/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Vue-Step-Wizard
 */
 import VueStepWizard from 'vue-step-wizard'
 import 'vue-step-wizard/dist/vue-step-wizard.css'
 Vue.use(VueStepWizard);


/**
 * Vue2-DatePicker
 */

import DatePicker from 'vue2-datepicker'
import 'vue2-datepicker/index.css'
Vue.use(DatePicker)

/**
 * VUE-MOMENT; formato de fechas
 */

Vue.use(require('vue-moment'))

/**
 * Vue Select para los droplist
 */

import Vue from 'vue'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';

/*
 * Vuelidate
*/
import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)

Vue.component('v-select', vSelect)

/*
 *  Simple-vue-Validator
 */
import SimpleVueValidation from 'simple-vue-validator';
Vue.use(SimpleVueValidation);

/**
 * ROLES Y PERMISOS
 */

 import Auth from './Auth'

 Vue.prototype.$auth = new Auth(window.user);
//  console.log( window.user);

/**
 * Vue Router
 */
import router from './routes'


/**
 * ELEMENT-UI
 */
 import ElementUI from 'element-ui';
 import 'element-ui/lib/theme-chalk/index.css';
 Vue.use(ElementUI)




Vue.component('App', require('./components/App.vue').default);
Vue.component('Auth', require('./components/Auth.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: '#app',
    router
});
