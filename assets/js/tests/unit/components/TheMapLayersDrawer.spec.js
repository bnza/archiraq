import TheMapLayersDrawer from '../../../src/components/TheMapLayersDrawer';
import {
    STORE_M_COMPONENTS_M_COMPONENT_PROP,
    CID_THE_MAP_LAYERS_DRAWER,
    STORE_M_COMPONENTS_G_COMPONENT_PROP
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
            const wrapper = getWrapper('shallowMount', TheMapLayersDrawer, {});
            expect(wrapper.vm[STORE_M_COMPONENTS_G_COMPONENT_PROP]).toHaveBeenCalledWith(
                CID_THE_MAP_LAYERS_DRAWER,
                'visible'
            );
            wrapper.vm.visible = true;
            expect(wrapper.vm.$store.commit).toHaveBeenLastCalledWith(
                getNamespacedStoreFunc(STORE_M_COMPONENTS_M_COMPONENT_PROP),
                {
                    cid: CID_THE_MAP_LAYERS_DRAWER,
                    prop: 'visible',
                    value: true
                },
                undefined
            );
        });
    });
});
