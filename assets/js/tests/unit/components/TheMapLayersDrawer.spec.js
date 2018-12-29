import TheMapLayersDrawer from '../../../src/components/TheMapLayersDrawer';
import {getWrapper, catchLocalVueDuplicateVueBug, resetConsoleError} from './utils';
import {getNamespacedStoreFunc, moduleFuncs} from '../mixins/utils';

beforeAll(() => {
    catchLocalVueDuplicateVueBug();
});

afterAll(() => {
    resetConsoleError();
});

describe('TheMapLayersDrawer', () => {
    describe('computed', () => {
        it('visible', () => {
            const wrapper = getWrapper('shallowMount', TheMapLayersDrawer, {});
            wrapper.vm.visible = true;
            expect(wrapper.vm.$store.commit).toHaveBeenLastCalledWith(
                getNamespacedStoreFunc(moduleFuncs.MUTATIONS.PROP.SET),
                {cid: 'the-map-layers-drawer', prop: 'visible', value: true},
                undefined
            );
            /*
            expect(wrapper.vm[moduleFuncs.GETTERS.PROP.GET]).toHaveBeenCalledWith(
                'the-map-layer-drawer',
                'visible'
            );
            */
        });
    });
});