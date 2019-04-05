import axios from 'axios';
import * as mutations from './mutations';
import {headers} from '../../utils/http';

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
                commit(mutations.SET_REQUEST_TERMINATED, index);
                if (error.response) {
                    commit(mutations.SET_RESPONSE, {index: index, response: error.response});
                }
                const errorMessages = getAxiosError(error);
                commit(mutations.SET_ERROR, {index: index, error: errorMessages});
                error.errorMessages = errorMessages.errors;
                throw error;
            }
        );
    },
    [XSRF_REQUEST] ({dispatch, rootState}, axiosRequestConfig) {
        axiosRequestConfig.headers = headers.setXsrfToken(rootState.xsrfToken, axiosRequestConfig.headers);
        return dispatch(REQUEST, axiosRequestConfig);
    }
};
