import {clone} from 'lodash';
import mutations, * as consts from '../../../../src/store/query/mutations';
import {state as baseState} from '../../../../src/store/query/index';

describe('store/query mutations', () => {
    let state = clone(baseState);
    describe(`${consts.SET_PAGINATION}`, () => {
        it('set pagination', () => {
            mutations[consts.SET_PAGINATION](state, {typename: 'vw-site', pagination: {value: 'some pagination'}});
            expect(state['vw-site'].pagination).toEqual({value: 'some pagination'});
        });
    });
    describe(`${consts.SET_CONDITIONS}`, () => {
        it('set conditions', () => {
            const conditions = {value: 'some value'};
            mutations[consts.SET_CONDITIONS](state, {typename: 'vw-site', conditions});
            expect(state['vw-site'].conditions).toEqual(conditions);
        });
    });
})
