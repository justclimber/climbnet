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
            meta: {
                can: 'view MyClimbs',
                fail: '/login'
            },
        //     children: [
        //         {
        //             path: ':id',
        //             name: 'climb',
        //             component: require('./pages/ClimbSave'),
        //             children: [
        //                 {
        //                     path: 'routes/create',
        //                     name: 'new-route',
        //                     component: require('./pages/ClimbedRoute')
        //                 },
        //                 {
        //                     path: 'routes/:route_id',
        //                     name: 'route-save',
        //                     component: require('./pages/ClimbedRoute')
        //                 },
        //             ]
        //         }
        //     ]
        },
        {
            path: '/climbs/:id',
            name: 'climb',
            component: require('./pages/ClimbSave'),
        },
        {
            path: '/climbs/:id/routes/create',
            name: 'new-route',
            component: require('./pages/ClimbedRoute'),
        },
        {
            path: '/climbs/:id/routes/:route_id',
            name: 'route-save',
            component: require('./pages/ClimbedRoute'),
        },
    ]
});

export default router;