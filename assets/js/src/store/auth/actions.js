import qs from 'qs';
import {SET_XSRF_TOKEN} from '@/store/mutations';
import {SET_USER_TOKEN} from '../geoserver/auth/mutations';
import {XSRF_REQUEST} from '../client/actions';

export const LOGIN = 'login';
export const LOGOUT = 'logout';
export const REFRESH_SESSION = 'refreshSession';

export default {
    [LOGIN] ({commit, dispatch}, credentials) {
        const axiosRequestConfig = {
            method: 'post',
            url: 'login',
            data: qs.stringify(credentials)
        };

        return dispatch(`client/${XSRF_REQUEST}`, axiosRequestConfig, {root: true}).then((response) => {
            const auth = btoa(`${credentials.username}:${credentials.password}`);
            commit(`geoserver/auth/${SET_USER_TOKEN}`, {auth, roles: response.data.roles}, {root: true});
            return response.data;
        });
    },
    [LOGOUT] ({commit, dispatch}) {
        const axiosRequestConfig = {
            method: 'post',
            url: 'logout',
        };

        return dispatch(`client/${XSRF_REQUEST}`, axiosRequestConfig, {root: true}).then((response) => {
            commit(`geoserver/auth/${SET_USER_TOKEN}`, {}, {root: true});
            commit(SET_XSRF_TOKEN, response.data.xsrfToken, {root: true})
            return response.data;
        });
    },
    [REFRESH_SESSION] ({dispatch, getters}) {
        const doLogin = getters.isAuthenticated;
        return dispatch(LOGOUT).then(
            () => doLogin
        );
    }
};
