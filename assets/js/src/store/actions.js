import {SET_BING_API_KEY} from './mutations';
import {SET_BASE_URL} from './geoserver/mutations';
import {SET_GUEST_TOKEN} from './geoserver/auth/mutations';

export const SET_ENV_DATA = 'setEnvData';

export default {
    [SET_ENV_DATA]({commit}, {bingApiKey, geoServer}) {
        commit(SET_BING_API_KEY, bingApiKey);
        commit(`geoserver/${SET_BASE_URL}`, geoServer.baseUrl);
        commit(`geoserver/auth/${SET_GUEST_TOKEN}`, {auth: geoServer.guestAuth});
    },
};
