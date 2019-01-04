/*export const MUTATIONS = {
    SET_BING_API_KEY: 'setBingApiKeyStoreMutation'
};*/

import {STORE_M_ROOT_M_BING_API_KEY} from '../utils/constants';

export default {
    [STORE_M_ROOT_M_BING_API_KEY](state, key) {
        state.bingApiKey = key;
    },
};
