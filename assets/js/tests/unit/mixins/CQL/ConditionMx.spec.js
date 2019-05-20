import ConditionMx from '@/mixins/CQL/ConditionMx';
import Vue from 'vue';

describe('ConditionMx', () => {
    describe('methods', () => {
        describe('setCondition', () => {
            it('set "conditions" when value is truthy', () => {
                const $this = {conditions:{}, $set: Vue.set};
                ConditionMx.methods.setCondition.apply($this, [{key:'aKey', predicate: 'a condition'}]);
                expect($this.conditions).toHaveProperty('aKey');
                expect($this.conditions.aKey).toEqual('a condition');
            });
            it('call "unsetCondition" when value is null', () => {
                const $this = {
                    unsetCondition: jest.fn(),
                };
                ConditionMx.methods.setCondition.apply($this, [{key:'aKey', predicate: null}]);
                expect($this.unsetCondition).toHaveBeenCalledWith('aKey');
            });
        });
        describe('unsetCondition', () => {
            it('unset "conditions" property as expected', () => {
                const $this = {conditions:{aKey: 'a value', anotherKey: 'another value'}};
                ConditionMx.methods.unsetCondition.apply($this, ['aKey']);
                expect($this.conditions).not.toHaveProperty('aKey');
                expect($this.conditions).toHaveProperty('anotherKey');
                expect($this.conditions.anotherKey).toEqual('another value');
            });
        });
    });
});
