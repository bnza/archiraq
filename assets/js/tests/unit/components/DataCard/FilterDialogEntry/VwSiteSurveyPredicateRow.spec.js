import clone from 'lodash/clone';
import VwSiteSurveyPredicateRow from '@/components/DataCard/FilterDialogEntry/VwSiteSurveyPredicateRow';
//import StringMultiplePredicateRow from '@/components/DataCard/FilterDialogEntry/StringMultiplePredicateRow';
import {catchLocalVueDuplicateVueBug, getVuetifyWrapper, resetConsoleError} from '../../utils';

let wrapper;
let child;

const Stub = { template: '<div data-test="stub"/>' };

const districts = [
    'district A',
    'district B',
    'district C'
];

const defaultMountOptions = {
    $store: {
        state: {
            vocabulary: {
                districts
            }
        }
    },
    stubs: {VAutocomplete: Stub},
    propsData: {
        predicateKey: 'pKey',
        predicateAttributeLabel: 'aLabel'
    },
    methods: {}
};

beforeAll(() => {
    catchLocalVueDuplicateVueBug();
});

afterAll(() => {
    resetConsoleError();
});

describe('VwSiteDistrictPredicateRow', () => {
    const mountOptions = () => clone(defaultMountOptions);
    beforeEach(() => {
        wrapper = getVuetifyWrapper('shallowMount', VwSiteSurveyPredicateRow, mountOptions());
    });
    describe('watch', () => {
        it('"search"', done => {
            const fetchSurveys = jest.fn();
            wrapper.setMethods({fetchSurveys});
            wrapper.setData({search:'searchPattern'});
            wrapper.vm.$nextTick(() => {
                expect(fetchSurveys).toHaveBeenCalledTimes(1);
                expect(fetchSurveys).toHaveBeenCalledWith('searchPattern');
                done();
            });
        });
    });
    describe('lifecycle', () => {
        it('"created"', () => {
            const setPredicateOperator = jest.fn();
            const options = mountOptions();
            options.methods.setPredicateOperator = setPredicateOperator;
            options.propsData.predicateP = {operator: 'someOperator'}
            wrapper = getVuetifyWrapper('shallowMount', VwSiteSurveyPredicateRow, mountOptions());
            expect(setPredicateOperator).toHaveBeenCalledTimes(1);
            expect(setPredicateOperator).toHaveBeenCalledWith('someOperator');
        });
    });
    describe('methods', () => {
        it('"fetchSurveys"', done => {
            const clientRequest = jest.fn().mockResolvedValue({data: ['someData']});
            wrapper.setMethods({clientRequest});
            wrapper.vm.fetchSurveys('somePattern').then(() => {
                expect(wrapper.vm.surveys).toEqual(['someData']);
                done();
            });
            expect(clientRequest).toHaveBeenCalledTimes(1);
            expect(clientRequest).toHaveBeenCalledWith({
                method:'get',
                url: '/data/voc-survey/codes/somePattern?code-only=1'
            });

        });
    });
});
