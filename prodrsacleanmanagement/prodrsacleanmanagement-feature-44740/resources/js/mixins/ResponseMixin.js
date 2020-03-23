/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/02/03
 */
class ResponseError extends Error {
    constructor(message, status, httpStatus, code) {
        super(message);
        this.name = this.constructor.name;
        this.code = code;
        this.status = status;
        this.httpStatus = httpStatus;

    }
}

/**
 * Response Codes
 *
 * @return object Codes
 */
const responseCodes = () => {
    return {
        CODE_SUCCESS: '25000000',
        CODE_NOT_TOKEN: '40010001',
        CODE_INVALID_TOKEN: '40010002',
        CODE_EXPIRED_TOKEN: '40010003',
        CODE_NETWORK_ERROR: '55015500',
    };
};

/**
 * isFailed Auth
 *
 * @return boolean
 */
const isFailedAuth = ($code) => {
    let $result = false;
    if (responseCodes().CODE_INVALID_TOKEN === $code ||
        responseCodes().CODE_EXPIRED_TOKEN === $code ||
        responseCodes().CODE_NOT_TOKEN === $code ) {
        $result = true;
    }

    return $result;
};

/**
 * @typedef {Object} Response
 * @property {int} httpStatus
 * @property {string} status
 * @property {Object} result
 */
/** @type {function(): {result: {code: string, data: Array, message: string}, httpStatus: number, status: string}} */
const responseFormat = () => {
    return {
        httpStatus: 0,
        status: '',
        result: {data: [], message: "", code: "", errors: []},
    };
};

export default {
    data() {
        return {
            /** @type {Response} */
            response: responseFormat(),
        };
    },
    methods: {

        /**
         * Error handler
         * HTTP ERRORを検知する
         *
         * @param res
         */
        handleErrors: function (res) {
            let httpStatus = res.httpStatus ? res.httpStatus : 0;
            const status = String(res.status);

            if (httpStatus === 200 && status === 'success') {
                return res;

            }

            if (httpStatus === 200 && (status === 'failed' || status === 'failed_auth')) {
                const errCode = res.result.code;

                if (errCode.length === 3) {
                    httpStatus = parseInt(errCode, 10);

                } else {
                    return res;

                }
            }

            // 300番台はまとめる
            if (String(httpStatus).length === 3 &&
                String(httpStatus).slice(0, 1) === '3') {
                httpStatus = 300;
            }

            switch (httpStatus) {
                case 300:
                    throw new ResponseError('Redirection Error.', status, httpStatus, '50015001');
                case 400:
                    throw new ResponseError('Bad Request.', status, httpStatus, '50015001');
                case 401:
                    throw new ResponseError('Unauthorized.', status, httpStatus, '50015001');
                case 404:
                    throw new ResponseError('Not Found.', status, httpStatus, '50015001');
                case 500:
                    throw new ResponseError('Internal Server Error.', status, httpStatus, '50015001');
                case 502:
                    throw new ResponseError('Bad Gateway.', status, httpStatus, '50015001');
                default:
                    throw new ResponseError('Unhandled Error.', status, httpStatus, '50015001');
            }
        },

        /**
         * make Result
         *
         * @param object
         * @return object
         */
        makeResponse: function (res) {
            const result = responseFormat();
            result.httpStatus = res.status;
            result.result.data = res.data.result.data;
            result.result.message = res.data.result.message;
            result.result.code = res.data.result.code;
            result.result.errors = res.data.result.errors;

            if (isFailedAuth(result.result.code)) {
                result.status = 'failed_auth';

            } else {
                result.status = res.data.status;
            }

            if (String(result.status) === 'success') {
                result.result.code = responseCodes().CODE_SUCCESS;
            }

            return result;
        },
    },
}
