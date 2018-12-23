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
        currentBaseMap: {
            get() {
                return this[this.STORE.COMPONENTS.GETTERS.PROP.GET](MAP_COMPONENT_CID, PROPS.CURRENT_BASE_MAP)
            },
            set(value) {
                this.mutation(this.STORE.COMPONENTS.MUTATIONS.PROP.SET, {
                    cid: MAP_COMPONENT_CID,
                    prop: PROPS.CURRENT_BASE_MAP,
                    value: value
                })
            }
        },
        currentBingImagerySet: {
            get() {
                return this[this.STORE.COMPONENTS.GETTERS.PROP.GET](MAP_COMPONENT_CID, PROPS.CURRENT_BING_IMAGERY_SET)
            },
            set(value) {
                this.mutation(this.STORE.COMPONENTS.MUTATIONS.PROP.SET, {
                    cid: MAP_COMPONENT_CID,
                    prop: PROPS.CURRENT_BING_IMAGERY_SET,
                    value: value
                })
            }
        }
    }
}