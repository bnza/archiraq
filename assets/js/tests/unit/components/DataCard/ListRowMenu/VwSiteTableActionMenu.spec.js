import VwSiteTableActionMenu from '@/components/DataCard/ListRowMenu/VwSiteTableActionMenu';
import {getVuetifyWrapper, catchLocalVueDuplicateVueBug, resetConsoleError} from '../../../components/utils';

let mountOptions;
let wrapper;

beforeAll(() => {
    catchLocalVueDuplicateVueBug();
});

afterAll(() => {
    resetConsoleError();
});

beforeEach(() => {
    mountOptions= {
        propsData: {
            visible: true
        },
        computed: {}
    };
});

describe('VwSiteTableActionMenu', () => {
    describe('render', () => {
        it('when user is not authenticated', () => {
            mountOptions.computed.authIsAuthenticated = () => false;
            wrapper = getVuetifyWrapper('shallowMount', VwSiteTableActionMenu, mountOptions);
            expect(wrapper.findAll('v-list-tile-stub')).toHaveLength(2);
        });
        it('when user is authenticated', () => {
            mountOptions.computed.authIsAuthenticated = () => true;
            wrapper = getVuetifyWrapper('shallowMount', VwSiteTableActionMenu, mountOptions);
            expect(wrapper.findAll('v-list-tile-stub')).toHaveLength(3);
        });
    });
});
