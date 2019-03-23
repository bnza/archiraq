import {state} from '../../../src/store/query/index';
import {GET_PAGINATION} from '../../../src/store/query/getters';
import {SET_PAGINATION} from '../../../src/store/query/mutations';
import DataCardQueryMx from '../../../src/mixins/DataCardQueryMx';
import {getWrapper} from '../components/utils';
import {getNamespacedStoreProp} from '../utils';

let componentOptions;

beforeEach(() => {
    componentOptions = {
        mixins: [DataCardQueryMx]
    };
});

describe('DataCardQueryMx', () => {
    describe('computed', () => {
        it('"pagination" get', () => {
            const getPagination = jest.fn();
            const mountOptions = {
                propsData: {
                    typename: 'vw-site'
                },
                $store: {
                    state: {
                        query: state
                    },
                    getters: {
                        [getNamespacedStoreProp('query', GET_PAGINATION)]: getPagination,
                    }
                }
            };
            const wrapper = getWrapper('mount', componentOptions, mountOptions);
            wrapper.vm.pagination;
            expect(getPagination).toBeCalledWith('vw-site');

        });
        it('"pagination" set', () => {
            const getPagination = jest.fn();
            const mountOptions = {
                propsData: {
                    typename: 'vw-site'
                },
                $store: {
                    state: {
                        query: state
                    },
                    getters: {
                        [getNamespacedStoreProp('query', GET_PAGINATION)]: getPagination,
                    }
                }
            };
            const wrapper = getWrapper('mount', componentOptions, mountOptions);
            wrapper.vm.pagination = {value: 'Some value'};
            expect(wrapper.vm.$store.commit).toHaveBeenCalledWith(
                getNamespacedStoreProp('query', SET_PAGINATION),
                {typename:'vw-site', pagination:{value: 'Some value'}}
            );

        });
    });
});
