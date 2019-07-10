import cloneDeep from 'lodash/cloneDeep';

import {state as geoserverAuthState} from '@/store/geoserver/auth/index';

import {
    ROLE_GUEST,
    ROLE_USER,
    ROLE_EDITOR,
    ROLE_ADMIN
} from '@/store/auth';

import getters, {
    GET_USERNAME,
    GET_USER_TOKEN,
    GET_USER_ROLES,
    IS_AUTHENTICATED,
    HAS_ROLE
} from '@/store/auth/getters';

const token = {
    auth: 'dXNlcm5hbWUxOnBhc3N3b3JkMQ==',
    roles: ['ROLE_USER']
};

const geoserverAuthGetterName = `geoserver/auth/${GET_USER_TOKEN}`;
const geoserverAuthGetterNameMock = jest.fn().mockReturnValue(token);
const rootGetters = {
    [geoserverAuthGetterName]: geoserverAuthGetterNameMock()
};

describe(' store auth getters', () => {
    describe(`${GET_USER_TOKEN}`, () => {
        it('get user token', () => {
            expect(getters[GET_USER_TOKEN]({}, undefined, undefined, rootGetters)).toEqual(token);
            expect(geoserverAuthGetterNameMock).toBeCalledTimes(1);
        });
    });
    describe(`${GET_USERNAME}`, () => {
        const _getters = {
            [GET_USER_TOKEN]: token
        };
        it('get username on geoserver/auth token set', () => {
            expect(getters[GET_USERNAME]({}, _getters, undefined, rootGetters)).toEqual('username1');
        });
    });
    describe(`${GET_USERNAME}`, () => {
        const _getters = {
            [GET_USER_TOKEN]: {}
        };
        it('get username on geoserver/auth token set', () => {
            expect(getters[GET_USERNAME]({}, _getters, undefined, rootGetters)).toEqual('');
        });
    });
    describe(`${IS_AUTHENTICATED}`, () => {
        it('return expected value', () => {
            const rootGetters = {
                [`geoserver/auth/${GET_USER_TOKEN}`]: {}
            };
            expect(getters[IS_AUTHENTICATED]({}, undefined, undefined, rootGetters)).toBe(false);
            rootGetters[`geoserver/auth/${GET_USER_TOKEN}`] = { auth: ''};
            expect(getters[IS_AUTHENTICATED]({}, undefined, undefined, rootGetters)).toBe(true);
        });
    });
    describe(`${GET_USER_ROLES}`, () => {
        it('return expected value', () => {
            const rootState = {
                geoserver: {
                    auth: cloneDeep(geoserverAuthState)
                }
            };
            let _getters = {
                [IS_AUTHENTICATED]: false,
                [GET_USER_TOKEN]: {}
            };
            expect(getters[GET_USER_ROLES]({}, _getters, rootState, rootGetters)).toEqual(['ROLE_GUEST']);
            _getters = {
                [IS_AUTHENTICATED]: true,
                [GET_USER_TOKEN]: {roles: ['SOME_ROLE']}
            };
            expect(getters[GET_USER_ROLES]({}, _getters, undefined, rootGetters)).toEqual(['SOME_ROLE']);
        });
    });
    describe(`${HAS_ROLE}`, () => {
        it('return expected value', () => {
            let _getters = {
                [GET_USER_ROLES]: [ROLE_GUEST, ROLE_EDITOR]
            };

            expect(getters[HAS_ROLE]({}, _getters, undefined, undefined)('WRONG_ROLE')).toBeFalsy();
            expect(getters[HAS_ROLE]({}, _getters, undefined, undefined)(ROLE_GUEST)).toBeTruthy();
            expect(getters[HAS_ROLE]({}, _getters, undefined, undefined)(ROLE_USER)).toBeTruthy();
            expect(getters[HAS_ROLE]({}, _getters, undefined, undefined)(ROLE_EDITOR)).toBeTruthy();
            expect(getters[HAS_ROLE]({}, _getters, undefined, undefined)(ROLE_ADMIN)).toBeFalsy();
        });
    });
});
