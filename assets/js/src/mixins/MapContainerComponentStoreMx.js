import ComponentsStoreMx from './ComponentsStoreMx';

export const MAP_COMPONENT_CID = 'the-map-container';
export const PROPS = {
    CURRENT_BASE_MAP: 'currentBaseMap',
    CURRENT_BING_IMAGERY_SET: 'currentBingImagerySet',
    CURRENT_ADMIN_BOUNDS_LAYER: 'currentAdminBoundsLayer',
    CURRENT_LAYER: 'currentLayer',
    SELECTED_FEATURES: 'selectedFeatures'
};

export default {
    mixins: [
        ComponentsStoreMx
    ],
    computed: {
        mapContainerComponentStoreMx_currentBaseMap: {
            get() {
                return this[this.componentStoreMx_STORE.MODULES.COMPONENTS.GETTERS.PROP.GET](MAP_COMPONENT_CID, PROPS.CURRENT_BASE_MAP);
            },
            set(value) {
                this.componentStoreMx_mutation(this.componentStoreMx_STORE.MODULES.COMPONENTS.MUTATIONS.PROP.SET, {
                    cid: MAP_COMPONENT_CID,
                    prop: PROPS.CURRENT_BASE_MAP,
                    value: value
                });
            }
        },
        mapContainerComponentStoreMx_currentBingImagerySet: {
            get() {
                return this[this.componentStoreMx_STORE.MODULES.COMPONENTS.GETTERS.PROP.GET](MAP_COMPONENT_CID, PROPS.CURRENT_BING_IMAGERY_SET);
            },
            set(value) {
                this.componentStoreMx_mutation(this.componentStoreMx_STORE.MODULES.COMPONENTS.MUTATIONS.PROP.SET, {
                    cid: MAP_COMPONENT_CID,
                    prop: PROPS.CURRENT_BING_IMAGERY_SET,
                    value: value
                });
            }
        },
        mapContainerComponentStoreMx_currentLayer: {
            get() {
                return this[this.componentStoreMx_STORE.MODULES.COMPONENTS.GETTERS.PROP.GET](MAP_COMPONENT_CID, PROPS.CURRENT_LAYER);
            },
            set(value) {
                this.componentStoreMx_mutation(this.componentStoreMx_STORE.MODULES.COMPONENTS.MUTATIONS.PROP.SET, {
                    cid: MAP_COMPONENT_CID,
                    prop: PROPS.CURRENT_LAYER,
                    value: value
                });
            }
        },
        mapContainerComponentStoreMx_currentAdminBoundsLayer: {
            get() {
                return this[this.componentStoreMx_STORE.MODULES.COMPONENTS.GETTERS.PROP.GET](MAP_COMPONENT_CID, PROPS.CURRENT_ADMIN_BOUNDS_LAYER);
            },
            set(value) {
                this.componentStoreMx_mutation(this.componentStoreMx_STORE.MODULES.COMPONENTS.MUTATIONS.PROP.SET, {
                    cid: MAP_COMPONENT_CID,
                    prop: PROPS.CURRENT_ADMIN_BOUNDS_LAYER,
                    value: value
                });
            }
        },
        mapContainerComponentStoreMx_selectedFeatures: {
            get() {
                return this[this.componentStoreMx_STORE.MODULES.COMPONENTS.GETTERS.PROP.GET](MAP_COMPONENT_CID, PROPS.SELECTED_FEATURES);
            },
            set(value) {
                this.componentStoreMx_mutation(this.componentStoreMx_STORE.MODULES.COMPONENTS.MUTATIONS.PROP.SET, {
                    cid: MAP_COMPONENT_CID,
                    prop: PROPS.SELECTED_FEATURES,
                    value: value
                });
            }
        }
    }
};