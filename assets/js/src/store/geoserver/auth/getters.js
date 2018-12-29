export const GETTERS = {
    GET_GUEST_AUTH: 'getGuestAuthStoreGetter',
};

export default {
    [GETTERS.GET_GUEST_AUTH]: (state) => {
        return state.guestToken.auth;
    },
};