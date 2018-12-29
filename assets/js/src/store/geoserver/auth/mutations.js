export const MUTATIONS = {
    SET_GUEST_TOKEN: 'setGuestTokenAuthStoreMutation'
};

export default {
    [MUTATIONS.SET_GUEST_TOKEN](state, {auth}) {
        state.guestToken.auth = auth;
    }
};