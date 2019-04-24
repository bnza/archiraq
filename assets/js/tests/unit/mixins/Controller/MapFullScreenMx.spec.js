import MapFullScreenMx from '../../../../src/mixins/Controller/MapFullScreenMx';
import {CID_THE_MAP_CONTAINER} from '../../../../src/utils/cids';
import {getWrapper} from '../../components/utils';
import * as utils from '../../../../src/utils/utils';

let componentsGetComponentProp = jest.fn();
let componentOptions;
let mountOptions;

beforeEach(() => {
    componentsGetComponentProp.mockClear();
    componentOptions = {
        mixins: [MapFullScreenMx]
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

describe('Controller/MapFullScreenMx', () => {
    describe('computed', () => {
        it('"isFullScreen" retrieves data from $store', () => {
            const componentsGetComponentPropMock = jest.fn();
            mountOptions.computed = {
                componentsGetComponentProp: () => componentsGetComponentPropMock
            };
            const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
            wrapper.vm.isFullScreen;
            expect(componentsGetComponentPropMock).toHaveBeenCalledWith(CID_THE_MAP_CONTAINER, 'height');
        });
        it('"isFullScreen" return expected value', () => {
            expect(MapFullScreenMx.computed.isFullScreen.call({ mapContainerHeight: '500px' })).toEqual(false);
            expect(MapFullScreenMx.computed.isFullScreen.call({ mapContainerHeight: '800px' })).toEqual(true);
        });
        it('"tooltipText" return expected value', () => {
            expect(MapFullScreenMx.computed.tooltipText.call({ isFullScreen: true })).toEqual('Exit fullscreen');
            expect(MapFullScreenMx.computed.tooltipText.call({ isFullScreen: false })).toEqual('Fullscreen');
        });
        it('"icon" return expected value', () => {
            expect(MapFullScreenMx.computed.icon.call({ isFullScreen: true })).toEqual('fullscreen');
            expect(MapFullScreenMx.computed.icon.call({ isFullScreen: false })).toEqual('fullscreen_exit');
        });
    });
    describe('methods', () => {
        it('"toggleFullScreen" commit values to $store', () => {
            const componentsGetComponentPropMock = jest.fn();
            const componentsSetComponentPropMock = jest.fn();
            mountOptions.computed = {
                componentsGetComponentProp: () => componentsGetComponentPropMock,
                isFullScreen: () => false
            };
            mountOptions.methods = {
                componentsSetComponentProp: componentsSetComponentPropMock
            };
            const mock = jest.spyOn(utils, 'getMapPixelHeight');  // spy on otherFn
            mock.mockReturnValue('500px');  // mock the return value
            const wrapper = getWrapper('shallowMount', componentOptions, mountOptions);
            wrapper.vm.toggleFullScreen();
            expect(componentsSetComponentPropMock).toHaveBeenCalledWith({'cid': 'TheMapContainer', 'prop': 'height', 'value': '500px'});
            mock.mockRestore();
        });
    });
});
