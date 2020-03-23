/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/03/02
 */

import List from '@/js/components/pages/CleanStatusMasterList';
// import requiredAuth from './guards/required-auth';

export default [
    {
        path: '/master/clean/status/list',
        name: 'master.clean.status.list',
        component: List,
        // beforeEnter: requiredAuth,
        meta: {
            title: '清掃ステータスマスタ',
            hideNav: false,
            hideBar: false,
        },
    },
];