import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        settings: [],
        user: {}
    },
    actions: {
        loadSettings({commit}) {
            api.get('settings').then(response => commit('SET_SETTINGS', response.data))
        },
        serUser({commit}, user) {
            commit('SET_USER', user)
        }
    },
    mutations: {
        SET_SETTINGS(state, settings) {
            state.settings = settings
        },
        SET_USER(state, user) {
            state.user = user
        }
    },
    getters: {},
    modules: {}
});

export default store;