import {cloneDeep} from 'lodash';
import mutations, * as consts from '@/store/query/mutations';
import {state as baseState} from '@/store/query/index';
import {defaultPagination} from '@/store/query/index';

describe('store/query mutations', () => {
    let state;

    beforeEach(() => {
        state = cloneDeep(baseState);
    });

    describe(`${consts.SET_PAGINATION}`, () => {
        it('set pagination', () => {
            const payload = {'key': 'pagination', 'typename': 'some-query', 'value': {'value': 'some pagination'}};
            mutations[consts.SET_PAGINATION](state, {typename: payload.typename, pagination: payload.value});
            expect(state).toEqual({
                'some-query': {
                    'pagination': {
                        'value': 'some pagination'
                    }
                }
            });
        });
    });
    describe(`${consts.SET_CONDITIONS}`, () => {
        it('set conditions', () => {
            const payload = {'key': 'conditions', 'typename': 'some-query', 'value': {'value': 'some value'}};
            mutations[consts.SET_CONDITIONS](state, {typename: payload.typename, conditions: payload.value});
            expect(state).toHaveProperty('some-query');
            expect(state['some-query']).toHaveProperty('conditions');
            expect(state['some-query'].conditions).toEqual( payload.value);
        });
    });
    describe(`${consts.SET_FILTER}`, () => {
        it('set filter', () => {
            const payload = {'key': 'filter', 'typename': 'some-query', 'value': {'value': 'some value'}};
            mutations[consts.SET_FILTER](state, {typename: payload.typename, filter: payload.value});
            expect(state).toHaveProperty('some-query');
            expect(state['some-query']).toHaveProperty('filter');
            expect(state['some-query'].filter).toEqual( payload.value);
        });
    });
    describe(`${consts.SET_QUERY}`, () => {
        it('set query when key exists', () => {
            const payload = {'key': 'filter', 'typename': 'some-query', 'value': {'value': 'some value'}};
            state['some-query'] = {};
            mutations[consts.SET_QUERY](state, payload);
            expect(state['some-query']).toEqual({filter: {'value': 'some value'}});
        });
        it('add a new query when key does not exist', () => {
            const payload = {'key': 'filter', 'typename': 'some-query', 'value': {'value': 'some value'}};
            mutations[consts.SET_QUERY](state, payload);
            expect(state).toHaveProperty('some-query');
            expect(state['some-query']).toHaveProperty('filter');
            expect(state['some-query'].filter).toEqual( payload.value);
        });
    });
    describe(`${consts.ADD_QUERY}`, () => {
        it('set filter', () => {
            const payload = {'query': {'filter': {'value': 'some value'}}, 'typename': 'some-query'};
            mutations[consts.ADD_QUERY](state, payload);
            expect(state['some-query']).toEqual({filter: {'value': 'some value'}, pagination: defaultPagination});
        });
    });
});
