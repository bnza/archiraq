import {merge} from 'lodash';

export const isBase64 = (str) => {
    try {
        atob(str);
        return true;
    } catch (e) {
        return false;
    }
};

export var getUserNameFromAuth = (auth) => {
    if (!auth) {
        return '';
    }
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
    },
    setXsrfToken: (token, headers = {}) => {
        return merge(
            headers,
            {
                'X-XSRF-Token': token
            }
        );
    },
    setContentType: (type, headers = {}) => {
        return merge(
            headers,
            {
                'Content-Type': type
            }
        );
    }
};
