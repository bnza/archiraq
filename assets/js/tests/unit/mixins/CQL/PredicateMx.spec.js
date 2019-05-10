import PredicateMx from '../../../../src/mixins/CQL/PredicateMx';
import {getWrapper} from '../../components/utils';

let componentOptions;

beforeEach(() => {
    componentOptions = {
        mixins: [PredicateMx],
        computed: {
            isPredicateValid() {
                return true;
            }
        }
    };
});

describe('PredicateMx', () => {
    describe('methods', () => {
        describe('getFilter', () => {
            it('equalToFilter', () => {
                const wrapper = getWrapper('shallowMount', componentOptions, {propsData: {predicateIndex: 1}});
                wrapper.setData({ operator: 'EqualToFilter', expressions: ['attributeName', 'searchValue'] });
                expect(wrapper.vm.getFilter()).toEqual({'expression': 'searchValue', 'matchCase': true, 'propertyName': 'attributeName', 'tagName_': 'PropertyIsEqualTo'});
            });
            it('equalToFilter (negate)', () => {
                const wrapper = getWrapper('shallowMount', componentOptions, {propsData: {predicateIndex: 1}});
                wrapper.setData({ operator: 'EqualToFilter', expressions: ['attributeName', 'searchValue'], negate: true });
                expect(wrapper.vm.getFilter()).toEqual({'condition': {'expression': 'searchValue', 'matchCase': true, 'propertyName': 'attributeName', 'tagName_': 'PropertyIsEqualTo'}, 'tagName_': 'Not'});
            });
        });
    });
});
