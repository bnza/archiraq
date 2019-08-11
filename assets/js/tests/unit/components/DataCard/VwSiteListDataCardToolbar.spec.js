import VwSiteListDataCardToolbar from '@/components/DataCard/VwSiteListDataCardToolbar';
import {WFS_TYPENAME_VW_SITES_SURVEY, WFS_TYPENAME_VW_SITES_RS} from '@/utils/cids';
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
    describe('computed', () => {
        it.each([
            ['some_wfs', 'Sites'],
            [WFS_TYPENAME_VW_SITES_SURVEY, 'Sites (survey)'],
            [WFS_TYPENAME_VW_SITES_RS, 'Sites (remote sensing)']
        ])('when "layerId" is \'%s\' then "title" \'%s\'', (layerId, expected) => {
            expect(VwSiteListDataCardToolbar.computed.title.apply({layerId})).toEqual(expected);
        });
    });
});
