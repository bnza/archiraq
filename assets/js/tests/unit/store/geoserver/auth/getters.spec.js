import getters, * as consts from '../../../../../src/store/geoserver/auth/getters';

const token = {
    auth: 'dXNlcm5hbWUxOnBhc3N3b3JkMQ==',
    roles: ['ROLE_USER']
};

const guestAuth = 'dXNlcm5hbWU6cGFzc3dvcmQ=';

let state = {
    token: token,
    guestToken: {
        roles: ['ROLE_GUEST'],
        auth: guestAuth
    }
};

describe('store geoserver/auth getters', () => {
    describe(`${consts.GET_USER_TOKEN}`, () => {
        it('get user token', () => {
            expect(getters[consts.GET_USER_TOKEN](state)).toEqual(token);
        });
    });
    describe(`${consts.GET_GUEST_AUTH}`, () => {
        it('set user token', () => {
            expect(getters[consts.GET_GUEST_AUTH](state)).toEqual(guestAuth);
        });
    });
});
