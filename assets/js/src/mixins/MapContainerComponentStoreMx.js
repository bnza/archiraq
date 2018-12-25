import ComponentsStoreMx from './ComponentsStoreMx';

export const MAP_COMPONENT_CID = 'the-map-container';
export const PROPS = {
    CURRENT_BASE_MAP: 'currentBaseMap',
    CURRENT_BING_IMAGERY_SET: 'currentBingImagerySet'
};

export default {
    mixins: [
        ComponentsStoreMx
    ],
    computed: {
        mapContainerComponentStoreMx_currentBaseMap: {
            get() {
                return this[this.componentStoreMx_STORE.COMPONENTS.GETTERS.PROP.GET](MAP_COMPONENT_CID, PROPS.CURRENT_BASE_MAP);
            },
            set(value) {
                this.componentStoreMx_mutation(this.componentStoreMx_STORE.COMPONENTS.MUTATIONS.PROP.SET, {
                    cid: MAP_COMPONENT_CID,
                    prop: PROPS.CURRENT_BASE_MAP,
                    value: value
                });
            }
        },
        mapContainerComponentStoreMx_currentBingImagerySet: {
            get() {
                return this[this.componentStoreMx_STORE.COMPONENTS.GETTERS.PROP.GET](MAP_COMPONENT_CID, PROPS.CURRENT_BING_IMAGERY_SET);
            },
            set(value) {
                this.componentStoreMx_mutation(this.componentStoreMx_STORE.COMPONENTS.MUTATIONS.PROP.SET, {
                    cid: MAP_COMPONENT_CID,
                    prop: PROPS.CURRENT_BING_IMAGERY_SET,
                    value: value
                });
            }
        }
    }
};