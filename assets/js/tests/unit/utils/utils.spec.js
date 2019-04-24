/* global global */
import {getMapPixelHeight} from '../../../src/utils/utils';

describe('"getMapPixelHeight"', () => {
    it('returns default value if "isFullScreen" flag is false', () => {
        expect(getMapPixelHeight(false)).toEqual('500px');
    });
    it('returns computed value if "isFullScreen" flag is true', () => {
        global.innerHeight = 800;
        expect(getMapPixelHeight(true)).toEqual('700px');
    });

});
