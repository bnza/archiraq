import {cloneDeep} from 'lodash';
import VwSiteConditionRows from '@/components/DataCard/FilterDialogEntry/VwSiteConditionRows';
import {catchLocalVueDuplicateVueBug, getVuetifyWrapper, resetConsoleError} from '../../utils';

let wrapper;
let mountOptions;


const defaultMountOptions = {
    $store: {
        state: {
            vocabulary: {

            }
        }
    },
    computed: {
        getQueryConditions: () => jest.fn()
    },
    propsData: {
        modalProps: {
            queryTypename: 'some-query-typename'
        },
    }
};

beforeAll(() => {
    catchLocalVueDuplicateVueBug();
});

afterAll(() => {
    resetConsoleError();
});

describe('VwSiteDistrictPredicateRow', () => {
    beforeEach(() => {
        mountOptions = () => cloneDeep(defaultMountOptions);
        wrapper = getVuetifyWrapper('shallowMount', VwSiteConditionRows, mountOptions());
    });

    describe('computed', () => {
        it('"queryTypename"', () => {
            expect(wrapper.vm.queryTypename).toEqual('some-query-typename');
        });
    });
/*    describe('children event handling', () => {
        it('StringMultiplePredicateRow @change $emit "change"', () => {
            child = wrapper.find(StringMultiplePredicateRow);
            child.vm.$emit('change', 'aPredicate');
            expect(wrapper.emitted().change.length).toEqual(1);
            expect(wrapper.emitted().change[0]).toEqual(['aPredicate']);
        });
    });*/
});
