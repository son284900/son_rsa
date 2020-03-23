/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2019/12/24
 */

import Dashboard from '@/js/components/pages/Dashboard';
// import requiredAuth from './guards/required-auth';

export default [
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        // beforeEnter: requiredAuth,
        meta: {
            title: 'ダッシュボード',
            hideNav: false,
            hideBar: false,
        },
    },
];