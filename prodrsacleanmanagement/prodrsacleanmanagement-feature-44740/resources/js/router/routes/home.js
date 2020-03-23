/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2019/12/24
 */

// import requiredGuest from './guards/required-guest';
import Home from '@/js/components/pages/Home';

export default [
    {
        path: '/',
        name: 'home',
        component: Home,
        // beforeEnter: requiredGuest,
        meta: {
            title: 'Home',
            hideNav: true,
            hideBar: true,

        },

    },
];