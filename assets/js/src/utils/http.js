import {merge} from 'lodash';
import {isBase64} from './assert';

export var getUserNameFromAuth = (auth) => {
    auth = isBase64(auth) ? atob(auth) : auth;
    return auth.split(':').shift();
};

export const headers = {
    setAuthorizationBasic: (auth, headers = {}) => {
        auth = isBase64(auth) ? auth : btoa(auth);
        return merge(
            headers,
            {
                'Authorization': 'Basic ' + auth
            }
        );
    },
    setAccept: (types, headers = {}) => {
        if (Array.isArray(types)) {
            types = types.join(', ');
        }
        return merge(
            headers,
            {
                'Accept': types
            }
        );
    }
};