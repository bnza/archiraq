import TheMainToolbar from '../../../src/components/TheMainToolbar';
import {CID_THE_MAIN_NAVIGATION_DRAWER} from '../../../src/utils/cids';
import {getVuetifyWrapper, catchLocalVueDuplicateVueBug, resetConsoleError, $storeMountOptions} from '../components/utils';
import {getNamespacedStoreProp} from '../utils';
import {TOGGLE_COMPONENT_PROP} from '../../../src/store/components/mutations';

beforeAll(() => {
    catchLocalVueDuplicateVueBug();
});

afterAll(() => {
    resetConsoleError();
});

describe('TheMainToolbar', () => {
    describe('interaction', () => {
        it('<v-toolbar-side-icon> @click toggle "the-main-navigation-drawer"."visible" prop', () => {
            const wrapper = getVuetifyWrapper('mount', TheMainToolbar, {$store: $storeMountOptions});
            wrapper.find('button.v-toolbar__side-icon').trigger('click');
            expect(wrapper.vm.$store.commit).toBeCalledWith(
                getNamespacedStoreProp('components', TOGGLE_COMPONENT_PROP),
                {
                    cid: CID_THE_MAIN_NAVIGATION_DRAWER,
                    prop: 'visible',
                }
            );
        });
    });
});
