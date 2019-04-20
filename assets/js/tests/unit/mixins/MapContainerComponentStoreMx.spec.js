import {componentName, getWrapper, resetLocaVue} from '../components/utils';
import MapContainerComponentStoreMx from '../../../src/mixins/MapContainerComponentStoreMx';
import {CID_THE_MAP_CONTAINER} from '../../../src/utils/cids';

let mountOptions = {};
let componentOptions = {};

let componentsGetComponentProp;
let componentsSetComponentProp;

beforeEach(() => {
    componentsGetComponentProp = jest.fn();
    componentsSetComponentProp = jest.fn();
    mountOptions = {
        mocks: {
            $store: {
                state: {
                    components: {
                        all: {}
                    }
                }
            }
        },
        computed: {
            componentsHasComponent() {
                return () => true;
            },
            componentsGetComponentProp() {
                return componentsGetComponentProp;
            },
        },
        methods: {
            componentsSetComponentProp: componentsSetComponentProp
        }
    };
    componentOptions = {
        name: componentName,
        mixins: [MapContainerComponentStoreMx],
    };
    resetLocaVue();
});

describe('MapContainerComponentStoreMx', () => {
    describe('computed', () => {
        describe('mapContainerHeight', () => {
            it('getter', () => {
                const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                wrapper.vm.mapContainerHeight;
                expect(componentsGetComponentProp).toHaveBeenCalledWith(CID_THE_MAP_CONTAINER, 'height');
            });
            it('setter', () => {
                const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                wrapper.vm.mapContainerHeight = 'someValue';
                expect(componentsSetComponentProp).toHaveBeenCalledWith({
                    cid: CID_THE_MAP_CONTAINER,
                    prop: 'height',
                    value: 'someValue'}
                );
            });
        });
        describe('mapContainerCurrentLayer', () => {
            it('getter', () => {
                const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                wrapper.vm.mapContainerCurrentLayer;
                expect(componentsGetComponentProp).toHaveBeenCalledWith(CID_THE_MAP_CONTAINER, 'currentLayer');
            });
            it('setter', () => {
                const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                wrapper.vm.mapContainerCurrentLayer = 'someValue';
                expect(componentsSetComponentProp).toHaveBeenCalledWith({
                    cid: CID_THE_MAP_CONTAINER,
                    prop: 'currentLayer',
                    value: 'someValue'}
                );
            });
        });
        describe('mapContainerBaseMap', () => {
            it('getter', () => {
                const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                wrapper.vm.mapContainerBaseMap;
                expect(componentsGetComponentProp).toHaveBeenCalledWith(CID_THE_MAP_CONTAINER, 'baseMap');
            });
            it('setter', () => {
                const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                wrapper.vm.mapContainerBaseMap = 'someValue';
                expect(componentsSetComponentProp).toHaveBeenCalledWith({
                    cid: CID_THE_MAP_CONTAINER,
                    prop: 'baseMap',
                    value: 'someValue'}
                );
            });
        });
        describe('mapContainerAdminBounds', () => {
            it('getter', () => {
                const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                wrapper.vm.mapContainerAdminBounds;
                expect(componentsGetComponentProp).toHaveBeenCalledWith(CID_THE_MAP_CONTAINER, 'adminBounds');
            });
            it('setter', () => {
                const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                wrapper.vm.mapContainerAdminBounds = 'someValue';
                expect(componentsSetComponentProp).toHaveBeenCalledWith({
                    cid: CID_THE_MAP_CONTAINER,
                    prop: 'adminBounds',
                    value: 'someValue'}
                );
            });
        });
        describe('mapContainerBingImagerySet', () => {
            it('getter', () => {
                const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                wrapper.vm.mapContainerBingImagerySet;
                expect(componentsGetComponentProp).toHaveBeenCalledWith(CID_THE_MAP_CONTAINER, 'bingImagerySet');
            });
            it('setter', () => {
                const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                wrapper.vm.mapContainerBingImagerySet = 'someValue';
                expect(componentsSetComponentProp).toHaveBeenCalledWith({
                    cid: CID_THE_MAP_CONTAINER,
                    prop: 'bingImagerySet',
                    value: 'someValue'}
                );
            });
        });
        describe('mapContainerPointerCoords', () => {
            it('getter', () => {
                const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                wrapper.vm.mapContainerPointerCoords;
                expect(componentsGetComponentProp).toHaveBeenCalledWith(CID_THE_MAP_CONTAINER, 'pointerCoords');
            });
            it('setter', () => {
                const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                wrapper.vm.mapContainerPointerCoords = 'someValue';
                expect(componentsSetComponentProp).toHaveBeenCalledWith({
                    cid: CID_THE_MAP_CONTAINER,
                    prop: 'pointerCoords',
                    value: 'someValue'}
                );
            });
        });
    });
});
