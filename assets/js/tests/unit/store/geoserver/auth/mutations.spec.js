import {clone} from 'lodash';
import mutations, * as consts from '../../../../../src/store/geoserver/auth/mutations';
import {state as baseState} from '../../../../../src/store/geoserver/auth/index';

describe('store geoserver/auth mutations', () => {
    describe(`${consts.SET_USER_TOKEN}`, () => {
        it('set user token', () => {
            let state = clone(baseState);
            const token = {
                username: 'username'
            };
            mutations[consts.SET_USER_TOKEN](state, token);
            expect(state.token).toEqual(token);
        });
    });
    describe(`${consts.SET_GUEST_TOKEN_AUTH}`, () => {
        it('set user token', () => {
            let state = clone(baseState);
            const auth = 'dXNlcm5hbWU6cGFzc3dvcmQ=';
            mutations[consts.SET_GUEST_TOKEN_AUTH](state, {auth: auth});
            expect(state.guestToken.auth).toEqual(auth);
        });
    });
});
