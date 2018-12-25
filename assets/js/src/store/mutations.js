export const MUTATIONS = {
    SET_BING_API_KEY: 'setBingApiKey'
};

export default {
    [MUTATIONS.SET_BING_API_KEY](state, key) {
        state.bingApiKey = key;
    }
};