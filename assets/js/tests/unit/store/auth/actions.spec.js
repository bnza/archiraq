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
            dispatch.mockResolvedValue({username: 'username2'});
            const axiosRequestConfig = {data: 'username=username2&password=password2', method: 'post', url: 'login'};
            await actions[consts.LOGIN]({dispatch, commit}, credentials);
            expect(dispatch).toHaveBeenCalledWith(`client/${XSRF_REQUEST}`, axiosRequestConfig, {root: true});
        });
        it(`commit "geoserver/auth/${SET_USER_TOKEN}" mutation`, async () => {
            const credentials = {
                username: 'username2',
                password: 'password2'
            };
            dispatch.mockResolvedValue({username: 'username2'});
            await actions[consts.LOGIN]({dispatch, commit}, credentials);
            expect(commit).toHaveBeenCalledWith(`geoserver/auth/${SET_USER_TOKEN}`, {'auth': 'dXNlcm5hbWUyOnBhc3N3b3JkMg=='}, {'root': true});
        });
    });
});
