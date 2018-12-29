import TheMapToolbar from '../../../src/components/TheMapToolbar';
import {getWrapper, catchLocalVueDuplicateVueBug, resetConsoleError} from './utils';
import {getNamespacedStoreFunc, moduleFuncs} from '../mixins/utils';

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
                getNamespacedStoreFunc(moduleFuncs.MUTATIONS.PROP.TOGGLE),
                {
                    cid: 'the-map-layers-drawer',
                    prop: 'visible',
                },
                undefined
            );
        });
    });
});