import {STORE_M_GS_AUTH_G_GUEST_AUTH} from '../../../utils/constants';

export default {
    [STORE_M_GS_AUTH_G_GUEST_AUTH]: (state) => {
        return state.guestToken.auth;
    },
};
