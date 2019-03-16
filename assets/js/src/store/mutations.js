export const SET_BING_API_KEY = 'setBingApiKey';

export default {
    [SET_BING_API_KEY](state, key) {
        state.bingApiKey = key;
    },
};
