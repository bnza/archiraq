import getters, {GET_USERNAME, GET_USER_TOKEN, IS_AUTHENTICATED} from '../../../../src/store/auth/getters';

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
            const _getters = {
                [GET_USERNAME]: ''
            };
            expect(getters[IS_AUTHENTICATED]({}, _getters, undefined, rootGetters)).toBe(false);
            _getters[GET_USERNAME] = 'username';
            expect(getters[IS_AUTHENTICATED]({}, _getters, undefined, rootGetters)).toBe(true);
        });
    });
});
