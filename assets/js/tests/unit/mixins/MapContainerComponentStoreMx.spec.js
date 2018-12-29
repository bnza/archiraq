import MapContainerComponentStoreMx, {PROPS, MAP_COMPONENT_CID} from '../../../src/mixins/MapContainerComponentStoreMx';
import {cid, getWrapper, moduleFuncs} from './utils';

let componentOptions;

beforeEach(() => {
    componentOptions = {
        mixins: [MapContainerComponentStoreMx],
        data: function () {
            return {
                $_componentStoreMx_cid: cid
            };
        }
    };
});

describe('MapContainerComponentStoreMx', () => {
    describe('computed', () => {
        it('mapContainerComponentStoreMx_currentBaseMap', () => {
            const wrapper = getWrapper('shallowMount', componentOptions, {});
            wrapper.vm.mapContainerComponentStoreMx_currentBaseMap;
            expect(wrapper.vm[moduleFuncs.GETTERS.PROP.GET]).toHaveBeenLastCalledWith(
                MAP_COMPONENT_CID,
                PROPS.CURRENT_BASE_MAP
            );
        });
        it('mapContainerComponentStoreMx_currentBingImagerySet', () => {
            const wrapper = getWrapper('shallowMount', componentOptions, {});
            wrapper.vm.mapContainerComponentStoreMx_currentBingImagerySet;
            expect(wrapper.vm[moduleFuncs.GETTERS.PROP.GET]).toHaveBeenLastCalledWith(
                MAP_COMPONENT_CID,
                PROPS.CURRENT_BING_IMAGERY_SET
            );
        });
    });
});