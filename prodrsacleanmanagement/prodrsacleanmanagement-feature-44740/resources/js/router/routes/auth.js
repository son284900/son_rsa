/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2019/12/24
 */

// import requiredGuest from './guards/required-guest';
import Login from '@/js/components/pages/Login';

export default [
    {
        path: '/auth/login',
        name: 'login',
        component: Login,
        // beforeEnter: requiredGuest,
        meta: {
            title: 'Login',
            hideNav: true,
            hideBar: true,
        },
    },
];