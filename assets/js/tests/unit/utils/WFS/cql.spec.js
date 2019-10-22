import {getFilterString} from '@/utils/WFS/cql';
import {and, not, like, equalTo, or, bbox} from 'ol/format/filter';

describe('getFilterString', () => {
    it('And', () => {
        const equalTo1 = equalTo('propertyName', 'value');
        const like1 = equalTo('propertyName', 'value');
        const filter = and(equalTo1, like1);
        expect(getFilterString(filter)).toEqual('propertyName = \'value\' AND propertyName = \'value\'');
    });
    it('Not', () => {
        const equalTo1 = equalTo('propertyName', 'value');
        const filter = not(equalTo1);
        expect(getFilterString(filter)).toEqual('NOT (propertyName = \'value\')');
    });
    it('EqualTo', () => {
        const filter = equalTo('propertyName', 'value');
        expect(getFilterString(filter)).toEqual('propertyName = \'value\'');
    });
    it('EqualTo escapes \'', () => {
        const filter = equalTo('propertyName', 'Rifa\'i');
        expect(getFilterString(filter)).toEqual('propertyName = \'Rifa\'\'i\'');
    });
    it('PropertyIsLike (sensitive)', () => {
        const filter = like('propertyName', 'value', null, null, null, true);
        expect(getFilterString(filter)).toEqual('propertyName LIKE \'value\'');
    });
    it('PropertyIsLike (case insensitive)', () => {
        const filter = like('propertyName', 'value', null, null, null, false);
        expect(getFilterString(filter)).toEqual('propertyName ILIKE \'value\'');
    });
    it('PropertyIsLike escapes \'', () => {
        const filter = like('propertyName', 'Rifa\'i', null, null, null, false);
        expect(getFilterString(filter)).toEqual('propertyName ILIKE \'Rifa\'\'i\'');
    });
    it('Or', () => {
        const equalTo1 = equalTo('propertyName', 'value');
        const like1 = equalTo('propertyName', 'value');
        const filter = or(equalTo1, like1);
        expect(getFilterString(filter)).toEqual('propertyName = \'value\' OR propertyName = \'value\'');
    });
    it('Bbox', () => {
        const filter = bbox('geomName', [-90,40,-60,50]);
        expect(getFilterString(filter)).toEqual('BBOX(geomName,-90,40,-60,50,\'EPSG:4326\')');
    });
});
