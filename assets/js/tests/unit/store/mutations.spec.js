import {clone} from 'lodash';
import mutations, * as consts from '../../../src/store/mutations';
import {state as baseState} from '../../../src/store/index';

describe('[root] store mutations', () => {
    let state = clone(baseState);
    describe(`${consts.SET_BING_API_KEY}`, () => {
        it('set the Bing Api key', () => {
            const key = 'BNmX-AZmebC6VynDqjx6hX5fpMn';
            mutations[consts.SET_BING_API_KEY](state, key);
            expect(state.bingApiKey).toEqual(key);
        });
    });

    describe(`${consts.SET_XSRF_TOKEN}`, () => {
        it('set the XSRF token', () => {
            const key = 'BNmX-AZmettyC6VynDqjx6hX5fpMn';
            mutations[consts.SET_XSRF_TOKEN](state, key);
            expect(state.xsrfToken).toEqual(key);
        });
    });
});
