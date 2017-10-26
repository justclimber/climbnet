window.axios = require('axios');

import Vue from 'vue';
import VueOnsen from 'vue-onsenui';

import ClimbList from './components/ClimbList.vue';

Vue.use(VueOnsen);

window.Vue = Vue;

new Vue({
    el: '#app',
    data() {
        return {
            pages: [ClimbList]
        };
    }
});
