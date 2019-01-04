import {
    STORE_M_ROOT_A_ENV_DATA,
    STORE_M_ROOT_M_BING_API_KEY,
    STORE_M_GS_M_BASE_URL,
    STORE_M_GS_AUTH_M_GUEST_TOKEN
} from '../utils/constants';

export default {
    [STORE_M_ROOT_A_ENV_DATA]({commit}, {bingApiKey, geoServer}) {
        commit(STORE_M_ROOT_M_BING_API_KEY, bingApiKey);
        commit(`geoserver/${STORE_M_GS_M_BASE_URL}`, geoServer.baseUrl);
        commit(`geoserver/auth/${STORE_M_GS_AUTH_M_GUEST_TOKEN}`, {auth: geoServer.guestAuth});
    },
};
