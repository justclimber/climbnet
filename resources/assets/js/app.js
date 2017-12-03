
import Vue from 'vue';
import Vuetify from 'vuetify'

import acl from 'vue-browser-acl'
import router from './router'
import Api from './api.js';
import store from './store'
import App from './App.vue'

window.api = new Api('/api/');

Vue.use(Vuetify, {
    theme: {
        primary: '#3f51b5',
        secondary: '#b0bec5',
        accent: '#8c9eff',
        error: '#b71c1c'
    }
});
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
});
