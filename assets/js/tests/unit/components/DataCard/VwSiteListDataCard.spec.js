import VwSiteListDataCard from '@/components/DataCard/VwSiteListDataCard';
import DataCardFilterDialog from '@/components/DataCard/DataCardFilterDialog';
import {SITE_POLY_WFS_TYPENAME} from '@/components/MapLayerVectorWfsVwSites';
import {
    getVuetifyWrapper,
    catchLocalVueDuplicateVueBug,
    resetConsoleError,
} from '../../components/utils';
import {getNamespacedStoreProp} from '../../utils';
import {GET_PAGINATION, GET_FILTER} from '@/store/query/getters';

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
        computed: {
            pagination: () => {},
            filter: () => {}
        },
        propsData: {
            typename: 'mock:typename'
        },
        stubs: {
            DataCardExportDialog: '<div data-test="export" />',
            DataCardFilterDialog: '<div data-test="filter" />',
            DataCardExportDialogSlot: '<div data-test="exportSlot" />',
            DataCardFilterDialogSlot: '<div data-test="filterSlot" />'
        }
    };
};

describe('VwSiteListDataCard', () => {
    describe('components', () => {
        beforeEach(() => {
            mountOptions = getMountOptions();
            wrapper = getVuetifyWrapper(
                'shallowMount',
                VwSiteListDataCard,
                mountOptions
            );
        });
        it.each([
            ['', 0],
            ['filter', 1],
            ['export', 1]
        ])('when "modalComponentType" is \'%s\' then "modalComponent" is rendered', (modalComponentType, expected, done) => {
            wrapper.setData({modalComponentType});
            wrapper.vm.$nextTick(() => {
                expect(wrapper.findAll(`[data-test="${modalComponentType}"]`)).toHaveLength(expected);
                done();
            });
        });
    });
    describe('computed', () => {
        it('"limitTypeName"', () => {
            expect(VwSiteListDataCard.computed.limitTypeName.apply({})).toEqual(SITE_POLY_WFS_TYPENAME);
        });
        it.each([
            ['filter', {}],
            ['export', {
                'queryTypename': 'vw-site',
                'typename': 'archiraq:vw_site_poly'
            }],
        ])('when "modalComponentType" is %s then "modalProps" is %o', (modalComponentType, expected) => {
            expect(VwSiteListDataCard.computed.modalProps.apply({modalComponentType})).toEqual(expected);
        });
    });
});
