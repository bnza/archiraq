export const SET_GUEST_TOKEN_AUTH = 'setGetToken';
export const SET_USER_TOKEN = 'setUserToken';

export default {
    [SET_GUEST_TOKEN_AUTH](state, {auth}) {
        state.guestToken.auth = auth;
    },
    [SET_USER_TOKEN](state, token) {
        state.token = token;
    },
};
