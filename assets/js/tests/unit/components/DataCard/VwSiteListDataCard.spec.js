import VwSiteListDataCard from '@/components/DataCard/VwSiteListDataCard';
import {SITE_POLY_WFS_TYPENAME} from '@/components/MapLayerVectorWfsVwSites';

describe('VwSiteListDataCard', () => {
    describe('computed', () => {
        it('set "modalComponent" property', () => {
            VwSiteListDataCard.computed.limitTypeName.apply({});
            expect(VwSiteListDataCard.computed.limitTypeName.apply({})).toEqual(SITE_POLY_WFS_TYPENAME);
        });
    });
});
