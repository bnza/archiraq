import actions, * as consts from '../../../../src/store/auth/actions';
import {SET_USER_TOKEN} from '../../../../src/store/geoserver/auth/mutations';
import {XSRF_REQUEST} from '../../../../src/store/client/actions';

let commit;
let dispatch;

beforeEach(() => {
    // cleaning up the mess left behind the previous test
    commit = jest.fn();
    dispatch = jest.fn();
});

describe('store/auth actions', () => {
    describe(`${consts.LOGIN}`, () => {
        it(`dispatch "client/${XSRF_REQUEST}" action`, async () => {
            const credentials = {
                username: 'username2',
                password: 'password2'
            };
            dispatch.mockResolvedValue({data: {username: 'username2', roles: []}});
            const axiosRequestConfig = {data: 'username=username2&password=password2', method: 'post', url: 'login'};
            await actions[consts.LOGIN]({dispatch, commit}, credentials);
            expect(dispatch).toHaveBeenCalledWith(`client/${XSRF_REQUEST}`, axiosRequestConfig, {root: true});
        });
        it(`commit "geoserver/auth/${SET_USER_TOKEN}" mutation`, async () => {
            const credentials = {
                username: 'username2',
                password: 'password2'
            };
            dispatch.mockResolvedValue({data: {username: 'username2', roles: ['aRole']}});
            await actions[consts.LOGIN]({dispatch, commit}, credentials);
            expect(commit).toHaveBeenCalledWith(`geoserver/auth/${SET_USER_TOKEN}`, {'auth': 'dXNlcm5hbWUyOnBhc3N3b3JkMg==', roles: ['aRole']}, {'root': true});
        });
    });
    describe(`${consts.LOGOUT}`, () => {
        it(`dispatch "client/${XSRF_REQUEST}" action`, async () => {
            dispatch.mockResolvedValue('User logged out');
            const axiosRequestConfig = {method: 'post', url: 'logout'};
            await actions[consts.LOGOUT]({dispatch, commit});
            expect(dispatch).toHaveBeenCalledWith(`client/${XSRF_REQUEST}`, axiosRequestConfig, {root: true});
        });
        it(`commit "geoserver/auth/${SET_USER_TOKEN}" mutation (clean auth)`, async () => {
            dispatch.mockResolvedValue('User logged out');
            await await actions[consts.LOGOUT]({dispatch, commit});
            expect(commit).toHaveBeenCalledWith(`geoserver/auth/${SET_USER_TOKEN}`, {}, {'root': true});
        });
    });
});
