import getters, * as consts from '@/store/query/getters';

describe('store/query getters', () => {
    let state;
    const values = {
        pagination: {value: 'some pagination'},
        conditions: {value: 'some condition'},
        filter: {value: 'some filter'},
    };

    beforeEach(() => {
        state = {
            'some-query': values
        };
    });
    describe(`${consts.GET_PAGINATION}`, () => {
        it('set pagination', () => {
            expect(getters[consts.GET_PAGINATION](state)('some-query')).toEqual(values.pagination);
        });
    });
    describe(`${consts.GET_CONDITIONS}`, () => {
        it('set conditions', () => {
            expect(getters[consts.GET_CONDITIONS](state)('some-query')).toEqual(values.conditions);
        });
    });
    describe(`${consts.GET_FILTER}`, () => {
        it('set conditions', () => {
            expect(getters[consts.GET_FILTER](state)('some-query')).toEqual(values.filter);
        });
    });
});
