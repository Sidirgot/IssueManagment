import '@fortawesome/fontawesome-free/js/all.js'

require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
import VModal from 'vue-js-modal'

import backend from './Backend/backend'
import routes from './routes'
import store from './store/store'


Vue.use(VueRouter)
Vue.use(VModal)

const router  = new VueRouter(routes)

const wrapper = new Vue({
    el: '#app',
    components: {backend},
    router,
    store
})