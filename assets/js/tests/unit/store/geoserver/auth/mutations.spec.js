import {state} from '../../../../../src/store/geoserver/auth';
import mutations, {MUTATIONS} from '../../../../../src/store/geoserver/auth/mutations';

describe('geoserver mutations', () => {
    describe(MUTATIONS.SET_GUEST_TOKEN, () => {
        it('Success', () => {
            mutations[MUTATIONS.SET_GUEST_TOKEN](state, {auth: 'authToken'});
            expect(state.guestToken).toHaveProperty('auth', 'authToken');
        });

    });
});