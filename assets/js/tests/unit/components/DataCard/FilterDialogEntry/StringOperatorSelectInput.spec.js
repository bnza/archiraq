import StringOperatorSelectInput from '@/components/DataCard/FilterDialogEntry/StringOperatorSelectInput';
import {catchLocalVueDuplicateVueBug, getVuetifyWrapper, resetConsoleError} from '../../utils';

beforeAll(() => {
    catchLocalVueDuplicateVueBug();
});

afterAll(() => {
    resetConsoleError();
});

const Stub = { template: '<div />' }

describe('StringLiteralTextField', () => {
    describe('children event handling', () => {
        it('VTextField @input set "operator" property', () => {
            const wrapper = getVuetifyWrapper('shallowMount', StringOperatorSelectInput,{
                stubs: { VSelect: Stub }
            });
            const textField = wrapper.find({ref: 'select'});
            textField.vm.$emit('input', 'text value');
            expect(wrapper.emitted().input[0]).toEqual(['text value']);
        });
    });
});
