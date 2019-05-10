import ConditionMx from '@/mixins/CQL/ConditionMx';
import Vue from 'vue';

describe('ConditionMx', () => {
    describe('methods', () => {
        describe('setCondition', () => {
            it('set "conditions" when value is truthy', () => {
                const $this = {conditions:{}, $set: Vue.set};
                ConditionMx.methods.setCondition.apply($this, [2, 'a condition']);
                expect($this.conditions).toHaveProperty('k2');
                expect($this.conditions.k2).toEqual('a condition');
            });
            it('call "unsetCondition" when value is null', () => {
                const $this = {
                    unsetCondition: jest.fn(),
                };
                ConditionMx.methods.setCondition.apply($this, [4, null]);
                expect($this.unsetCondition).toHaveBeenCalledWith(4);
            });
        });
        describe('unsetCondition', () => {
            it('unset "conditions" property as expected', () => {
                const $this = {conditions:{k4: 'a value', k6: 'another value'}};
                ConditionMx.methods.unsetCondition.apply($this, [4]);
                expect($this.conditions).not.toHaveProperty('k4');
                expect($this.conditions).toHaveProperty('k6');
                expect($this.conditions.k6).toEqual('another value');
            });
        });
        describe('getCondition', () => {
            it('get conditions\' array', () => {
                const $this = {conditions:{k4: 'a value', k6: 'another value'}};
                const conditions = ConditionMx.methods.getConditions.apply($this, [4]);
                expect(conditions).toEqual(['a value', 'another value']);
            });
        });
    });
});
