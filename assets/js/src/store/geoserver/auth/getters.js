export const GET_GUEST_AUTH = 'getGuestAuth';

export default {
    [GET_GUEST_AUTH]: (state) => {
        return state.guestToken.auth;
    },
};
