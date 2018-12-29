export const MUTATIONS = {
    SET_BASE_URL: 'setGuestTokenGeoServerStoreMutation'
};

export default {
    [MUTATIONS.SET_BASE_URL](state, baseUrl) {
        state.baseUrl = baseUrl;
    }
};