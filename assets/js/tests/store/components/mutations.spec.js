/* global describe, it, expect */
import mutations from '../../../src/store/components/mutations';
import {MUTATIONS} from '../../../src/store/components/mutations';

describe('mutations', () => {

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

    describe('MUTATIONS.CREATE', () => {
        it('Success', () => {
            const state = {all: {}};
            mutations[MUTATIONS.CREATE](state, 'dummy');
            expect(state.all).toHaveProperty('dummy', {});
        });

    });

    describe('MUTATIONS.PROP.TOGGLE', () => {

        beforeEach(() => {
            mutation = mutations[MUTATIONS.PROP.TOGGLE];
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

    describe('MUTATIONS.PROP.SET', () => {

        beforeEach(() => {
            mutation = mutations[MUTATIONS.PROP.SET];
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