export const SET_GUEST_TOKEN = 'setGetToken';

export default {
    [SET_GUEST_TOKEN](state, {auth}) {
        state.guestToken.auth = auth;
    }
};
