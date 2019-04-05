import {SET_BING_API_KEY, SET_XSRF_TOKEN} from './mutations';
import {SET_BASE_URL} from './geoserver/mutations';
import {SET_GUEST_TOKEN_AUTH, SET_USER_TOKEN} from './geoserver/auth/mutations';

export const SET_ENV_DATA = 'setEnvData';

export default {
    [SET_ENV_DATA]({commit}, {bingApiKey, geoServer, xsrfToken}) {
        commit(SET_XSRF_TOKEN, xsrfToken);
        commit(SET_BING_API_KEY, bingApiKey);
        commit(`geoserver/${SET_BASE_URL}`, geoServer.baseUrl);
        commit(`geoserver/auth/${SET_GUEST_TOKEN_AUTH}`, {auth: geoServer.guestAuth});
        if (geoServer.token) {
            commit(`geoserver/auth/${SET_USER_TOKEN}`, geoServer.token);
        }
    },
};
