import getters, {GET_USERNAME, GET_USER_TOKEN} from '../../../../src/store/auth/getters';

const token = {
    auth: 'dXNlcm5hbWUxOnBhc3N3b3JkMQ==',
    roles: ['ROLE_USER']
};

const geoserverAuthGetterName = `geoserver/auth/${GET_USER_TOKEN}`;
const rootGetters = {
    [geoserverAuthGetterName]: token
};

describe(' store auth getters', () => {
    describe(`${GET_USER_TOKEN}`, () => {
        it('get user token', () => {
            expect(getters[GET_USER_TOKEN]({}, undefined, undefined, rootGetters)).toEqual(token);
            //expect(rootGetters[geoserverAuthGetterName]).toBeCalledTimes(1);
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
});
