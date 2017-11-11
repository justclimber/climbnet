import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'login',
            component: require('./pages/Login'),
        },
        {
            path: '/climbs',
            name: 'climbs',
            component: require('./pages/ClimbList'),
            children: [
                {
                    path: ':id',
                    name: 'climb',
                    component: require('./pages/ClimbSave'),
                    children: [
                        {
                            path: 'routes/create',
                            name: 'new-route',
                            component: require('./pages/ClimbedRoute')
                        }
                    ]
                }
            ]
        }
    ]
});

export default router;