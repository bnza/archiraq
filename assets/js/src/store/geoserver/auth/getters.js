export const GET_GUEST_AUTH = 'getGuestAuth';
export const GET_USER_TOKEN = 'getUserToken';

export default {
    [GET_GUEST_AUTH]: (state) => {
        return state.guestToken.auth;
    },
    [GET_USER_TOKEN]: (state) => {
        return state.token;
    }
};
