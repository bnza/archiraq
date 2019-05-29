import DataCardDialogMx from '@/mixins/DataCardDialogMx';
import {getWrapper} from '../components/utils';

let componentOptions;
let mountOptions;
let wrapper;


beforeEach(() => {
    componentOptions = {
        mixins: [DataCardDialogMx]
    };
    mountOptions= {
        propsData: {
            visible: true
        }
    };
    wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
});

describe('DataCardDialogMx', () => {
    describe('computed', () => {
        describe('"isDialogActive"', () => {
            it('get()', () => {
                expect(wrapper.vm.isDialogActive).toBeTruthy();
            });
            it('set()', () => {
                wrapper.vm.isDialogActive = false;
                expect(wrapper.emitted('update:visible')[0]).toEqual([false]);
            });
        });

    });
});
