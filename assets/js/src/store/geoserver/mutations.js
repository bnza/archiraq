import {STORE_M_GS_M_BASE_URL} from '../../utils/constants';

export default {
    [STORE_M_GS_M_BASE_URL](state, baseUrl) {
        state.baseUrl = baseUrl;
    }
};
