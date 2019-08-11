import TheMapLayersDrawer from '@/components/TheMapLayersDrawer';
import {
    CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_0,
    CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_1,
    CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2,
    WFS_TYPENAME_VW_SITES_RS,
    WFS_TYPENAME_VW_SITES_SURVEY
} from '@/utils/cids';

describe('TheMapLayersDrawer', () => {
    describe('computed', () => {
        it.each([
            ['CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_0', CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_0],
            ['CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_1', CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_1],
            ['CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2', CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2],
            ['WFS_TYPENAME_VW_SITES_RS', WFS_TYPENAME_VW_SITES_RS],
            ['WFS_TYPENAME_VW_SITES_SURVEY', WFS_TYPENAME_VW_SITES_SURVEY],
        ])('"%s" returns \'%s\'', (key, value) => {
            expect(TheMapLayersDrawer.computed[key].apply()).toEqual(value);
        });
    });
});
