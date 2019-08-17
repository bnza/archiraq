import VwSiteActionDataCardToolbarMx from '@/mixins/DataCard/VwSiteActionDataCardToolbarMx';
import {WFS_TYPENAME_VW_SITES_SURVEY, WFS_TYPENAME_VW_SITES_RS} from '@/utils/cids';


describe('VwSiteActionDataCardToolbarMx', () => {
    describe('computed', () => {
        it.each([
            ['some_wfs', 'Sites'],
            [WFS_TYPENAME_VW_SITES_SURVEY, 'Sites (survey)'],
            [WFS_TYPENAME_VW_SITES_RS, 'Sites (remote sensing)']
        ])('when "layerId" is \'%s\' then "title" \'%s\'', (layerId, expected) => {
            expect(VwSiteActionDataCardToolbarMx.computed.title.apply({layerId})).toEqual(expected);
        });
    });
});
