import AppInteractionSelect from '@/components/DataCard/Interaction/AppInteractionSelect';
import {getWrapper, resetLocaVue} from '@tests/unit/components/utils';
import VueLayers from 'vuelayers';

const feature = {geometry: {'type':'Point','coordinates':[44.2218171,33.149569]}};
let mountOptions = {};
let componentsSetComponentProp = jest.fn();

beforeEach(() => {
    mountOptions = {
        mocks: {
            $store: {
                state: {
                    components: {}
                },
            }
        },
        propsData: {
            layerCid: 'the-layer-cid'
        },
        computed: {
            mapContainerCurrentLayer: () => 'the-layer-cid',
            getQueryFilter() {
                return () => {};
            },
            componentsHasComponent() {
                return () => true;
            },
            visible: {
                get() {
                    return () => true;
                },
                set() {}
            }
        },
        methods: {
            componentsSetComponentProp
        },
        plugins: [
            VueLayers
        ]
    };
    resetLocaVue();
});

describe('AppInteractionSelect', () => {
    describe('computed', () => {
        it('"positioning"', () => {
            const wrapper = getWrapper('mount', AppInteractionSelect, mountOptions);
            expect(wrapper.vm.positioning).toEqual('bottom-left');
        });
        it('"currentFeature"', () => {
            const wrapper = getWrapper('mount', AppInteractionSelect, mountOptions);
            expect(wrapper.vm.currentFeature).toBeFalsy();
            wrapper.setData({selectedFeatures: [feature]});
            expect(wrapper.vm.currentFeature).toStrictEqual(feature);
        });
    });
    describe('methods', () => {
        it('"toggleSelectedFeatures"', () => {
            const $this = {layerCid: 'the-layer-cid', componentsGetComponentProp: jest.fn().mockReturnValue('aValue'), selectedFeatures: null};
            AppInteractionSelect.methods.toggleSelectedFeatures.apply($this, [true]);
            expect($this.selectedFeatures).toEqual('aValue');
            expect($this.componentsGetComponentProp).toHaveBeenCalledWith('the-layer-cid', 'selectedFeatures');
            AppInteractionSelect.methods.toggleSelectedFeatures.apply($this, [false]);
            expect($this.selectedFeatures).toEqual([]);
        });
    });
});
