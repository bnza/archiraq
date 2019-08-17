import VwSitePopupDataCard from '@/components/DataCard/Interaction/VwSitePopupDataCard';
import VwSiteSurveyPopupItemDataCard from '@/components/DataCard/Interaction/VwSiteSurveyPopupItemDataCard';
import VwSiteRsPopupItemDataCard from '@/components/DataCard/Interaction/VwSiteRsPopupItemDataCard';
import {
    QUERY_TYPENAME_VW_SITES_RS,
    QUERY_TYPENAME_VW_SITES_SURVEY,
    TITLE_TYPENAME_VW_SITES,
    TITLE_TYPENAME_VW_SITES_RS,
    TITLE_TYPENAME_VW_SITES_SURVEY
} from '@/utils/cids';
import {
    getVuetifyWrapper,
    catchLocalVueDuplicateVueBug,
    resetConsoleError,
    getWrapper
} from '../../../components/utils';

let mountOptions;
let wrapper;

beforeAll(() => {
    catchLocalVueDuplicateVueBug();
});

afterAll(() => {
    resetConsoleError();
});

describe('VwSitePopupDataCard', () => {
    beforeEach(() => {
        mountOptions = {
            propsData: {
                feature: {
                    properties: {}
                }
            }
        };
    });
    describe('computed', () => {
        describe('queryTypename', () => {
            it('"dataItemRoute"', () => {
                mountOptions.propsData.feature.properties.remote_sensing = false;
                mountOptions.propsData.feature.properties.id = 123;
                wrapper = getVuetifyWrapper('shallowMount', VwSitePopupDataCard, mountOptions);
                expect(wrapper.vm.dataItemRoute).toEqual('/map/data/vw-site-survey/123/read#item-form');
            });
            it.each([
                [true, QUERY_TYPENAME_VW_SITES_RS],
                [false, QUERY_TYPENAME_VW_SITES_SURVEY],
            ])('when feature.remote_sensing is %s then is \'%s\'', (isRemoteSensing, expected) => {
                mountOptions.propsData.feature.properties.remote_sensing = isRemoteSensing;
                wrapper = getVuetifyWrapper('shallowMount', VwSitePopupDataCard, mountOptions);
                expect(wrapper.vm.queryTypename).toEqual(expected);
            });
        });
        describe('title', () => {
            it.each([
                [undefined, TITLE_TYPENAME_VW_SITES],
                [true, TITLE_TYPENAME_VW_SITES_RS],
                [false, TITLE_TYPENAME_VW_SITES_SURVEY],
            ])('when feature.remote_sensing is %s then is \'%s\'', (isRemoteSensing, expected) => {
                mountOptions.propsData.feature.properties.remote_sensing = isRemoteSensing;
                wrapper = getVuetifyWrapper('shallowMount', VwSitePopupDataCard, mountOptions);
                expect(wrapper.vm.title).toEqual(expected);
            });
        });
        describe('dataComponent', () => {
            it.each([
                [true, VwSiteRsPopupItemDataCard.name, VwSiteRsPopupItemDataCard],
                [false, VwSiteSurveyPopupItemDataCard.name, VwSiteSurveyPopupItemDataCard],
            ])('when feature.remote_sensing is %s then is \'%s\'', (isRemoteSensing, name, expected) => {
                mountOptions.propsData.feature.properties.remote_sensing = isRemoteSensing;
                wrapper = getVuetifyWrapper('shallowMount', VwSitePopupDataCard, mountOptions);
                expect(wrapper.vm.dataComponent).toEqual(expected);
            });
        });
    });
});
