import {state} from '../../../../src/store/geoserver';
import mutations, {MUTATIONS} from '../../../../src/store/geoserver/mutations';

describe('geoserver mutations', () => {
    describe(MUTATIONS.SET_BASE_URL, () => {
        it('Success', () => {
            mutations[MUTATIONS.SET_BASE_URL](state, 'geoserver_base_url');
            expect(state).toHaveProperty('baseUrl', 'geoserver_base_url');
        });
    });
});