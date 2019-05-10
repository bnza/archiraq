import BinaryPredicateMx from '@/mixins/CQL/BinaryPredicateMx';

describe('BinaryPredicateMx', () => {
    describe('computed', () => {
        it('"hasLeftOperand"', () => {
            let $this = {expressions: ['', 'b']};
            expect(BinaryPredicateMx.computed.hasLeftOperand.apply($this, [])).toBeFalsy();
            $this = {expressions: ['a', 'b']};
            expect(BinaryPredicateMx.computed.hasLeftOperand.apply($this, [])).toBeTruthy();
        });
        it('"hasRightOperand"', () => {
            let $this = {expressions: ['', '']};
            expect(BinaryPredicateMx.computed.hasRightOperand.apply($this, [])).toBeFalsy();
            $this = {expressions: ['a', 'b']};
            expect(BinaryPredicateMx.computed.hasRightOperand.apply($this, [])).toBeTruthy();
        });
        describe('"isPredicateValid"', () => {
            it('is false when no operator', () => {
                const $this = {expressions: ['a', 'b']};
                expect(BinaryPredicateMx.computed.isPredicateValid.apply($this, [])).toBeFalsy();
            });
            it('is false when no attribute', () => {
                const $this = {operator: 'operator', hasRightOperand: false};
                expect(BinaryPredicateMx.computed.isPredicateValid.apply($this, [])).toBeFalsy();
            });
            it('is false when no expression', () => {
                const $this = {operator: 'operator', hasLeftOperand: false};
                expect(BinaryPredicateMx.computed.isPredicateValid.apply($this, [])).toBeFalsy();
            });
            it('is true when required properties are set', () => {
                const $this = {operator: 'operator', hasRightOperand: true, hasLeftOperand: true};
                expect(BinaryPredicateMx.computed.isPredicateValid.apply($this, [])).toBeTruthy();
            });
        });
    });
});
