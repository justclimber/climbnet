import Vue from 'vue';
import Router from 'vue-router';
import Template from './components/Template';
import ClimbList from './components/ClimbList.vue';
import ClimbSave from './components/ClimbSave.vue';

Vue.use(Router);

const extend = name => ({ name, extends: Template });

const router = new Router({
    routes: [
        {
            path: '/',
            name: 'Home',
            component: extend('Home'),
            children: [
                {
                    path: 'climbs',
                    name: 'climbs',
                    component: ClimbList
                },
                {
                    path: 'climb/save',
                    name: 'climb-save',
                    component: ClimbSave
                }
            ]
        }
    ]
});

export default router;