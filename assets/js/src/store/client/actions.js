import axios from 'axios';
import * as mutations from './mutations';
import {REFRESH_SESSION} from '@/store/auth/actions';
import {headers} from '@/utils/http';

export const REQUEST = 'request';
export const XSRF_REQUEST = 'xsrfRequest';

const getAxiosError = (error) => {
    if (error.response) {
        return error.response.data;
    } else {
        // Something happened in setting up the request that triggered an Error
        return error.message;
    }
};
const refreshSession = ({dispatch, rootState}, axiosRequestConfig) => {
    return dispatch(`auth/${REFRESH_SESSION}`, null, {root: true}).then(
        doLogin => {
            if (doLogin) {
                let error =  new Error();
                error.errorMessages = 'Your session has expired';
                throw error;
            } else {
                axiosRequestConfig.headers = headers.setXsrfToken(rootState.xsrfToken, axiosRequestConfig.headers);
                return dispatch(REQUEST, axiosRequestConfig);
            }
        }
    );
};

export default {
    [REQUEST] ({state, commit}, axiosRequestConfig) {
        commit(mutations.ADD_MESSAGE, axiosRequestConfig);
        const index = state.all.length - 1;

        commit(mutations.SET_REQUEST_PENDING, index);
        return axios.request(axiosRequestConfig).then(
            (response) => {
                commit(mutations.SET_REQUEST_TERMINATED, index);
                commit(mutations.SET_RESPONSE, {index: index, response: response});
                return response;
            }
        ).catch(
            (error) => {
                let setError = true;
                commit(mutations.SET_REQUEST_TERMINATED, index);
                if (error.response) {
                    commit(mutations.SET_RESPONSE, {index: index, response: error.response});
                    if (error.response.status === 412) {
                        setError = false;
                    }
                }

                if (setError) {
                    const errorMessages = getAxiosError(error);
                    commit(mutations.SET_ERROR, {index: index, error: errorMessages});
                    error.errorMessages = errorMessages.errors;
                }

                throw error;
            }
        );
    },
    [XSRF_REQUEST] ({dispatch, commit, state, rootState}, axiosRequestConfig) {
        axiosRequestConfig.headers = headers.setXsrfToken(rootState.xsrfToken, axiosRequestConfig.headers);
        return dispatch(REQUEST, axiosRequestConfig).catch(
            error => {
                if (error.response && error.response.status === 412) {
                    return refreshSession({dispatch, commit, state, rootState}, axiosRequestConfig);
                }
            }).then(
            response => response
        );
    }
};
