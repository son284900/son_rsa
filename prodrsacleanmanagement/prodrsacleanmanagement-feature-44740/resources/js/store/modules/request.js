/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2019/12/24
 */
import responseMix from '@/js/mixins/ResponseMixin';

/**
 * APIリクエスト状態管理
 */
const apiBaseUrl = process.env.MIX_API_URI + "/api/v" + process.env.MIX_APP_VERSION + "/";

export default {
    mixins: [responseMix],
    namespaced: true,
    state: {
        status: ""
    },
    mutations: {
        REQUEST(state) {
            this._vm.$http.defaults.baseURL = apiBaseUrl;
            state.status = "loading";
        },
        SUCCESS(state) {
            state.status = "success";
        },
        FAILED(state) {
            state.status = "failed";
        },
        ERROR(state) {
            state.status = "error";
        }
    },
    actions: {
        get({ commit }, url) {
            return new Promise((resolve, reject) => {
                commit("REQUEST");
                this._vm.$http
                    .get(url)
                    .then(responseMix.methods.makeResponse)
                    .then(responseMix.methods.handleErrors)
                    .then(res => {
                        if (String(res.status) === "success") {
                            commit("SUCCESS");
                            resolve(res);
                        } else {
                            commit("FAILED");
                            reject(res);
                        }
                    })
                    .catch(err => {
                        const response = responseMix.data().response;
                        response.httpStatus = err.httpStatus;
                        response.status = err.status;
                        response.result.message = err.message;
                        response.result.code = err.code;

                        commit("ERROR");
                        reject(response);
                    });
            });
        },

        async post({ dispatch, commit }, { url, data }) {
            commit("REQUEST");
            this.data = data;
            return await dispatch("submit", { requestType: "post", url: url });
        },

        async put({ dispatch, commit }, { url, data }) {
            commit("REQUEST");
            this.data = data;
            return await dispatch("submit", { requestType: "put", url: url });
        },

        async delete({ dispatch, commit }, { url, data }) {
            commit("REQUEST");
            this.data = { params: data };
            return await dispatch("submit", {
                requestType: "delete",
                url: url
            });
        },

        async submit({ commit }, { requestType, url }) {
            return new Promise((resolve, reject) => {
                this._vm.$http[requestType](url, this.data)
                    .then(responseMix.methods.makeResponse)
                    .then(responseMix.methods.handleErrors)
                    .then(res => {
                        if (String(res.status) === "success") {
                            commit("SUCCESS");
                            resolve(res);
                        } else {
                            commit("FAILED");
                            reject(res);
                        }
                    })
                    .catch(err => {
                        const response = responseMix.data().response;

                        response.httpStatus = err.httpStatus;
                        response.status = err.status;
                        response.result.message = err.message;
                        response.result.code = err.code;

                        commit("ERROR");
                        reject(response);
                    });
            });
        }
    },
    getters: {
        status: state => state.status
    }
};
