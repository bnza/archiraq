import VwSiteListDataCardTableRow from '@/components/DataCard/VwSiteListDataCardTableRow';
import {
    QUERY_TYPENAME_VW_SITES_RS,
    QUERY_TYPENAME_VW_SITES_SURVEY,
    HEADERS_VW_SITE_LIST_DATA_CARD_TABLE
} from '@/utils/cids';
import {kebabCase, cloneDeep} from 'lodash';
import {
    getVuetifyWrapper,
    catchLocalVueDuplicateVueBug,
    resetConsoleError,
} from '../../components/utils';

let wrapper;
let mountOptions;

expect.extend({
    toContainsTestElement(wrapper, key) {
        let query = `[data-test="td--${kebabCase(key)}"]`;
        if (wrapper.find(query).exists()) {
            return {
                message: () =>
                    `expected ${query} element not to exists`,
                pass: true,
            };
        } else {
            return {
                message: () =>
                    `expected ${query} element to exists`,
                pass: false,
            };
        }
    },
});

beforeAll(() => {
    catchLocalVueDuplicateVueBug();
});

afterAll(() => {
    resetConsoleError();
});

const item = {
    'id': 207,
    'contribute_id': 38,
    'sbah_no': null,
    'cadastre': null,
    'modern_name': 'Rejibah Shamal',
    'nearest_city': null,
    'ancient_name': 'n',
    'district_id': 73,
    'district': 'Nassriya',
    'governorate': 'Thi-Qar',
    'nation': 'Iraq',
    'chronology': null,
    'surveys': null,
    'survey_refs': '',
    'features': null,
    'threats': 'looting;structures;canals',
    'remote_sensing': true,
    'survey_verified_on_field': false,
    'remarks': 'Ur survey No.93it is recorded also as Ghanmi (Useila)',
    'e': 45.9701175,
    'n': 30.9049294,
    'area': 110.556,
    'length': 1609.88,
    'width': 918.05
};

const getMountOptions = () => {
    return {
        propsData: {
            item: cloneDeep(item)
        }
    };
};

describe('VwSiteListDataCardTableRow', () => {
    beforeEach(() => {
        mountOptions = getMountOptions();
    });
    describe('props', () => {
        it('default headers', () => {
            wrapper = getVuetifyWrapper(
                'shallowMount',
                VwSiteListDataCardTableRow,
                mountOptions
            );
            expect(wrapper.vm.headers).toEqual([]);
        });
    });
    describe('render', () => {
        it.each([
            [
                QUERY_TYPENAME_VW_SITES_SURVEY,
                {
                    'contribute_id': false,
                    'sbah_no': true,
                    'cadastre': true,
                    'modern_name': true,
                    'nearest_city': true,
                    'ancient_name': true,
                    'district_id': false,
                    'district': true,
                    'governorate': true,
                    'nation': true,
                    'chronology': true,
                    'surveys': false,
                    'survey_refs': true,
                    'features': true,
                    'threats': true,
                    'remote_sensing': false,
                    'survey_verified_on_field': false,
                    'remarks': true,
                    'e': true,
                    'n': true,
                    'area': true,
                    'length': true,
                    'width': true
                }
            ],
            [
                QUERY_TYPENAME_VW_SITES_RS,
                {
                    'contribute_id': false,
                    'sbah_no': false,
                    'cadastre': false,
                    'modern_name': true,
                    'nearest_city': false,
                    'ancient_name': true,
                    'district_id': false,
                    'district': true,
                    'governorate': true,
                    'nation': true,
                    'chronology': false,
                    'surveys': false,
                    'survey_refs': false,
                    'features': false,
                    'threats': true,
                    'remote_sensing': false,
                    'survey_verified_on_field': false,
                    'remarks': true,
                    'e': true,
                    'n': true,
                    'area': true,
                    'length': true,
                    'width': true
                }
            ],
        ])('when queryTypename is \'%s\' expected <td> will be rendered', (queryTypename, expectedValues) => {
            mountOptions.propsData.headers = HEADERS_VW_SITE_LIST_DATA_CARD_TABLE[queryTypename];

            wrapper = getVuetifyWrapper(
                'shallowMount',
                VwSiteListDataCardTableRow,
                mountOptions
            );
            for (let key in expectedValues) {
                let _expect = expect(wrapper);
                if (!expectedValues[key]) {
                    _expect.not.toContainsTestElement(key);
                } else {
                    _expect.toContainsTestElement(key);
                }
            }
        });
    });
});
