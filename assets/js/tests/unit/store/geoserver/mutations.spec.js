import {state} from '../../../../src/store/geoserver';
import {STORE_M_GS_M_BASE_URL} from '../../../../src/utils/constants';
import mutations from '../../../../src/store/geoserver/mutations';

describe('geoserver mutations', () => {
    describe(STORE_M_GS_M_BASE_URL, () => {
        it('Success', () => {
            mutations[STORE_M_GS_M_BASE_URL](state, 'geoserver_base_url');
            expect(state).toHaveProperty('baseUrl', 'geoserver_base_url');
        });
    });
});
