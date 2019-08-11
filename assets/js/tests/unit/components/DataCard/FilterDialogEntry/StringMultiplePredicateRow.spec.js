import StringMultiplePredicateRow from '@/components/DataCard/FilterDialogEntry/StringMultiplePredicateRow';
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

describe('StringMultiplePredicateRow', () => {
    describe('lifecycle events', () => {
        let setPredicateOperator;
        let mountOptions;
        let wrapper;
        beforeEach(() => {
            setPredicateOperator = jest.fn();
            mountOptions = {
                methods: { setPredicateOperator },
                propsData: {
                    predicateP: {
                        operator: 'someFancyOperator'
                    },
                    predicateKey: 'pKey',
                    predicateAttributeLabel: 'Label'
                }
            };
            wrapper = getVuetifyWrapper('shallowMount', StringMultiplePredicateRow, mountOptions);
        });
        it('StringOperatorSelectInput @input set "operator" property', () => {
            expect(setPredicateOperator).toHaveBeenCalledWith('someFancyOperator');
        });
    });
});
