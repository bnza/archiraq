import MapDrawerMx from '../../../../src/mixins/Controller/MapDrawerMx';
import {CID_THE_MAP_LAYERS_DRAWER} from '../../../../src/utils/cids';
import {getWrapper} from '../../components/utils';

let componentsGetComponentProp = jest.fn();
let componentOptions;
let mountOptions;

beforeEach(() => {
    componentsGetComponentProp.mockClear();
    componentOptions = {
        mixins: [MapDrawerMx]
    };
    mountOptions = {
        $store: {
            state: {
                components: {
                    all: {}
                }
            }
        }
    };
});

describe('Controller/MapDrawerMx', () => {
    describe('computed', () => {
        it('"isDrawerVisible" retrieves data from $store', () => {
            const localThis = { componentsGetComponentProp };
            MapDrawerMx.computed.isDrawerVisible.call(localThis);
            expect(componentsGetComponentProp).toHaveBeenCalledWith(CID_THE_MAP_LAYERS_DRAWER, 'visible');
        });
        it('"tooltipText" return right value', () => {
            expect(MapDrawerMx.computed.tooltipText.call({ isDrawerVisible: true })).toEqual('Hide map layers');
            expect(MapDrawerMx.computed.tooltipText.call({ isDrawerVisible: false })).toEqual('Show map layers');
        });
        it('"icon" return right value', () => {
            expect(MapDrawerMx.computed.icon.call({ isDrawerVisible: true })).toEqual('layers_clear');
            expect(MapDrawerMx.computed.icon.call({ isDrawerVisible: false })).toEqual('layers');
        });
    });
    describe('methods', () => {
        it('"toggleMapLayersDrawerVisibility" commit values to $store', () => {
            const componentsToggleComponentPropMock = jest.fn();
            mountOptions.methods = {
                componentsToggleComponentProp: componentsToggleComponentPropMock
            };
            const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
            wrapper.vm.toggleMapLayersDrawerVisibility();
            expect(componentsToggleComponentPropMock).toHaveBeenCalledWith({'cid': CID_THE_MAP_LAYERS_DRAWER, 'prop': 'visible'});
        });
    });
});
