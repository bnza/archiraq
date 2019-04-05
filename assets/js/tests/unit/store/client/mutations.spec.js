import {clone} from 'lodash';
import mutations, * as consts from '../../../../src/store/client/mutations';
import {state as baseState} from '../../../../src/store/client/index';

describe('store/messages mutations', () => {
    let state = clone(baseState);
    describe(`${consts.ADD_MESSAGE}`, () => {
        it('add new message', () => {
            mutations[consts.ADD_MESSAGE](state, {method: 'post', url: 'some/url'});
            expect(state.all).toContainEqual({request:{method: 'post', url: 'some/url'}});
        });
    });

    describe(`${consts.SET_RESPONSE}`, () => {
        it('set the message response', () => {
            state.all = [null, null, {}];
            mutations[consts.SET_RESPONSE](state, {index: 2, response: {status: 401, statusText: 'Not found'}});
            expect(state.all[2]).toEqual({response: {status: 401, statusText: 'Not found'}});
        });
    });

    describe(`${consts.SET_ERROR}`, () => {
        it('set the message response', () => {
            state.all = [null, null, null, {}];
            mutations[consts.SET_ERROR](state, {index: 3, error: 'Some error'});
            expect(state.all[3]).toEqual({error: 'Some error'});
        });
    });

    describe(`${consts.SET_REQUEST_PENDING}`, () => {
        it('set the message response', () => {
            mutations[consts.SET_REQUEST_PENDING](state, 3);
            expect(state.pending).toContain(3);
        });
    });

    describe(`${consts.SET_REQUEST_TERMINATED}`, () => {
        it('set the message response', () => {
            mutations[consts.SET_REQUEST_TERMINATED](state, 3);
            expect(state.pending).not.toContain(3);
        });
    });
});
