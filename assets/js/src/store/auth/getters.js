export const GET_USER_TOKEN = 'getUserToken';
export const GET_USER_ROLES = 'getUserRoles';
export const GET_USERNAME = 'getUsername';
export const IS_AUTHENTICATED = 'isAuthenticated';
export const HAS_ROLE = 'hasRole';

import {ROLES_HIERARCHY} from '@/store/auth/index';

import {getUserNameFromAuth} from '@/utils/http';

const _getUserToken = (rootGetters) => rootGetters[`geoserver/auth/${GET_USER_TOKEN}`];

export const isAuthenticated = (rootGetters) => _getUserToken(rootGetters).hasOwnProperty('auth');

export default {
    [GET_USER_TOKEN]: (state, getters, rootState, rootGetters) => {
        return _getUserToken(rootGetters);
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
    [IS_AUTHENTICATED]: (state, getters, rootState, rootGetters) => {
        return isAuthenticated(rootGetters);
    },
    [GET_USER_ROLES]: (state, getters, rootState) => {
        const token = getters[IS_AUTHENTICATED] ? getters[GET_USER_TOKEN] : rootState.geoserver.auth.guestToken;
        return token.roles;
    },
    [HAS_ROLE]: (state, getters) => (role) => {
        const reqRoleIndex = ROLES_HIERARCHY.indexOf(role);
        // Required role does not exist
        if (reqRoleIndex === -1) {
            return false;
        }
        const userMaxRoleIndex = getters[GET_USER_ROLES].reduce((index, role) => {
            const _currentIndex = ROLES_HIERARCHY.indexOf(role);
            return _currentIndex > index ? _currentIndex : index;
        }, -1);
        return userMaxRoleIndex >= reqRoleIndex;
    },
};
