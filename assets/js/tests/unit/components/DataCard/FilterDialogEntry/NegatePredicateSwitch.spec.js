import NegatePredicateSwitch from '@/components/DataCard/FilterDialogEntry/NegatePredicateSwitch';
import {catchLocalVueDuplicateVueBug, getVuetifyWrapper, resetConsoleError} from '../../utils';

beforeAll(() => {
    catchLocalVueDuplicateVueBug();
});

afterAll(() => {
    resetConsoleError();
});

describe('NegatePredicateSwitch', () => {
    describe('children event handling', () => {
        it('VTextField @input set "operator" property', () => {
            const wrapper = getVuetifyWrapper('shallowMount', NegatePredicateSwitch, {propsData: {value: false}});
            const textField = wrapper.find({ref: 'switch'});
            textField.vm.$emit('change', true);
            expect(wrapper.emitted()['update:value'][0]).toEqual([true]);
        });
    });
});
