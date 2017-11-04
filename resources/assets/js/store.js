import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        settings: []
    },
    actions: {
        loadSettings({commit}) {
            axios.get('/api/settings').then(response => commit('SET_SETTINGS', response.data))
        }
    },
    mutations: {
        SET_SETTINGS(state, settings) {
            state.settings = settings
        }
    },
    getters: {},
    modules: {}
});

export default store;