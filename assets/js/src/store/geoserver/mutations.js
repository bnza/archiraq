export const SET_BASE_URL = 'setBaseUrl';

export default {
    [SET_BASE_URL](state, baseUrl) {
        state.baseUrl = baseUrl;
    }
};
