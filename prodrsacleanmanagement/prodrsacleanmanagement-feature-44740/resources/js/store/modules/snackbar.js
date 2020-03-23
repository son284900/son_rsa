/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/02/03
 */
export default {
    namespaced: true,
    state: {
        status: false,
        text: '',
        color: '',
    },
    mutations: {
        SNACKBAR(state, {text, color}) {
            state.status = true;
            state.text = text;
            state.color = color;
        },
    },
    actions: {
        error({commit}, {type, result}) {
            const code = result.code ? ' (CODE:' + result.code + ')' : '';
            const text = type + 'に失敗しました' + code;
            commit('SNACKBAR', {text, color: 'error'});
        },
        success({commit}, {type}) {
            const text = type + 'に成功しました';
            commit('SNACKBAR', {text, color: 'success'});
        }
    },

};
