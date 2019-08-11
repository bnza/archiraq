import VwSiteListRowActionMenu from '@/components/DataCard/ListRowMenu/VwSiteListRowActionMenu';
import {getVuetifyWrapper, catchLocalVueDuplicateVueBug, resetConsoleError} from '../../../components/utils';

let wrapper;

beforeAll(() => {
    catchLocalVueDuplicateVueBug();
});

afterAll(() => {
    resetConsoleError();
});

describe('VwSiteTableActionMenu', () => {
    describe('props', () => {
        it('item default value', () => {
            wrapper = getVuetifyWrapper('shallowMount', VwSiteListRowActionMenu, {});
            expect(wrapper.vm.item).toEqual({});
        });
    });
    describe('props', () => {
        it('item default value', () => {
            const mapContainerCallMethod = jest.fn();
            const goTo = jest.fn();
            const item = { some: 'value'};
            wrapper = getVuetifyWrapper('shallowMount', VwSiteListRowActionMenu, {
                propsData: {
                    item
                },
                methods: {
                    mapContainerCallMethod
                }
            });
            //TODO is $vuetify global?
            const $goTo = wrapper.vm.$vuetify.goTo;
            wrapper.vm.$vuetify.goTo = goTo;
            wrapper.vm.zoomToItemFeature();
            wrapper.vm.$vuetify.goTo = $goTo;
            expect(mapContainerCallMethod).toHaveBeenCalledWith('zoomToItemGeometry', item);
            expect(goTo).toHaveBeenCalledWith('#map');
        });
    });
});
