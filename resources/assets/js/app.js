import Vue from 'vue';
import VueOnsen from 'vue-onsenui';

Vue.use(VueOnsen);

window.Vue = Vue;

const page2 = {
    key: 'page2',
    template: '#page2'
};

const page1 = {
    key: 'page1',
    template: '#page1',
    methods: {
        push() {
            this.$emit('push-page', page2);
        }
    }
};

new Vue({
    el: '#app',
    template: '#main',
    data() {
        return {
            pageStack: [page1]
        };
    }
});
