import DataCardTableMx from '@/mixins/DataCardTableMx';
import {getWrapper} from '../components/utils';

let componentOptions;
let mountOptions;
let wrapper;

describe('DataCardDialogMx', () => {
    describe('props', () => {
        beforeEach(() => {
            componentOptions = {
                mixins: [DataCardTableMx]
            };
            mountOptions= {
                propsData: {
                    queryTypename: 'some-query-name'
                }
            };
            wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
        });
        it('default props', () => {
            expect(wrapper.vm.totalItems).toEqual(0);
            expect(wrapper.vm.items).toEqual([]);
            expect(wrapper.vm.headers).toEqual([]);
            expect(wrapper.vm.isRequestPending).toEqual(false);
        });
    });
});
