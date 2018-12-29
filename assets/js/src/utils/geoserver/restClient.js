const axios = require('axios');
import {map, union} from 'lodash';
import {xml2js} from 'xml-js';
import {isBase64} from '../assert';
import {getUserNameFromAuth, headers as headersUtils} from '../http';

const getSecurityServiceSubPath = (service, securityServices = {}) => {
    let subPath =  `/security/${service.toLowerCase()}/`;
    if (securityServices.hasOwnProperty(service)) {
        subPath += `service/${securityServices[service].toLowerCase()}/`;
    }
    return subPath;
};

const mapGroupsToRoles = (groups) => {
    const roles = [];
    const rolesMap = {
        administrators: 'ROLE_ADMIN',
        editors: 'ROLE_EDITOR',
        users: 'ROLE_USER',
        guests: 'ROLE_GUEST'
    };
    for (let group in rolesMap) {
        if (groups.includes(group)) {
            roles.push(rolesMap[group]);
        }
    }
    return roles;
}

const mapXmlElText = (arr) => {
    if (!Array.isArray(arr)) {
        arr = [arr];
    }
    return map(
        arr,
        el => {
            return el._text;
        });
};


const role2js = (xml) => {
    const js = xml2js(xml, {compact: true});
    return js.roles.role
        ? mapXmlElText(js.roles.role)
        : [];
};

/**
 *
 * @param xml string
 * @returns {Array}
 */
const groups2js = (xml) => {
    const js = xml2js(xml, {compact: true});
    return js.groups.group
        ? mapXmlElText(js.groups.group)
        : [];
};

class restClient {
    constructor(url, {securityServices = {}, auth = ''}={}) {
        /**
         * GeoServer base url
         * @var string
         */
        const path = url.slice(-1) === '/' ? '' : '/' + 'auth/';
        this.baseUrl = url + path;

        this.securityServices = {};
        this.setSecurityServices(securityServices);

        this._auth = isBase64(auth) ? auth : btoa(auth);
    }

    setSecurityServices({userGroup, roles}) {
        if (userGroup) {
            this.securityServices.userGroup = userGroup;
        }
        if (roles) {
            this.securityServices.roles = roles;
        }
    }

    get username() {
        return getUserNameFromAuth(this._auth);
    }

    /**
     *
     * @returns {Promise<boolean>}
     */
    async isServerRunning() {
        const config = {
            url: '/settings/contact',
            method: 'head',
            baseURL: this.baseUrl,
        };
        try {
            let head = await this.request(config);
            return !!head;
        } catch (error) {
            if (error.response) {
                throw new Error(
                    `Server is running but you got: ${error.response.status}: ${error.response.statusText}. Check your server settings`
                );
            } else if (error.request) {
                return false;
            }
            throw error;
        }
    }

    async getUserGroups(user = '') {
        const headers = headersUtils.setAccept(['application/xml', '*/*']);
        user = user || this.username;
        let url = getSecurityServiceSubPath('userGroup', this.securityServices) + `user/${user}/groups`;
        const config = {
            url: url,
            baseURL: this.baseUrl,
            method: 'get',
            headers: headersUtils.setAuthorizationBasic(this._auth, headers)
        };
        const response = await this.request(config);
        return groups2js(response.data);
    }

    async getUserRoles(user = '', mergeGroupsRoles = false) {
        const headers = headersUtils.setAccept(['application/xml', '*/*']);
        user = user || this.username;
        let url = getSecurityServiceSubPath('roles', this.securityServices) + `user/${user}`;

        const config = {
            url: url,
            baseURL: this.baseUrl,
            method: 'get',
            headers: headersUtils.setAuthorizationBasic(this._auth, headers)
        };
        let response = await this.request(config);
        const userRoles = role2js(response.data);
        if (mergeGroupsRoles) {
            const groupsRoles = await this.getUserGroupsRoles(user);
            let a = union(userRoles, groupsRoles);
            return a;
        } else {
            return userRoles;
        }
    }

    async getUserGroupsRoles(user = '') {
        const groups = await this.getUserGroups(user);
        return mapGroupsToRoles(groups);
    }

    async request(config) {
        try {
            return await axios.request(config);
        } catch (error) {
            throw error;
        }
    }

}

export default restClient;