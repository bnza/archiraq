import TheMainTopToolbar from '../../src/components/TheMainTopToolbar';
import {getWrapper, catchLocalVueDuplicateVueBug, resetConsoleError} from './utils';
import {getNamespacedStoreFunc, moduleFuncs} from '../mixins/utils';

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
                getNamespacedStoreFunc(moduleFuncs.MUTATIONS.PROP.TOGGLE),
                {
                    cid: 'the-main-navigation-drawer',
                    prop: 'visible',
                },
                undefined
            );
        });
    });
});