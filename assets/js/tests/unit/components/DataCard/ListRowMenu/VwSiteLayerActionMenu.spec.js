import WvSiteLayerActionMenu from '@/components/DataCard/ListRowMenu/WvSiteLayerActionMenu';
import {getVuetifyWrapper, catchLocalVueDuplicateVueBug, resetConsoleError} from '../../../components/utils';

let mountOptions = {
    propsData: {
        typename: 'some_type_name'
    }
};
let wrapper;

beforeAll(() => {
    catchLocalVueDuplicateVueBug();
});

afterAll(() => {
    resetConsoleError();
});

describe('VwSiteTableActionMenu', () => {
    describe('render', () => {
        it('when user is not authenticated', () => {
            wrapper = getVuetifyWrapper('shallowMount', WvSiteLayerActionMenu, mountOptions);
            wrapper.vm.openAttributeTable = jest.fn();
            wrapper.find('[data-test="openAttributeTable"]').vm.$emit('click');
            expect(wrapper.vm.openAttributeTable).toHaveBeenCalledWith({table: 'some-type-name'});
        });
    });
});
