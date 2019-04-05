export const GET_USER_TOKEN = 'getUserToken';
export const GET_USERNAME = 'getUsername';
export const IS_AUTHENTICATED = 'isAuthenticated';

import {getUserNameFromAuth} from '../../utils/http';

export default {
    [GET_USER_TOKEN]: (state, getters, rootState, rootGetters) => {
        return rootGetters[`geoserver/auth/${GET_USER_TOKEN}`];
    },
    [GET_USERNAME]: (state, getters) => {
        const token = getters[GET_USER_TOKEN];
        return token.auth ? getUserNameFromAuth(token.auth) : '';
    },
    /**
     * @param state
     * @param getters
     * @return {boolean}
     */
    [IS_AUTHENTICATED]: (state, getters) => {
        return !!getters[GET_USERNAME];
    },
};
