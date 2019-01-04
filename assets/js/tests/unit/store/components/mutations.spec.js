import mutations from '../../../../src/store/components/mutations';
import {
    STORE_M_COMPONENTS_M_COMPONENT_PROP,
    STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP,
    STORE_M_COMPONENTS_M_CREATE_COMPONENT
} from '../../../../src/utils/constants';

describe('components mutations', () => {

    let mutation;

    const throwsRange = () => {
        const state = {all: {dummy: {}}};

        function t() {
            mutation(state, {
                cid: 'dummy',
                prop: 'drawer'
            });
        }

        expect(t).toThrowError(RangeError);
    };

    const throwsType = () => {
        const state = {all: {dummy: {drawer: 10}}};

        function t() {
            mutation(state, {
                cid: 'dummy',
                prop: 'drawer'
            });
        }

        expect(t).toThrowError(TypeError);
    };

    describe(STORE_M_COMPONENTS_M_CREATE_COMPONENT, () => {
        it('Success', () => {
            const state = {all: {}};
            mutations[STORE_M_COMPONENTS_M_CREATE_COMPONENT](state, {cid: 'dummy'});
            expect(state.all).toHaveProperty('dummy', {});
        });

    });

    describe(STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP, () => {

        beforeEach(() => {
            mutation = mutations[STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP];
        });

        it('Success', () => {

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

        it('Throws when property does not exist', throwsRange);

        it('Throws when property is not boolean', throwsType);
    });

    describe(STORE_M_COMPONENTS_M_COMPONENT_PROP, () => {

        beforeEach(() => {
            mutation = mutations[STORE_M_COMPONENTS_M_COMPONENT_PROP];
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
