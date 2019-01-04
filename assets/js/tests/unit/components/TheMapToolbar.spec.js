import TheMapToolbar from '../../../src/components/TheMapToolbar';
import {dataTestSelector} from '../../../src/utils/http';
import {getWrapper, catchLocalVueDuplicateVueBug, resetConsoleError} from './utils';
import {
    STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP,
    CID_THE_MAP_LAYERS_DRAWER,
    CID_THE_MAP_PROPERTIES_DRAWER,
    DT_THE_MAP_TOOLBAR_LEFT_SIDE_ICON,
    DT_THE_MAP_TOOLBAR_PROPERTIES_BUTTON
} from '../../../src/utils/constants';
import {getNamespacedStoreFunc} from '../mixins/utils';

beforeAll(() => {
    catchLocalVueDuplicateVueBug();
});

afterAll(() => {
    resetConsoleError();
});

describe('TheMapToolbar', () => {
    describe('interaction', () => {
        it(`<${DT_THE_MAP_TOOLBAR_LEFT_SIDE_ICON}> @click toggle "${CID_THE_MAP_LAYERS_DRAWER}"."visible" prop`, () => {
            const wrapper = getWrapper('mount', TheMapToolbar, {});
            wrapper.find(dataTestSelector(DT_THE_MAP_TOOLBAR_LEFT_SIDE_ICON)).trigger('click');
            expect(wrapper.vm.$store.commit).toHaveBeenLastCalledWith(
                getNamespacedStoreFunc(STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP),
                {
                    cid: CID_THE_MAP_LAYERS_DRAWER,
                    prop: 'visible',
                },
                undefined
            );
        });
        it(`<${DT_THE_MAP_TOOLBAR_PROPERTIES_BUTTON}> @click toggle "${CID_THE_MAP_PROPERTIES_DRAWER}"."visible" prop`, () => {
            const wrapper = getWrapper('mount', TheMapToolbar, {});
            wrapper.find(dataTestSelector(DT_THE_MAP_TOOLBAR_PROPERTIES_BUTTON)).trigger('click');
            expect(wrapper.vm.$store.commit).toHaveBeenLastCalledWith(
                getNamespacedStoreFunc(STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP),
                {
                    cid: CID_THE_MAP_PROPERTIES_DRAWER,
                    prop: 'visible',
                },
                undefined
            );
        });
    });
});
