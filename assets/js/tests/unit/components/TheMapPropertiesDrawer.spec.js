import TheMapPropertiesDrawer from '../../../src/components/TheMapPropertiesDrawer';
import {
    STORE_M_COMPONENTS_G_COMPONENT_PROP,
    STORE_M_COMPONENTS_M_COMPONENT_PROP,
    CID_THE_MAP_PROPERTIES_DRAWER
} from '../../../src/utils/constants';
import {getWrapper, catchLocalVueDuplicateVueBug, resetConsoleError} from './utils';
import {getNamespacedStoreFunc} from '../mixins/utils';

beforeAll(() => {
    catchLocalVueDuplicateVueBug();
});

afterAll(() => {
    resetConsoleError();
});

describe('TheMapLayersDrawer', () => {
    describe('computed', () => {
        it('visible get/set', () => {
            const wrapper = getWrapper('shallowMount', TheMapPropertiesDrawer, {});
            expect(wrapper.vm[STORE_M_COMPONENTS_G_COMPONENT_PROP]).toHaveBeenLastCalledWith(
                CID_THE_MAP_PROPERTIES_DRAWER,
                'visible'
            );
            wrapper.vm.visible = true;
            expect(wrapper.vm.$store.commit).toHaveBeenLastCalledWith(
                getNamespacedStoreFunc(STORE_M_COMPONENTS_M_COMPONENT_PROP),
                {
                    cid: CID_THE_MAP_PROPERTIES_DRAWER,
                    prop: 'visible',
                    value: true
                },
                undefined
            );
        });
    });
});
