import PredicateMx from '@/mixins/CQL/PredicateMx';
import {getWrapper} from '../../components/utils';

let componentOptions;
let mountOptions;

const stubComputed = {
    computed: {
        isPredicateValid() {
            return true;
        }
    }
};

beforeEach(() => {
    componentOptions = {
        mixins: [PredicateMx],
    };
    mountOptions = {
        propsData: {
            predicateKey: 'pKey'
        }
    };
});

describe('PredicateMx', () => {
    describe('computed', () => {
        let wrapper;
        beforeEach(() => {
            wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
        });
        describe('"attribute"', () => {
            it('(get)', () => {
                wrapper.vm.predicate.expressions.push('attributeName');
                expect(wrapper.vm.attribute).toEqual('attributeName');
            });
            it('(set)', () => {
                expect(wrapper.vm.attribute).toEqual(undefined);
                wrapper.vm.attribute = 'attributeName';
                expect(wrapper.vm.predicate.expressions[0]).toEqual('attributeName');
            });
        });
        describe('"isPredicateValidColor"', () => {
            it('is "blue lighten-5" when "isPredicateValid" true', () => {
                Object.assign(componentOptions,  {
                    computed: {
                        isPredicateValid() {
                            return true;
                        }
                    }});
                const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                expect(wrapper.vm.isPredicateValidColor).toEqual('blue lighten-5');
            });
            it('is "white" when "isPredicateValid" false', () => {
                Object.assign(componentOptions,  {
                    computed: {
                        isPredicateValid() {
                            return false;
                        }
                    }});
                const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                expect(wrapper.vm.isPredicateValidColor).toEqual('white');
            });
        });
    });
    describe('methods', () => {
        describe('setNegatePredicate', () => {
            let wrapper;
            beforeEach(done => {
                wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                expect(wrapper.vm.predicate.negate).toEqual(false);
                wrapper.vm.$nextTick(() => {
                    wrapper.vm.setNegatePredicate(true);
                    done();
                });
            });
            it('set predicate "negate" property', () => {
                let wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                expect(wrapper.vm.predicate.negate).toEqual(false);
                wrapper.vm.setNegatePredicate(true);
                expect(wrapper.vm.predicate.negate).toEqual(true);
            });
            it('is reactive', done => {
                wrapper.vm.$nextTick(() => {
                    const emittedChanges = wrapper.emitted().change;
                    expect(emittedChanges[0][0].predicate.negate).toEqual(true);
                    done();
                });
            });
        });
        describe('setPredicateOperator', () => {
            let wrapper;
            beforeEach(done => {
                wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                expect(wrapper.vm.predicate.operator).toEqual('');
                wrapper.vm.$nextTick(() => {
                    wrapper.vm.setPredicateOperator('aPredicateOperator');
                    done();
                });
            });
            it('set predicate "operator" property', () => {
                expect(wrapper.vm.predicate.operator).toEqual('aPredicateOperator');
            });
            it('is reactive', done => {
                wrapper.vm.$nextTick(() => {
                    const emittedChanges = wrapper.emitted().change;
                    expect(emittedChanges[0][0].predicate.operator).toEqual('aPredicateOperator');
                    done();
                });
            });
        });
        describe('setPredicateExpression', () => {
            let wrapper;
            let expressions;
            beforeEach(() => {
                wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                expressions = wrapper.vm.predicate.expressions;
            });
            it('with index', () => {
                expect(expressions[4]).toEqual(undefined);
                wrapper.vm.setPredicateExpression('aValue', 4);
                expect(expressions[4]).toEqual('aValue');
            });
            it('without index', () => {
                expect(expressions[1]).toEqual(undefined);
                wrapper.vm.setPredicateExpression('aValue');
                expect(expressions[1]).toEqual('aValue');
            });
            it('is reactive', done => {
                wrapper.vm.setPredicateExpression('aValue');
                wrapper.vm.$nextTick(() => {
                    const emittedChanges = wrapper.emitted().change;
                    expect(emittedChanges[0][0].predicate.expressions[1]).toEqual('aValue');
                    done();
                });
            });
        });
    });
    describe('watch', () => {
        let wrapper;
        const predicate = {
            negate: false,
            expressions: ['modern_name'],
            operator: 'equalToFilter',
        };
        beforeEach(() => {
            Object.assign(componentOptions, stubComputed);
            wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
        });
        describe('predicate', () => {
            it('$emit "change" event', done => {
                wrapper.setData({predicate});
                wrapper.vm.$nextTick(() => {
                    const emittedChanges = wrapper.emitted().change;
                    expect(emittedChanges.length).toEqual(1);
                    expect(emittedChanges.pop()).toEqual([{
                        key: 'pKey',
                        predicate: {isValid: true, ...predicate}
                    }]);
                    done();
                });
            });
        });
        describe('predicateP', () => {
            it('not $emit "change" event', done => {
                wrapper.setProps({predicateP: predicate});
                wrapper.vm.$nextTick(() => {
                    expect(wrapper.emitted().change).toBeFalsy();
                    done();
                });
            });
            it('set "predicate" property', done => {
                expect(wrapper.vm.predicate).toEqual({
                    'expressions': [],
                    'negate': false,
                    'operator': ''
                });
                wrapper.setProps({predicateP: predicate});
                wrapper.vm.$nextTick(() => {
                    expect(wrapper.vm.predicate).toEqual(predicate);
                    done();
                });
            });
        });
    });
});
