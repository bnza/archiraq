import NestedSlotPredicateMx from '@/mixins/CQL/NestedSlotPredicateMx';
import {getWrapper} from '../../components/utils';

let componentOptions;
let mountOptions;

let wrapper;
let Stub;

let setPredicateExpression;

beforeEach(() => {
    componentOptions = {
        mixins: [NestedSlotPredicateMx],
    };
    mountOptions = {
        propsData: {
            predicateKey: 'pKey'
        }
    };
    setPredicateExpression = jest.fn();
    Stub = {
        template: '<div data-test="stub"/>',
    };
});

describe('NestedSlotPredicateMx', () => {
    describe('methods', () => {
        describe('setPredicateExpression', () => {
            it('calls $refs.predicate "setPredicateExpression" method', () => {
                componentOptions.components = {Stub};
                componentOptions.template = '<div><stub ref="predicate"></stub></div>';
                wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                const child = wrapper.find({ref: 'predicate'});
                child.vm.$options.methods = {};
                child.setMethods({setPredicateExpression: setPredicateExpression})
                wrapper.vm.setPredicateExpression('aValue');
                expect(setPredicateExpression).toHaveBeenCalledWith('aValue');
            });
            it('throws a meaningful error when no "predicate" ref child found', () => {
                wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                const _setPredicateExpression = () => {
                    wrapper.vm.setPredicateExpression('aValue');
                };
                expect(_setPredicateExpression).toThrow(/^You must register/);
            });
            it('throws a meaningful error when "predicate" not implement "setPredicateExpression" method', () => {
                componentOptions.components = {Stub};
                componentOptions.template = '<div><stub ref="predicate"></stub></div>';
                wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                const _setPredicateExpression = () => {
                    wrapper.vm.setPredicateExpression('aValue');
                };
                expect(_setPredicateExpression).toThrow(/Did you register "PredicateMx" mixin\?$/);
            });
        });
    });
    describe('watch', () => {
        beforeEach(() => {
            wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
        });
        describe('"predicateP"', () => {
            it('change "value" property', done => {
                expect(wrapper.vm.value).toEqual([]);
                wrapper.setProps({predicateP: {expressions: [undefined, 'aValue']}});
                wrapper.vm.$nextTick(() => {
                    expect(wrapper.vm.value).toEqual('aValue');
                    done();
                });
            });
        });
    });
});
