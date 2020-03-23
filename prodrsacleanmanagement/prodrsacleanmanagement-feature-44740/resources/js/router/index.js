/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2019/12/24
 */

import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from '@/js/router/routes';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes,
});

export default router;