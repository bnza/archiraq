import VwSiteReadDataCardToolbar from '@/components/DataCard/VwSiteReadDataCardToolbar';
import {
    getVuetifyWrapper,
    catchLocalVueDuplicateVueBug,
    resetConsoleError,
} from '../../components/utils';

let wrapper;
let mountOptions;

beforeAll(() => {
    catchLocalVueDuplicateVueBug();
});

afterAll(() => {
    resetConsoleError();
});

const getMountOptions = () => {
    return {
        propsData: {
            layerId: 'the-layer-id'
        },
    };
};

describe('VwSiteReadDataCardToolbar', () => {
    describe('child events', () => {
        it('zoomToLayer', () => {
            mountOptions = getMountOptions();
            wrapper = getVuetifyWrapper(
                'shallowMount',
                VwSiteReadDataCardToolbar,
                mountOptions
            );
            wrapper.find('[data-test="action-menu"]').vm.$emit('edit');
            expect(wrapper.emitted().edit).toBeTruthy();
        });
    });
});
