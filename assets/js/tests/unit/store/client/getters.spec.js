import {cloneDeep} from 'lodash';
import getters, * as consts from '../../../../src/store/client/getters';
import {state} from '../../../../src/store/client';

let localState;

beforeEach(() => {
    localState = cloneDeep(state);
});

describe('store client getters', () => {
    describe(`${consts.HAS_PENDING_REQUESTS}`, () => {
        it('returns expected value', () => {
            expect(getters[consts.HAS_PENDING_REQUESTS](localState)).toEqual(false);
            localState.pending.push({});
            expect(getters[consts.HAS_PENDING_REQUESTS](localState)).toEqual(true);
        });
    });
    describe(`${consts.PENDING_REQUESTS_NUM}`, () => {
        it('returns expected value', () => {
            expect(getters[consts.PENDING_REQUESTS_NUM](localState)).toEqual(0);
            localState.pending.push({});
            expect(getters[consts.PENDING_REQUESTS_NUM](localState)).toEqual(1);
        });
    });
});
