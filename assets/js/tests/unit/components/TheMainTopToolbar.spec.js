import TheMainTopToolbar from '../../../src/components/TheMainTopToolbar';
import {STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP, CID_THE_MAIN_NAVIGATION_DRAWER} from '../../../src/utils/constants';
import {getWrapper, catchLocalVueDuplicateVueBug, resetConsoleError} from './utils';
import {getNamespacedStoreFunc} from '../mixins/utils';

beforeAll(() => {
    catchLocalVueDuplicateVueBug();
});

afterAll(() => {
    resetConsoleError();
});

describe('TheMainTopToolbar', () => {
    describe('interaction', () => {
        it('<v-toolbar-side-icon> @click toggle "the-main-navigation-drawer"."visible" prop', () => {
            const wrapper = getWrapper('mount', TheMainTopToolbar, {});
            wrapper.find('button.v-toolbar__side-icon').trigger('click');
            expect(wrapper.vm.$store.commit).toHaveBeenLastCalledWith(
                getNamespacedStoreFunc(STORE_M_COMPONENTS_M_TOGGLE_COMPONENT_PROP),
                {
                    cid: CID_THE_MAIN_NAVIGATION_DRAWER,
                    prop: 'visible',
                },
                undefined
            );
        });
    });
});
