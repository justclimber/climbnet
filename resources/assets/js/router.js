import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'climbs',
            component: require('./components/ClimbList'),
            children: [
                {
                    path: 'climbs/:id',
                    name: 'climb',
                    component: require('./components/ClimbSave'),
                    children: [
                        {
                            path: 'routes/create',
                            name: 'new-route',
                            component: require('./components/ClimbedRoute')
                        }
                    ]
                }
            ]
        }
    ]
});

export default router;