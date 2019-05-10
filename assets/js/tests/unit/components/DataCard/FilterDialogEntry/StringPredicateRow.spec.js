import StringPredicateRow from '@/components/DataCard/FilterDialogEntry/StringPredicateRow';
import StringOperatorSelectInput from '@/components/DataCard/FilterDialogEntry/StringOperatorSelectInput';
import StringLiteralTextField from '@/components/DataCard/FilterDialogEntry/StringLiteralTextField';
import NegatePredicateSwitch from '@/components/DataCard/FilterDialogEntry/NegatePredicateSwitch';

import {catchLocalVueDuplicateVueBug, getVuetifyWrapper, resetConsoleError} from '../../utils';

beforeAll(() => {
    catchLocalVueDuplicateVueBug();
});

afterAll(() => {
    resetConsoleError();
});

describe('StringPredicateListTile', () => {
    describe('children event handling', () => {
        const mountOptions = {
            propsData: {
                predicateIndex: 0,
                predicateAttributeLabel: 'Label'
            }
        };
        it('StringOperatorSelectInput @input set "operator" property', () => {

            const wrapper = getVuetifyWrapper('shallowMount', StringPredicateRow, mountOptions);
            const select = wrapper.find(StringOperatorSelectInput);
            select.vm.$emit('input', 'EqualToFilter');
            expect(wrapper.vm.operator).toEqual('EqualToFilter');
        });
        it('StringLiteralTextField @input set "expressions[1]" property', () => {
            const wrapper = getVuetifyWrapper('shallowMount', StringPredicateRow, mountOptions);
            const select = wrapper.find(StringLiteralTextField);
            select.vm.$emit('input', 'text value');
            expect(wrapper.vm.expressions[1]).toEqual('text value');
        });
        it('NegatePredicateSwitch @change set "negate" property', () => {
            const wrapper = getVuetifyWrapper('shallowMount', StringPredicateRow, mountOptions);
            expect(wrapper.vm.negate).toEqual(false);
            const _switch = wrapper.find(NegatePredicateSwitch);
            _switch.vm.$emit('change', true);
            expect(wrapper.vm.negate).toEqual(true);
            _switch.vm.$emit('change', false);
            expect(wrapper.vm.negate).toEqual(false);
        });
    });
});
