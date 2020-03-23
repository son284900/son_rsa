/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2019/12/24
 */

import Vue from 'vue';
import Vuex from 'vuex';
import modules from './modules';

Vue.use(Vuex);

export default new Vuex.Store({
    modules,
});