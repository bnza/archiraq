import {SET_BING_API_KEY, SET_XSRF_TOKEN} from './mutations';
import {SET_BASE_URL} from './geoserver/mutations';
import {FETCH_DISTRICTS, FETCH_CHRONOLOGIES} from '@/store/vocabulary/actions';
import {SET_GUEST_TOKEN_AUTH} from './geoserver/auth/mutations';

export const SET_ENV_DATA = 'setEnvData';

export default {
    [SET_ENV_DATA]({commit, dispatch}, {bingApiKey, geoServer, xsrfToken}) {
        commit(SET_XSRF_TOKEN, xsrfToken);
        commit(SET_BING_API_KEY, bingApiKey);
        commit(`geoserver/${SET_BASE_URL}`, geoServer.baseUrl);
        commit(`geoserver/auth/${SET_GUEST_TOKEN_AUTH}`, {auth: geoServer.guestAuth});
        dispatch(`vocabulary/${FETCH_DISTRICTS}`);
        dispatch(`vocabulary/${FETCH_CHRONOLOGIES}`);
    },
};
