import {MUTATIONS as ROOT_MUTATIONS} from './mutations';
import {MUTATIONS as GS_MUTATIONS} from './geoserver/mutations';
import {MUTATIONS as GS_AUTH_MUTATIONS} from './geoserver/auth/mutations';

export const ACTIONS = {
    SET_ENV_DATA: 'setEnvDataStoreAction'
};

export default {
    [ACTIONS.SET_ENV_DATA]({commit}, {bingApiKey, geoServer}) {
        commit(ROOT_MUTATIONS.SET_BING_API_KEY, bingApiKey);
        commit(`geoserver/${GS_MUTATIONS.SET_BASE_URL}`, geoServer.baseUrl);
        commit(`geoserver/auth/${GS_AUTH_MUTATIONS.SET_GUEST_TOKEN}`, {auth: geoServer.guestAuth});
    },
};