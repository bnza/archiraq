import clone from 'lodash/clone';
import VwSiteChronologyPredicateRow from '@/components/DataCard/FilterDialogEntry/VwSiteChronologyPredicateRow';
import StringMultiplePredicateRow from '@/components/DataCard/FilterDialogEntry/StringMultiplePredicateRow';
import {catchLocalVueDuplicateVueBug, getVuetifyWrapper, resetConsoleError} from '../../utils';

let wrapper;
let child;

const Stub = { template: '<div data-test="stub"/>' };

const chronologies = [
    {'id':2,'code':'UBA','name':'UBAID','date_low':-6500,'date_high':-4000},
    {'id':5,'code':'LCA','name':'LATE CHALCOLITHIC','date_low':-4100,'date_high':-3100},
    {'id':9,'code':'EBA','name':'EARLY BRONZE AGE','date_low':-3100,'date_high':-2000}
];

const defaultMountOptions = {
    $store: {
        state: {
            vocabulary: {
                chronologies
            }
        }
    },
    stubs: {VAutocomplete: Stub},
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

describe('VwSiteChronologyPredicateRow', () => {
    const mountOptions = () => clone(defaultMountOptions);
    beforeEach(() => {
        wrapper = getVuetifyWrapper('shallowMount', VwSiteChronologyPredicateRow, mountOptions());
    });
    describe('computed', () => {
        it('"chronologies"', () => {
            expect(wrapper.vm.chronologies).toEqual(chronologies);
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
