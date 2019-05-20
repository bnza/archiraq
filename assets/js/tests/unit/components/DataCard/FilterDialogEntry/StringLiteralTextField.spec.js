import StringLiteralTextField from '@/components/DataCard/FilterDialogEntry/StringLiteralTextField';
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
            const wrapper = getVuetifyWrapper('shallowMount', StringLiteralTextField,{
                stubs: { VTextField: Stub }
            });
            const textField = wrapper.find({ref: 'field'});
            textField.vm.$emit('input', 'text value');
            expect(wrapper.emitted()['update:value'][0]).toEqual(['text value']);
        });
    });
});
