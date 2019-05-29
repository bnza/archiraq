jest.mock('@/utils/WFS/cql');
import {getFeatureQueryString} from '@/utils/wfs';
import {getFilterString} from '@/utils/WFS/cql';

const typename = 'geom:typename';
const baseQuery = 'service=WFS&version=1.1.0&request=GetFeature&typename=geom:typename&srsname=EPSG:4326&outputFormat=application/json&exceptions=application/json';


describe('"getFeatureQueryString"', () => {
    it('returns base query string when config has not optional props', () => {
        expect(getFeatureQueryString({typename})).toEqual(baseQuery);
    });
    it('returned qs has "content-disposition" key when "contentDisposition" match \'attachment\'', () => {
        expect(getFeatureQueryString({typename})).not.toMatch(/content-disposition=attachment/)
        expect(getFeatureQueryString({typename, contentDisposition: 'attachment; filename=test.js'})).toMatch(/content-disposition=attachment/);
    });
    it('returns add pagination fragment to query when config has "pagination" prop', () => {
        const pagination = {
            sortBy: 'attributeA',
            descending: true,
            page: 5,
            rowsPerPage: 25
        };
        const fragment = getFeatureQueryString({typename, pagination}).substring(baseQuery.length);
        expect(fragment).toEqual('&maxFeatures=25&startIndex=100&sortBy=attributeA+D');
    });
    it('return add filter query fragment when config has "filter" prop', () => {
        const filter = {};
        const cql_filter = 'modern_name LIKE \'aName\'';
        getFilterString.mockReturnValue(cql_filter);
        const fragment = getFeatureQueryString({typename, filter}).substring(baseQuery.length);
        expect(fragment).toEqual('&cql_filter=modern_name%20LIKE%20\'aName\'');
    });
});
