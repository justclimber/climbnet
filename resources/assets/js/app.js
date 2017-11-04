import 'onsenui/css/onsenui.css'
import 'onsenui/css/onsen-css-components.css'

window.axios = require('axios');

import Vue from 'vue';
import VueOnsen from 'vue-onsenui';
import router from './router'
import store from './store'
import App from './App.vue'

Vue.use(VueOnsen);

new Vue({
    el: '#app',
    router,
    store,
    template: '<App/>',
    components: { App }
})
