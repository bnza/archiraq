import MapLayerVectorWfsVwSites, {SITE_POINT_WFS_TYPENAME, SITE_POLY_WFS_TYPENAME} from '../../../src/components/MapLayerVectorWfsVwSites';
import {getWrapper, resetLocaVue} from '../components/utils';

let mountOptions = {};

beforeEach(() => {
    mountOptions = {
        mocks: {
            $store: {
                state: {
                    components: {}
                },
            }
        },
        propsData: {
            zoom: 6
        },
        computed: {
            getQueryFilter() {
                return () => {};
            },
            componentsHasComponent() {
                return () => true;
            },
            visible: {
                get() {
                    return () => true;
                },
                set() {}
            }
        }
    };
    resetLocaVue();
});

describe('MapLayerVectorWfsVwSites', () => {
    describe('computed', () => {
        it('"typename" change to "archiraq:vw_site_polys" when > 10', () => {
            const wrapper = getWrapper('shallowMount', MapLayerVectorWfsVwSites, mountOptions);
            expect(wrapper.vm.typename).toEqual(SITE_POINT_WFS_TYPENAME);
            wrapper.setProps({ zoom: 11 });
            expect(wrapper.vm.typename).toEqual(SITE_POLY_WFS_TYPENAME);
        });
    });
});
