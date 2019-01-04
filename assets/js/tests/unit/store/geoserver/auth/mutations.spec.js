import {state} from '../../../../../src/store/geoserver/auth';
import {STORE_M_GS_AUTH_M_GUEST_TOKEN} from '../../../../../src/utils/constants';
import mutations from '../../../../../src/store/geoserver/auth/mutations';

describe('geoserver/auth mutations', () => {
    describe(STORE_M_GS_AUTH_M_GUEST_TOKEN, () => {
        it('Success', () => {
            mutations[STORE_M_GS_AUTH_M_GUEST_TOKEN](state, {auth: 'authToken'});
            expect(state.guestToken).toHaveProperty('auth', 'authToken');
        });
    });
});
