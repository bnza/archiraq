import {clone} from 'lodash';
import * as mutations from '@/store/vocabulary/mutations';
import {REQUEST} from '@/store/client/actions';
import actions, * as consts from '@/store/vocabulary/actions';
import {state as baseState} from '@/store/vocabulary/index';

const resolved = {data: ['value1', 'value2']};
let commit;
let dispatch;
let state;

beforeEach(() => {
    commit = jest.fn();
    dispatch = jest.fn().mockResolvedValue(resolved);
    state = clone(baseState);
});

describe('store/vocabulary actions', () => {
    describe(`${consts.FETCH_CHRONOLOGIES}`, () => {
        it(`dispatch "client/${REQUEST}"`, () => {
            actions[consts.FETCH_CHRONOLOGIES]({commit, dispatch, state});
            expect(dispatch).toHaveBeenCalledWith(
                `client/${REQUEST}`,
                {'method': 'get', 'url': '/data/voc-chronology/names'},
                {'root': true}
            );
        });
        it(`commit "${mutations.SET_CHRONOLOGIES}"`, done => {
            actions[consts.FETCH_CHRONOLOGIES]({commit, dispatch, state}).then(() => {
                expect(commit).toHaveBeenCalledWith(
                    `${mutations.SET_CHRONOLOGIES}`,
                    resolved.data
                );
                done();
            });
        });
    });
    describe(`${consts.FETCH_DISTRICTS}`, () => {
        it(`dispatch "client/${REQUEST}"`, () => {
            actions[consts.FETCH_DISTRICTS]({commit, dispatch, state});
            expect(dispatch).toHaveBeenCalledWith(
                `client/${REQUEST}`,
                {'method': 'get', 'url': '/data/geom-district/names'},
                {'root': true}
            );
        });
        it(`commit "${mutations.SET_DISTRICTS}"`, done => {
            actions[consts.FETCH_DISTRICTS]({commit, dispatch, state}).then(() => {
                expect(commit).toHaveBeenCalledWith(
                    `${mutations.SET_DISTRICTS}`,
                    resolved.data
                );
                done();
            });
        });
    });
});
