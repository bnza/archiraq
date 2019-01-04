import TheMapToolbar from '../../../src/components/TheMapToolbar';
import {getWrapper, catchLocalVueDuplicateVueBug, resetConsoleError} from './utils';
import {STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP, CID_THE_MAP_LAYERS_DRAWER} from '../../../src/utils/constants';
import {getNamespacedStoreFunc} from '../mixins/utils';

beforeAll(() => {
    catchLocalVueDuplicateVueBug();
});

afterAll(() => {
    resetConsoleError();
});

describe('TheMapToolbar', () => {
    describe('interaction', () => {
        it('<v-toolbar-side-icon> @click toggle "the-map-layers-drawer"."visible" prop', () => {
            const wrapper = getWrapper('mount', TheMapToolbar, {});
            wrapper.find('button.v-toolbar__side-icon').trigger('click');
            expect(wrapper.vm.$store.commit).toHaveBeenLastCalledWith(
                getNamespacedStoreFunc(STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP),
                {
                    cid: CID_THE_MAP_LAYERS_DRAWER,
                    prop: 'visible',
                },
                undefined
            );
        });
    });
});
