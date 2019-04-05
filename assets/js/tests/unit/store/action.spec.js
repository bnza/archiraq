import {clone} from 'lodash';
import * as mutations from '../../../src/store/mutations';
import {SET_BASE_URL} from '../../../src/store/geoserver/mutations';
import {SET_GUEST_TOKEN_AUTH} from '../../../src/store/geoserver/auth/mutations';
import actions, * as consts from '../../../src/store/actions';
import {state as baseState} from '../../../src/store/index';

let commit;
let state;

beforeEach(() => {
    commit = jest.fn();
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
            actions[consts.SET_ENV_DATA]({commit, state}, envData);
            expect(commit).toHaveBeenCalledWith(mutations.SET_XSRF_TOKEN, envData.xsrfToken);
        });
        it(`commit "${mutations.SET_BING_API_KEY}"`, () => {
            actions[consts.SET_ENV_DATA]({commit, state}, envData);
            expect(commit).toHaveBeenCalledWith(mutations.SET_BING_API_KEY, envData.bingApiKey);
        });
        it(`commit "geoserver/${SET_BASE_URL}"`, () => {
            actions[consts.SET_ENV_DATA]({commit, state}, envData);
            expect(commit).toHaveBeenCalledWith(`geoserver/${SET_BASE_URL}`, envData.geoServer.baseUrl);
        });
        it(`commit "geoserver/auth/${SET_GUEST_TOKEN_AUTH}"`, () => {
            actions[consts.SET_ENV_DATA]({commit, state}, envData);
            expect(commit).toHaveBeenCalledWith(`geoserver/auth/${SET_GUEST_TOKEN_AUTH}`, {auth: envData.geoServer.guestAuth});
        });
    });
});
