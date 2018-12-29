import {isBase64} from '../../../src/utils/assert';

describe('isBase64', () => {
    test.each([
        ['username:password', false],
        ['dXNlcm5hbWU6cGFzc3dvcmQ=', true]
    ])(
        '%s',
        (str, expected) => {
            expect(isBase64(str)).toBe(expected);
        }
    );
});