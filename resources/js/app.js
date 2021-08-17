require('./bootstrap');

import Vue from 'vue'
import router from './router'
import store from './store'
import BootstrapVue from 'bootstrap-vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueCookies from 'vue-cookies'
import VueNoty from 'vuejs-noty'

import 'vuejs-noty/dist/vuejs-noty.css'

import VueHtml2pdf from 'vue-html2pdf'
Vue.use(VueHtml2pdf)

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.use(BootstrapVue)
Vue.use(VueAxios, axios)
Vue.use(VueCookies)
Vue.use(VueNoty)

Vue.config.productionTip = false
axios.defaults.baseURL = 'http://localhost:8000/api'

const app = new Vue({
    el: '#app',
    router,
    store
});
