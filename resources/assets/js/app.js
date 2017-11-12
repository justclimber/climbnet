import 'onsenui/css/onsenui.css'
import 'onsenui/css/onsen-css-components.css'

window.axios = require('axios');

import Vue from 'vue';
import acl from 'vue-browser-acl'
import VueOnsen from 'vue-onsenui';
import router from './router'
import store from './store'
import App from './App.vue'

Vue.use(VueOnsen);
Vue.use(acl, store.user, require('./acl').aclRules);

new Vue({
    el: '#app',
    router,
    store,
    template: '<App/>',
    components: { App },
    beforeMount: function () {
        this.$store.commit('SET_SETTINGS', JSON.parse(this.$el.attributes['data-settings'].value));
        this.$store.commit('SET_USER', JSON.parse(this.$el.attributes['data-user'].value));
    },
})
