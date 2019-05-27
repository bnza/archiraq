import DataCardDynamicModalMx from '@/mixins/DataCardDynamicModalMx';
import {getDefaultMountOptions as getDefaultDataCardQueryMxMountOptions} from './DataCardQueryMx.spec';
import {getWrapper, StubComponent} from '../components/utils';


let componentOptions;
let mountOptions;

beforeEach(() => {
    componentOptions = {
        components: {
            StubComponent
        },
        template: `
        <div slot="modal">
            <stub-component ref="modalSlot" />
        </div>
        `,
        mixins: [DataCardDynamicModalMx],
    };
    mountOptions = getDefaultDataCardQueryMxMountOptions();
});

describe('DataCardDynamicModalMx', () => {
    describe('computed', () => {
        it('modalComponent', () => {
            const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
            wrapper.setData({modalComponentType: 'dummy'});
            expect(wrapper.vm.modalComponent).toEqual('DataCardDummyDialog');
        });
        it('modalSlotComponent', () => {
            const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
            wrapper.setData({modalComponentType: 'dummy'});
            expect(wrapper.vm.modalSlotComponent).toEqual('DataCardDummyDialogSlot');
        });
    });
    describe('methods', () => {
        describe('executeModalSlotMethod', () => {
            it('throws when request reference not found (default method value)', () => {
                delete componentOptions.template;
                const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                function executeModalSlotMethod() {
                    return wrapper.vm.executeModalSlotMethod();
                }
                expect(executeModalSlotMethod).toThrowError('No "modalSlot" reference found');
            });
            it('throws when request reference not found', () => {
                const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                function executeModalSlotMethod() {
                    return wrapper.vm.executeModalSlotMethod({ref: 'nonExistent'});
                }
                expect(executeModalSlotMethod).toThrowError('No "nonExistent" reference found');
            });
            it('throws when no method property provided', () => {
                const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                function executeModalSlotMethod() {
                    return wrapper.vm.executeModalSlotMethod();
                }
                expect(executeModalSlotMethod).toThrowError('You must provide "method" property');
            });
            it('throws when referenced component has not the requested method', () => {
                const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                function executeModalSlotMethod() {
                    return wrapper.vm.executeModalSlotMethod({method: 'nonExistentMethod'});
                }
                expect(executeModalSlotMethod).toThrowError('No "nonExistentMethod" method found');
            });
            it('call the requested method in referenced component', () => {
                const args = ['arg1', 56];
                const method = jest.fn();
                const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                const ref = wrapper.find({ref: 'modalSlot'});
                ref.vm.$options.methods = {};
                ref.setMethods({theMethod: method});
                wrapper.vm.executeModalSlotMethod({
                    method: 'theMethod',
                    args
                });
                expect(method).toHaveBeenCalledWith(...args);
            });
        });
        describe('openModal', () => {
            it('set "modalComponent" property', () => {
                const $this = {modalComponentType:''};
                DataCardDynamicModalMx.methods.openModal.apply($this, ['export']);
                expect($this.modalComponentType).toEqual('export');
            });
            it('set "isModalVisible" property true', () => {
                const $this = {isModalVisible:false};
                DataCardDynamicModalMx.methods.openModal.apply($this, ['export']);
                expect($this.isModalVisible).toBeTruthy();
            });
        });
        describe('closeModal', () => {
            it('set "isModalVisible" property false', () => {
                const $this = {isModalVisible:true};
                DataCardDynamicModalMx.methods.closeModal.apply($this);
                expect($this.isModalVisible).toBeFalsy();
            });
        });
    });
});
