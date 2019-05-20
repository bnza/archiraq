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
                predicateKey: 'pKey',
                predicateAttributeLabel: 'Label'
            }
        };
        let wrapper;
        beforeEach(() => {
            wrapper = getVuetifyWrapper('shallowMount', StringPredicateRow, mountOptions);
        });
        it('StringOperatorSelectInput @input set "operator" property', () => {
            const child = wrapper.find(StringOperatorSelectInput);
            child.vm.$emit('update:value', 'EqualToFilter');
            expect(wrapper.vm.predicate.operator).toEqual('EqualToFilter');
        });
        it('StringLiteralTextField @input set "expressions[1]" property', () => {
            const child = wrapper.find(StringLiteralTextField);
            child.vm.$emit('update:value', 'text value');
            expect(wrapper.vm.predicate.expressions[1]).toEqual('text value');
        });
        it('NegatePredicateSwitch @change set "negate" property', () => {
            expect(wrapper.vm.predicate.negate).toEqual(false);
            const child = wrapper.find(NegatePredicateSwitch);
            child.vm.$emit('update:value', true);
            expect(wrapper.vm.predicate.negate).toEqual(true);
            child.vm.$emit('update:value', false);
            expect(wrapper.vm.predicate.negate).toEqual(false);
        });
    });
});
