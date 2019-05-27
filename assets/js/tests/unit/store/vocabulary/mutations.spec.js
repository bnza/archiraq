import {clone} from 'lodash';
import mutations, * as consts from '@/store/vocabulary/mutations';
import {state as baseState} from '@/store/vocabulary/index';
let state;

beforeEach(() => {
    state = clone(baseState);
});

describe('store/vocabulary mutations', () => {
    describe(`${consts.SET_DISTRICTS}`, () => {
        it('set districts', () => {
            const districts = ['district1', 'district2'];
            mutations[consts.SET_DISTRICTS](state, districts);
            expect(state.districts).toEqual(districts);
        });
    });
    describe(`${consts.SET_CHRONOLOGIES}`, () => {
        it('set chronologies', () => {
            const chronologies = ['AKK', 'ISL'];
            mutations[consts.SET_CHRONOLOGIES](state, chronologies);
            expect(state.chronologies).toEqual(chronologies);
        });
    });
});
