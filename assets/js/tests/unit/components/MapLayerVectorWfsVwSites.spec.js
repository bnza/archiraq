import MapLayerVectorWfsVwSites from '@/components/MapLayerVectorWfsVwSites';
import {getWrapper, resetLocaVue} from '../components/utils';
import VueLayers from 'vuelayers';

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
            featureColor: 'white',
            zoom: 6,
            baseTypename: 'some_wfs_site',
            baseTypenamePrefix: 'pfx'
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
            },
            refresh: {
                get() {
                    return () => false;
                },
                set() {}
            },
        },
        plugins: [
            VueLayers
        ]
    };
    resetLocaVue();
});

describe('MapLayerVectorWfsVwSites', () => {
    describe('computed', () => {
        it('"typename" change to "archiraq:vw_site_polys" when > 10', () => {
            const wrapper = getWrapper('shallowMount', MapLayerVectorWfsVwSites, mountOptions);
            expect(wrapper.vm.typename).toEqual('pfx:some_wfs_site_point');
            wrapper.setProps({ zoom: 11 });
            expect(wrapper.vm.typename).toEqual('pfx:some_wfs_site_poly');
        });
    });
});
