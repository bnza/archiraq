import Vue from 'vue';
export const ADD_MESSAGE = 'addMessage';
export const SET_REQUEST_PENDING = 'setRequestPending';
export const SET_REQUEST_TERMINATED = 'setRequestTerminated';
export const SET_RESPONSE = 'setResponse';
export const SET_ERROR = 'setError';

export const getMessage = (state, index) => {
    if (state.all[index] !== undefined) {
        return state.all[index];
    } else {
        throw new RangeError(`No message found at [${index}] index`);
    }
};

export default {
    [ADD_MESSAGE] (state, axiosRequestConfig) {
        const message = {
            request: {
                method: axiosRequestConfig.method,
                url: axiosRequestConfig.url
            }
        };
        state.all.push(message);
    },
    [SET_REQUEST_PENDING] (state, index) {
        state.pending.push(index);
    },
    [SET_REQUEST_TERMINATED] (state, index) {
        const i = state.pending.indexOf(index);
        if (i >= 0) {
            state.pending.splice(i, 1);
        }
    },
    [SET_RESPONSE] (state, {index, response}) {
        const message = getMessage(state, index);
        response = {
            status: response.status,
            statusText: response.statusText
        };
        Vue.set(message, 'response', response);
    },
    [SET_ERROR] (state, {index, error}) {
        const message = getMessage(state, index);
        Vue.set(message, 'error', error);
    }
};
