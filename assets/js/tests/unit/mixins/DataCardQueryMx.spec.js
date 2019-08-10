import {state} from '../../../src/store/query/index';
import {GET_PAGINATION, GET_FILTER} from '../../../src/store/query/getters';
import {SET_PAGINATION, SET_FILTER} from '../../../src/store/query/mutations';
import DataCardQueryMx from '../../../src/mixins/DataCardQueryMx';
import {getWrapper} from '../components/utils';
import {getNamespacedStoreProp} from '../utils';

let componentOptions;
let mountOptions;
let getPagination;
let getFilter;

export const getDefaultMountOptions = () => {
    return {
        propsData: {
            queryTypename: 'some-query-name'
        },
        $store: {
            state: {
                query: state
            },
            getters: {
                [getNamespacedStoreProp('query', GET_PAGINATION)]: jest.fn(),
                [getNamespacedStoreProp('query', GET_FILTER)]: jest.fn()
            }
        }
    };
};

beforeEach(() => {
    mountOptions = getDefaultMountOptions();
    componentOptions = {
        mixins: [DataCardQueryMx]
    };
    getPagination = mountOptions.$store.getters[getNamespacedStoreProp('query', GET_PAGINATION)];
    getFilter = mountOptions.$store.getters[getNamespacedStoreProp('query', GET_FILTER)];
});

describe('DataCardQueryMx', () => {
    describe('computed', () => {
        describe('"pagination"', () => {
            it('get()', () => {
                const wrapper = getWrapper('mount', componentOptions, mountOptions);
                wrapper.vm.pagination;
                expect(getPagination).toBeCalledWith('some-query-name');

            });
            it('set()', () => {
                const wrapper = getWrapper('mount', componentOptions, mountOptions);
                wrapper.vm.pagination = {value: 'Some value'};
                expect(wrapper.vm.$store.commit).toHaveBeenCalledWith(
                    getNamespacedStoreProp('query', SET_PAGINATION),
                    {typename:'some-query-name', pagination:{value: 'Some value'}}
                );
            });
        });
        describe('"filter"', () => {
            it('get()', () => {
                const wrapper = getWrapper('mount', componentOptions, mountOptions);
                wrapper.vm.filter;
                expect(getFilter).toBeCalledWith('some-query-name');

            });
            it('set()', () => {
                const wrapper = getWrapper('mount', componentOptions, mountOptions);
                //wrapper.setMethods({getQueryTypeName: jest.fn().mockReturnValue('mock-type-name')});
                wrapper.vm.filter = {value: 'Some value'};
                expect(wrapper.vm.$store.commit).toHaveBeenCalledWith(
                    getNamespacedStoreProp('query', SET_FILTER),
                    {typename:'some-query-name', filter:{value: 'Some value'}}
                );
            });
        });
    });
});
