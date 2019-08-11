import {isBase64, getUserNameFromAuth, headers} from '@/utils/http';

describe('"isBase64"', () => {
    it.each([
        [btoa('test-string'), true],
        ['test-string', false]
    ])('isBase64(%s) return %s' , (str, expected) => {
        expect(isBase64(str)).toEqual(expected);
    });
});

describe('"getUserNameFromAuth"', () => {
    it.each([
        [undefined, ''],
        [btoa('username:password'), 'username'],
        [btoa(':password'), ''],
        [btoa('some-string'), 'some-string'],
        ['username:password', 'username'],
        ['some-string', 'some-string'],
    ])('getUserNameFromAuth(%s) return %s' , (str, expected) => {
        expect(getUserNameFromAuth(str)).toEqual(expected);
    });
});

describe('"headers"', () => {
    it.each([
        ['setAuthorizationBasic', 'user:pwd', 'Authorization', 'Basic dXNlcjpwd2Q='],
        ['setAuthorizationBasic', 'dXNlcjpwd2Q=', 'Authorization', 'Basic dXNlcjpwd2Q='],
        ['setAccept', 'text/plain', 'Accept', 'text/plain'],
        ['setAccept', ['text/plain', 'application/json'], 'Accept', 'text/plain, application/json'],
        ['setXsrfToken', 'theXsrfToken', 'X-XSRF-Token', 'theXsrfToken'],
        ['setContentType', 'text/csv', 'Content-Type', 'text/csv'],
    ])('headers.%s(%s) returned headers has property \'%s\':\'%s\'' , (method, value, prop, expected) => {
        const h = headers[method](value);
        expect(h).toHaveProperty(prop, expected);
    });
});

