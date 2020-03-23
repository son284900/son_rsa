/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2019/12/26
 */

import List from '@/js/components/pages/ShiftMasterList';
// import requiredAuth from './guards/required-auth';

export default [
    {
        path: '/master/shift/list',
        name: 'master.shift.list',
        component: List,
        // beforeEnter: requiredAuth,
        meta: {
            title: '清掃シフトマスタ',
            hideNav: false,
            hideBar: false,
        },
    },
];