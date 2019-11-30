import StringOperatorSelectInput from '@/components/DataCard/FilterDialogEntry/StringOperatorSelectInput';
import {catchLocalVueDuplicateVueBug, getVuetifyWrapper, resetConsoleError} from '../../utils';

let wrapper;
let child;

beforeAll(() => {
    catchLocalVueDuplicateVueBug();
});

afterAll(() => {
    resetConsoleError();
});

const Stub = { template: '<div data-test="stub"/>' };

describe('StringLiteralTextField', () => {
    beforeEach(() => {
        wrapper = getVuetifyWrapper('shallowMount', StringOperatorSelectInput,{
            stubs: { VSelect: Stub },
            propsData: {
                value: ''
            }
        });
        child = wrapper.find({ref: 'select'});
    });
    describe('parent props children propagation', () => {
        it('"value" prop', done => {
            wrapper.setProps({value: 'aValue'});
            wrapper.vm.$nextTick(() => {
                expect(child.vm.$attrs.value).toEqual('aValue');
                done();
            });
        });
    });
    describe('children event handling', () => {
        it('VTextField @input set "operator" property', () => {
            child.vm.$emit('input', 'text value');
            expect(wrapper.emitted()['update:value'][0]).toEqual(['text value']);
        });
    });
});
