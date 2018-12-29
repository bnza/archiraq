import {getUserNameFromAuth, headers as headersUtils} from '../../../src/utils/http';

const testPropUnchanged = (actual, expected, skip) => {
    for (let prop in expected) {
        if (!skip.includes(prop)) {
            expect(actual).toHaveProperty(prop)
            expect(actual[prop]).toEqual(expected[prop]);
        }
    }
};

describe('getUsernameFromAuth', () => {
    test.each([
        ['username:password', 'username'],
        ['dXNlcm5hbWU6cGFzc3dvcmQ=', 'username']
    ])(
        '%s',
        (str, expected) => {
            expect(getUserNameFromAuth(str)).toBe(expected);
        }
    );
});

describe('headers', () => {
    describe('setAuthorizationBasic', () => {
        test.each([
            ['username:password', {}, 'Basic dXNlcm5hbWU6cGFzc3dvcmQ='],
            ['username:password', {prop: 'value'}, 'Basic dXNlcm5hbWU6cGFzc3dvcmQ='],
            ['username:password', {'Authorization': 'value'}, 'Basic dXNlcm5hbWU6cGFzc3dvcmQ='],
            ['dXNlcm5hbWU6cGFzc3dvcmQy', {}, 'Basic dXNlcm5hbWU6cGFzc3dvcmQy'],
        ])(
            'set "Authorization" as expected [%# => %s]',
            (str, headers, expected) => {
                const authHeaders = headersUtils.setAuthorizationBasic(str, headers);
                expect(authHeaders).toHaveProperty('Authorization')
                expect(authHeaders['Authorization']).toBe(expected);

            }
        );
        test('Don\'t change other props', () => {
            const headers = {
                prop1: true,
                prop2: {prop3: 'dummy'},
                prop3: 4
            }
            const authHeaders = headersUtils.setAuthorizationBasic('username:password', headers);
            testPropUnchanged(authHeaders, headers, ['Authorization']);
        });
    });
    describe('setAccept', () => {
        test.each([
            ['*/*', {}, '*/*'],
            [['application/xml', '*/*'], {}, 'application/xml, */*'],
            ['*/*', {'Accept': 'value'}, '*/*'],
        ])(
            'set "Accept" as expected [%# => %s]',
            (str, headers, expected) => {
                const reqHeaders = headersUtils.setAccept(str, headers);
                expect(reqHeaders).toHaveProperty('Accept')
                expect(reqHeaders['Accept']).toEqual(expected);

            }
        );
        test('Don\'t change other props', () => {
            const headers = {
                prop1: true,
                prop2: {prop3: 'dummy'},
                prop3: 4
            }
            const authHeaders = headersUtils.setAccept('*/*', headers);
            testPropUnchanged(authHeaders, headers, ['Accept']);
        });
    });
});