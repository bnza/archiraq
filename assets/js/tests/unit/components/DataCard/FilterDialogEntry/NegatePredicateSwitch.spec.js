import NegatePredicateSwitch from '@/components/DataCard/FilterDialogEntry/NegatePredicateSwitch';
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
            const wrapper = getVuetifyWrapper('shallowMount', NegatePredicateSwitch,{
                stubs: { VSelect: Stub }
            });
            const textField = wrapper.find({ref: 'switch'});
            textField.vm.$emit('change', true);
            expect(wrapper.emitted().change[0]).toEqual([true]);
        });
    });
});
