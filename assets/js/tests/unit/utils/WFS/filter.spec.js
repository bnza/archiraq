import {getWfsFilter} from '@/utils/WFS/filter';
import {and, like, equalTo} from 'ol/format/filter';

describe('getWfsFilter', () => {
    it('equalToFilter', () => {
        const attribute = 'propertyName';
        const expression = 'propertyValue';
        expect(getWfsFilter('equalToFilter', [attribute, expression])).toEqual(equalTo(attribute, expression, true));
    });
    it('isLikeFilter', () => {
        const attribute = 'propertyName';
        const expression = 'propertyValue';
        const filter = like(attribute, expression, '%', null, null, true);
        expect(getWfsFilter('isLikeFilter', [attribute, expression])).toEqual(filter);
    });
    it('isInsensitiveLikeFilter', () => {
        const attribute = 'propertyName';
        const expression = 'propertyValue';
        const filter = like(attribute, expression, '%', null, null, false);
        expect(getWfsFilter('isInsensitiveLikeFilter', [attribute, expression])).toEqual(filter);
    });
});
