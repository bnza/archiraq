import {clone} from 'lodash';
import axios from 'axios';
import {state as baseState} from '../../../../src/store/client/index';
import actions, * as consts from '../../../../src/store/client/actions';
import * as mutations from '../../../../src/store/client/mutations';

let commit;
let dispatch;
let state;
jest.mock('axios');

beforeEach(() => {
    // cleaning up the mess left behind the previous test
    commit = jest.fn();
    dispatch = jest.fn().mockResolvedValue({});
    state = clone(baseState);
    axios.request.mockResolvedValue({});
});

describe('store/messages actions', () => {
    describe(`${consts.REQUEST}`, () => {
        it(`commit "${mutations.ADD_MESSAGE}"`, () => {
            const axiosRequestConfig = {method: 'put', url: 'some/url'};
            actions[consts.REQUEST]({commit, state}, axiosRequestConfig);
            expect(commit).toHaveBeenCalledWith(mutations.ADD_MESSAGE, axiosRequestConfig);
        });

        it(`commit "${mutations.SET_REQUEST_PENDING}"`, async () => {
            const axiosRequestConfig = {method: 'put', url: 'some/url'};
            await actions[consts.REQUEST]({commit, state}, axiosRequestConfig);
            expect(commit).toHaveBeenCalledWith(mutations.SET_REQUEST_PENDING, -1);
        });

        it(`commit "${mutations.SET_RESPONSE}" on success`, async () => {
            const axiosRequestConfig = {method: 'put', url: 'some/url'};
            await actions[consts.REQUEST]({commit, state}, axiosRequestConfig);
            expect(commit).toHaveBeenCalledWith(mutations.SET_RESPONSE, expect.any(Object));
        });

        it(`commit "${mutations.SET_REQUEST_TERMINATED}" on success`, async () => {
            const axiosRequestConfig = {method: 'put', url: 'some/url'};
            await actions[consts.REQUEST]({commit, state}, axiosRequestConfig);
            expect(commit).toHaveBeenCalledWith(mutations.SET_REQUEST_TERMINATED, -1);
        });

        it(`commit "${mutations.SET_REQUEST_TERMINATED}" on error`, async () => {
            const axiosRequestConfig = {method: 'put', url: 'some/url'};
            axios.request.mockRejectedValue(new Error('Some error'));
            await expect(actions[consts.REQUEST]({commit, state}, axiosRequestConfig)).rejects.toThrow();
            expect(commit).toHaveBeenCalledWith(mutations.SET_REQUEST_TERMINATED, -1);
        });

        it(`commit "${mutations.SET_ERROR}" on error`, async () => {
            const axiosRequestConfig = {method: 'put', url: 'some/url'};
            axios.request.mockRejectedValue(new Error('Some error'));
            await expect(actions[consts.REQUEST]({commit, state}, axiosRequestConfig)).rejects.toThrow();
            expect(commit).toHaveBeenCalledWith(mutations.SET_ERROR, {error: 'Some error', index: -1});
        });
    });
    describe(`${consts.XSRF_REQUEST}`, () => {
        it('set "X-XSRF-Token" headers with the relative store value', async () => {
            const rootState = {
                xsrfToken: 'theXsrfToken'
            };
            const axiosRequestConfig = {method: 'post', url: 'some/url'};
            await actions[consts.XSRF_REQUEST]({dispatch, rootState}, axiosRequestConfig);
            expect(axiosRequestConfig).toHaveProperty('headers');
            expect(axiosRequestConfig.headers).toHaveProperty('X-XSRF-Token');
            expect(axiosRequestConfig.headers['X-XSRF-Token']).toEqual(rootState.xsrfToken);
        });
        it(`dispatch "${consts.REQUEST}" action`, async () => {
            const rootState = {
                xsrfToken: 'theXsrfToken'
            };
            const axiosRequestConfig = {method: 'post', url: 'some/url'};
            await actions[consts.XSRF_REQUEST]({dispatch, rootState}, axiosRequestConfig);
            expect(dispatch).toHaveBeenCalledWith(consts.REQUEST, axiosRequestConfig);
        });
    });
});
