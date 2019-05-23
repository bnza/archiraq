import clone from 'lodash/clone';
import VwSiteDistrictPredicateRow from '@/components/DataCard/FilterDialogEntry/VwSiteDistrictPredicateRow';
import StringMultiplePredicateRow from '@/components/DataCard/FilterDialogEntry/StringMultiplePredicateRow';
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
    stubs: {VSelect: Stub},
    propsData: {
        predicateKey: 'pKey',
    }
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
        wrapper = getVuetifyWrapper('shallowMount', VwSiteDistrictPredicateRow, mountOptions());
    });
    describe('computed', () => {
        it('"districts"', () => {
            expect(wrapper.vm.districts).toEqual(districts);
        });
    });
    describe('children event handling', () => {
        it('StringMultiplePredicateRow @change $emit "change"', () => {
            child = wrapper.find(StringMultiplePredicateRow);
            child.vm.$emit('change', 'aPredicate');
            expect(wrapper.emitted().change.length).toEqual(1);
            expect(wrapper.emitted().change[0]).toEqual(['aPredicate']);
        });
    });
});
