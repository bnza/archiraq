import mutations, * as consts from '../../../../src/store/components/mutations';

describe('store/components mutations', () => {
    let mutation;

    describe(consts.CREATE_COMPONENT, () => {
        it('create new component', () => {
            const state = {all: {}};
            mutations[consts.CREATE_COMPONENT](state, {cid: 'dummy'});
            expect(state.all).toHaveProperty('dummy', {});
        });
    });

    describe(consts.TOGGLE_COMPONENT_PROP, () => {

        beforeEach(() => {
            mutation = mutations[consts.TOGGLE_COMPONENT_PROP];
        });

        it('toggle property value', () => {

            const state = {all: {dummy: {drawer: false}}};

            mutation(state, {
                cid: 'dummy',
                prop: 'drawer'
            });

            expect(state.all.dummy.drawer).toBe(true);

            mutation(state, {
                cid: 'dummy',
                prop: 'drawer'
            });

            expect(state.all.dummy.drawer).toBe(false);
        });
    });

    describe(consts.SET_COMPONENT_PROP, () => {

        beforeEach(() => {
            mutation = mutations[consts.SET_COMPONENT_PROP];
        });

        it('Success', () => {
            // mock state
            const state = {all: {dummy: { drawer: 200}}};
            // apply componentStoreMx_mutation
            mutation(state, {
                cid: 'dummy',
                prop: 'drawer',
                value: 100
            });
            // assert result
            expect(state.all.dummy.drawer).toBe(100);
        });
    });
});
