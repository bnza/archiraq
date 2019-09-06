import {getConditionsWfsFilters, getWfsFilter, getNullableWfsFilter, wildcardWrap} from '@/utils/WFS/filter';
import {or, and, like, equalTo} from 'ol/format/filter';
import Filter from 'ol/format/filter/Filter';

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
    it('stringContainsFilter', () => {
        const attribute = 'propertyName';
        const expression = 'propertyValue';
        const filter = like(attribute, wildcardWrap(expression), '%', null, null, false);
        expect(getWfsFilter('stringContainsFilter', [attribute, expression])).toEqual(filter);
    });
    describe('multipleEqualToFilter', () => {
        it('with single value', () => {
            const attribute = 'propertyName';
            const expression = ['propertyValue'];
            const filter = equalTo(attribute, expression[0], true);
            expect(getWfsFilter('multipleEqualToFilter', [attribute, expression])).toEqual(filter);
        });
        it('with multiple values', () => {
            const attribute = 'propertyName';
            const expression = ['propertyValue1', 'propertyValue2'];
            const filter1 = equalTo(attribute, expression[0], true);
            const filter2 = equalTo(attribute, expression[1], true);
            const filter = or(filter1,filter2);
            expect(getWfsFilter('multipleEqualToFilter', [attribute, expression])).toEqual(filter);
        });
    });
    describe('multipleIsInsensitiveLikeFilter', () => {
        const _likeFilter = (attribute, expression) => {
            return like(attribute, wildcardWrap(expression), '%', null, null, false);
        };
        it('with single value', () => {
            const attribute = 'propertyName';
            const expression = ['propertyValue'];
            const filter = _likeFilter(attribute, expression[0]);
            expect(getWfsFilter('multipleIsInsensitiveLikeFilter', [attribute, expression])).toEqual(filter);
        });
        it('with multiple values', () => {
            const attribute = 'propertyName';
            const expression = ['propertyValue1', 'propertyValue2'];
            const filter1 = _likeFilter(attribute, expression[0]);
            const filter2 = _likeFilter(attribute, expression[1]);
            const filter = or(filter1,filter2);
            expect(getWfsFilter('multipleIsInsensitiveLikeFilter', [attribute, expression])).toEqual(filter);
        });
    });
});

describe('getNullableWfsFilter', () => {
    it('CQLCondition without "operator" will return null', () => {
        expect(getNullableWfsFilter({})).toBeNull();
    });
    it('Invalid CQLCondition will return null', () => {
        expect(getNullableWfsFilter({
            operator: 'EqualToFilter',
            expressions: ['anAttribute']
        })).toBeNull();
    });
    it('Valid CQLCondition will return ol/format/Filter', () => {
        expect(getNullableWfsFilter({
            operator: 'EqualToFilter',
            expressions: ['anAttribute', 'aValue']
        })).toBeInstanceOf(Filter);
    });
});

describe('getConditionsWfsFilters', () => {
    it('Invalid CQLConditions will be filtered out', () => {
        const conditions = [
            {},
            {
                operator: 'EqualToFilter',
                expressions: ['anAttribute']
            },
            {
                operator: 'EqualToFilter',
                expressions: ['anAttribute', 'aValue']
            }
        ];
        expect(getConditionsWfsFilters(conditions)).toHaveLength(1);
    });
});
