import VwSiteListDataCardToolbar from '@/components/DataCard/VwSiteListDataCardToolbar';
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

describe('VwSiteListDataCardToolbar', () => {
    describe('methods', () => {
        it('zoomToLayer', () => {
            const mapContainerCallMethod = jest.fn();
            mountOptions = getMountOptions();
            mountOptions.methods = {mapContainerCallMethod};
            wrapper = getVuetifyWrapper(
                'shallowMount',
                VwSiteListDataCardToolbar,
                mountOptions
            );
            wrapper.vm.zoomToLayer();
            expect(mapContainerCallMethod).toHaveBeenCalledWith('zoomToLayer','the-layer-id');
        });
    });
});
