import {clone} from 'lodash';
import getters, * as consts from '../../../../src/store/query/getters';
import {state as baseState} from '../../../../src/store/query/index';

describe('store/query getters', () => {
    let state = clone(baseState);
    describe(`${consts.GET_PAGINATION}`, () => {
        it('set pagination', () => {
            const pagination = {value: 'some pagination'};
            state['vw-site'].pagination = pagination;
            expect(getters[consts.GET_PAGINATION](state)('vw-site')).toEqual(pagination);
        });
    });
    describe(`${consts.GET_CONDITIONS}`, () => {
        it('set conditions', () => {
            const conditions = {value: 'some value'};
            state['vw-site'].conditions = conditions;
            expect(getters[consts.GET_CONDITIONS](state)('vw-site')).toEqual(conditions);
        });
    });
})
