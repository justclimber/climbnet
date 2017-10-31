import Vue from 'vue';
import Router from 'vue-router';
import ClimbList from './components/ClimbList.vue';
import ClimbSave from './components/ClimbSave.vue';

Vue.use(Router);

const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'climbs',
            component: ClimbList,
            children: [
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