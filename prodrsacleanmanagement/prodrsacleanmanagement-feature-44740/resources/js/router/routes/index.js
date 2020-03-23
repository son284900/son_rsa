/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2019/12/24
 */

import home from './home';
import auth from './auth';
import dashboard from './dashboard';
import mastershift from './master-shift';
import mastercleanstatus from './master-clean-status';

export default [
    ...home,
    ...auth,
    ...dashboard,
    ...mastershift,
    ...mastercleanstatus,
];