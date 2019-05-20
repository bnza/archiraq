/* global global */
import {getMapPixelHeight, arrayHasIndex} from '../../../src/utils/utils';

describe('"getMapPixelHeight"', () => {
    it('returns default value if "isFullScreen" flag is false', () => {
        expect(getMapPixelHeight(false)).toEqual('500px');
    });
    it('returns computed value if "isFullScreen" flag is true', () => {
        global.innerHeight = 800;
        expect(getMapPixelHeight(true)).toEqual('700px');
    });

});

describe('"arrayHasIndex"', () => {
    it('returns "true" when array has given integer index', () => {
        expect(arrayHasIndex([false, 9], 0)).toEqual(true);
    });
    it('returns "false" when array hasn\'t given integer index', () => {
        expect(arrayHasIndex([false, 9], 4)).toEqual(false);
    });
    it('returns "true" when array has given array indexes', () => {
        expect(arrayHasIndex([false, 9], [0,1])).toEqual(true);
    });
    it('returns "false" when array hasn\'t given array indexes', () => {
        expect(arrayHasIndex([false, 9], [1,7])).toEqual(false);
    });
});
