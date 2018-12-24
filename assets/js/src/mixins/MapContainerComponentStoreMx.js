import ComponentsStoreMx from './ComponentsStoreMx'

const MAP_COMPONENT_CID = 'the-map-container'
const PROPS = {
    CURRENT_BASE_MAP: 'currentBaseMap',
    CURRENT_BING_IMAGERY_SET: 'currentBingImagerySet'
}

export default {
    mixins: [
        ComponentsStoreMx
    ],
    computed: {
        $_MapContainerComponentStoreMx_currentBaseMap: {
            get() {
                return this[this.$_ComponentStoreMx_STORE.COMPONENTS.GETTERS.PROP.GET](MAP_COMPONENT_CID, PROPS.CURRENT_BASE_MAP)
            },
            set(value) {
                this.$_ComponentStoreMx_mutation(this.$_ComponentStoreMx_STORE.COMPONENTS.MUTATIONS.PROP.SET, {
                    cid: MAP_COMPONENT_CID,
                    prop: PROPS.CURRENT_BASE_MAP,
                    value: value
                })
            }
        },
        $_MapContainerComponentStoreMx_currentBingImagerySet: {
            get() {
                return this[this.$_ComponentStoreMx_STORE.COMPONENTS.GETTERS.PROP.GET](MAP_COMPONENT_CID, PROPS.CURRENT_BING_IMAGERY_SET)
            },
            set(value) {
                this.$_ComponentStoreMx_mutation(this.$_ComponentStoreMx_STORE.COMPONENTS.MUTATIONS.PROP.SET, {
                    cid: MAP_COMPONENT_CID,
                    prop: PROPS.CURRENT_BING_IMAGERY_SET,
                    value: value
                })
            }
        }
    }
}