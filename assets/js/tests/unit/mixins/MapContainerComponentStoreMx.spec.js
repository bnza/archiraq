import {componentName, getWrapper, resetLocaVue} from '../components/utils';
import MapContainerComponentStoreMx from '@/mixins/MapContainerComponentStoreMx';
import {
    CID_THE_MAP_CONTAINER,
    WFS_TYPENAME_VW_SITES_SURVEY,
    WFS_TYPENAME_VW_SITES_RS
} from '@/utils/cids';

let mountOptions = {};
let componentOptions = {};

let componentsGetComponentProp;
let componentsSetComponentProp;
let componentsToggleComponentProp;

beforeEach(() => {
    componentsGetComponentProp = jest.fn();
    componentsSetComponentProp = jest.fn();
    componentsToggleComponentProp = jest.fn();
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
            componentsSetComponentProp,
            componentsToggleComponentProp
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
        describe('mapContainerVwSitesSurveyVisible', () => {
            it('getter', () => {
                const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                wrapper.vm.mapContainerVwSitesSurveyVisible;
                expect(componentsGetComponentProp).toHaveBeenCalledWith(WFS_TYPENAME_VW_SITES_SURVEY, 'visible');
            });
            it('setter', () => {
                const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                wrapper.vm.mapContainerVwSitesSurveyVisible = true;
                expect(componentsToggleComponentProp).toHaveBeenCalledWith({
                    cid: WFS_TYPENAME_VW_SITES_SURVEY,
                    prop: 'visible'}
                );
            });
        });
        describe('mapContainerVwSitesRemoteSensingVisible', () => {
            it('getter', () => {
                const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                wrapper.vm.mapContainerVwSitesRemoteSensingVisible;
                expect(componentsGetComponentProp).toHaveBeenCalledWith(WFS_TYPENAME_VW_SITES_RS, 'visible');
            });
            it('setter', () => {
                const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                wrapper.vm.mapContainerVwSitesRemoteSensingVisible = true;
                expect(componentsToggleComponentProp).toHaveBeenCalledWith({
                    cid: WFS_TYPENAME_VW_SITES_RS,
                    prop: 'visible'}
                );
            });
        });
        it('mapContainerPointerCoordX', () => {
            mountOptions.computed.mapContainerPointerCoords = function() {return [10,20];};
            const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
            expect(wrapper.vm.mapContainerPointerCoordX).toEqual(10);
        });
        it('mapContainerPointerCoordY', () => {
            mountOptions.computed.mapContainerPointerCoords = function() {return [10,20];};
            const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
            expect(wrapper.vm.mapContainerPointerCoordY).toEqual(20);
        });
        describe('mapContainerCallee', () => {
            it('getter', () => {
                const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                wrapper.vm.mapContainerCallee;
                expect(componentsGetComponentProp).toHaveBeenCalledWith(CID_THE_MAP_CONTAINER, 'callee');
            });
            it('setter', () => {
                const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
                wrapper.vm.mapContainerCallee = {some: 'value'};
                expect(componentsSetComponentProp).toHaveBeenCalledWith({
                    cid: CID_THE_MAP_CONTAINER,
                    prop: 'callee',
                    value: {some: 'value'}
                });
            });
        });
    });
    describe('methods', () => {
        it('mapContainerCallMethod', () => {
            const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
            wrapper.vm.mapContainerCallMethod('someMethod', ['arg1', 0]);
            expect(componentsSetComponentProp).toHaveBeenCalledWith({
                'cid': CID_THE_MAP_CONTAINER,
                'prop': 'callee',
                'value': {'args': ['arg1', 0], 'method': 'someMethod'}
            });
        });
    });
});
