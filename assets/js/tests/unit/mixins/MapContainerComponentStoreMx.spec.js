import {
    CID_THE_MAP_CONTAINER,
    PK_CURRENT_BASE_MAP,
    PK_CURRENT_BING_IMAGERY_SET,
    STORE_M_COMPONENTS_G_COMPONENT_PROP,

} from '../../../src/utils/constants';
import MapContainerComponentStoreMx from '../../../src/mixins/MapContainerComponentStoreMx';
import {cid, getWrapper} from './utils';

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
            expect(wrapper.vm[STORE_M_COMPONENTS_G_COMPONENT_PROP]).toHaveBeenLastCalledWith(
                CID_THE_MAP_CONTAINER,
                PK_CURRENT_BASE_MAP
            );
        });
        it('mapContainerComponentStoreMx_currentBingImagerySet', () => {
            const wrapper = getWrapper('shallowMount', componentOptions, {});
            wrapper.vm.mapContainerComponentStoreMx_currentBingImagerySet;
            expect(wrapper.vm[STORE_M_COMPONENTS_G_COMPONENT_PROP]).toHaveBeenLastCalledWith(
                CID_THE_MAP_CONTAINER,
                PK_CURRENT_BING_IMAGERY_SET
            );
        });
    });
});
