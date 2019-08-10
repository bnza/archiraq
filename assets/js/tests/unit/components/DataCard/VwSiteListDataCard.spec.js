import VwSiteListDataCard from '@/components/DataCard/VwSiteListDataCard';
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
        computed: {
            pagination: () => {},
            filter: () => {}
        },
        propsData: {
            queryTypename: 'mock-typename'
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
        beforeEach(() => {
            mountOptions = getMountOptions();
            wrapper = getVuetifyWrapper(
                'shallowMount',
                VwSiteListDataCard,
                mountOptions
            );
        });
        it.each([
            ['filter', {
                'queryTypename': 'mock-typename',
                'typename': 'archiraq:mock_typename_poly'
            }],
            ['export', {
                'queryTypename': 'mock-typename',
                'typename': 'archiraq:mock_typename_poly'
            }],
        ])('when "modalComponentType" is %s then "modalProps" is %o', (modalComponentType, expected) => {
            //expect(VwSiteListDataCard.computed.modalProps.apply({modalComponentType})).toEqual(expected);
            wrapper.setData({ modalComponentType: modalComponentType })
            expect(wrapper.vm.modalProps).toEqual(expected);
        });
    });
});
