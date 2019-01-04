import {STORE_M_GS_AUTH_M_GUEST_TOKEN} from '../../../utils/constants';

export default {
    [STORE_M_GS_AUTH_M_GUEST_TOKEN](state, {auth}) {
        state.guestToken.auth = auth;
    }
};
