import DataCardContainer from '../../../../src/components/DataCard/DataCardContainer';
import {getVuetifyWrapper, catchLocalVueDuplicateVueBug, resetConsoleError} from '../../components/utils';
import {getNamespacedStoreProp} from '../../utils';
import {SET_PAGINATION} from '../../../../src/store/query/mutations';

beforeAll(() => {
    catchLocalVueDuplicateVueBug();
});

afterAll(() => {
    resetConsoleError();
});

describe('DataCardContainer', () => {
    describe('lifecycle', () => {
        describe('created', () => {
            it('set "pagination" when $route query contains pagination', () => {
                const wrapper = getVuetifyWrapper(
                    'shallowMount',
                    DataCardContainer,
                    {
                        $store: {
                            getters: {
                                'query/getPagination': jest.fn()
                            }
                        },
                        mocks: {
                            $route: {
                                fullPath: 'some/path?pagination%5Bpage%5D=1'
                            },
                        },
                        propsData: {
                            action: 'list',
                            typename: 'vw-site'
                        }
                    });
                expect(wrapper.vm.$store.commit).toHaveBeenCalledWith(
                    getNamespacedStoreProp('query', SET_PAGINATION),
                    {typename:'vw-site', pagination:{page: '1'}}
                );
            });
        });
    });

    describe('computed', () => {
        it('dataComponent', () => {
            const wrapper = getVuetifyWrapper(
                'shallowMount',
                DataCardContainer,
                {
                    $store: {
                        getters: {
                            'query/getPagination': jest.fn()
                        }
                    },
                    mocks: {
                        $route: {
                            fullPath: 'some/path'
                        },
                    },
                    propsData: {
                        action: 'list',
                        typename: 'vw-site'
                    }
                });
            expect(wrapper.vm.dataComponent).toEqual('VwSiteListDataCard');
        });
    });
});
