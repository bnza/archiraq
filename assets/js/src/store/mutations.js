export const SET_BING_API_KEY = 'setBingApiKey';
export const SET_XSRF_TOKEN = 'setXsrfToken';

export default {
    [SET_BING_API_KEY](state, key) {
        state.bingApiKey = key;
    },
    [SET_XSRF_TOKEN](state, key) {
        state.xsrfToken = key;
    },
};
