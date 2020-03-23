/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2019/12/24
 */

import store from '@/js/store';

export default (to, from, next) => {
    if (!store.getters['auth/isLoggedIn']) {
        next('/auth/login');
    } else {
        next();
    }
};