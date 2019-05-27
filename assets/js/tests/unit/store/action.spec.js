import {clone} from 'lodash';
import * as mutations from '@/store/mutations';
import {SET_BASE_URL} from '@/store/geoserver/mutations';
import {FETCH_DISTRICTS, FETCH_CHRONOLOGIES} from '@/store/vocabulary/actions';
import actions, * as consts from '@/store/actions';
import {state as baseState} from '@/store/index';

let commit;
let dispatch;
let state;

beforeEach(() => {
    commit = jest.fn();
    dispatch = jest.fn();
    state = clone(baseState);
});

describe('[root] store actions', () => {
    const envData = {
        xsrfToken: 'XSRF-TOKEN_VALUE',
        bingApiKey: 'BING-API-KEY_VALUE',
        geoServer: {
            baseUrl: 'http://base/url',
            guestAuth: 'base64GuestAuth'
        }
    };
    describe(`${consts.SET_ENV_DATA}`, () => {
        it(`commit "${mutations.SET_XSRF_TOKEN}"`, () => {
            actions[consts.SET_ENV_DATA]({commit, dispatch, state}, envData);
            expect(commit).toHaveBeenCalledWith(mutations.SET_XSRF_TOKEN, envData.xsrfToken);
        });
        it(`commit "${mutations.SET_BING_API_KEY}"`, () => {
            actions[consts.SET_ENV_DATA]({commit, dispatch, state}, envData);
            expect(commit).toHaveBeenCalledWith(mutations.SET_BING_API_KEY, envData.bingApiKey);
        });
        it(`commit "geoserver/${SET_BASE_URL}"`, () => {
            actions[consts.SET_ENV_DATA]({commit, dispatch, state}, envData);
            expect(commit).toHaveBeenCalledWith(`geoserver/${SET_BASE_URL}`, envData.geoServer.baseUrl);
        });
        it(`dispatch "vocabulary/${FETCH_DISTRICTS}"`, () => {
            actions[consts.SET_ENV_DATA]({commit, dispatch, state}, envData);
            expect(dispatch).toHaveBeenCalledWith(`vocabulary/${FETCH_DISTRICTS}`);
        });
        it(`dispatch "vocabulary/${FETCH_CHRONOLOGIES}"`, () => {
            actions[consts.SET_ENV_DATA]({commit, dispatch, state}, envData);
            expect(dispatch).toHaveBeenCalledWith(`vocabulary/${FETCH_CHRONOLOGIES}`);
        });
    });
});
