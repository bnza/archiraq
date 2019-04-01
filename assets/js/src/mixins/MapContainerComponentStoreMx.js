import ComponentsStoreMx from './ComponentsStoreMx';
import {GET_COMPONENT_PROP} from '../store/components/getters';
import {SET_COMPONENT_PROP, TOGGLE_COMPONENT_PROP} from '../store/components/mutations';
import {
    CID_THE_MAP_CONTAINER,
    CID_MAP_LAYER_VECTOR_WFS_VW_SITES
} from '../utils/cids';

export default {
    mixins: [
        ComponentsStoreMx
    ],
    computed: {
        mapContainerHeight: {
            get() {
                return this[GET_COMPONENT_PROP](CID_THE_MAP_CONTAINER, 'height');
            },
            set(value) {
                this[SET_COMPONENT_PROP]({
                    cid: CID_THE_MAP_CONTAINER,
                    prop: 'height',
                    value: value
                });
            }
        },
        mapContainerCurrentLayer: {
            get() {
                return this[GET_COMPONENT_PROP](CID_THE_MAP_CONTAINER, 'currentLayer');
            },
            set(value) {
                this[SET_COMPONENT_PROP]({
                    cid: CID_THE_MAP_CONTAINER,
                    prop: 'currentLayer',
                    value: value
                });
            }
        },
        mapContainerBaseMap: {
            get() {
                return this[GET_COMPONENT_PROP](CID_THE_MAP_CONTAINER, 'baseMap');
            },
            set(value) {
                this[SET_COMPONENT_PROP]({
                    cid: CID_THE_MAP_CONTAINER,
                    prop: 'baseMap',
                    value: value
                });
            }
        },
        mapContainerAdminBounds: {
            get() {
                return this[GET_COMPONENT_PROP](CID_THE_MAP_CONTAINER, 'adminBounds');
            },
            set(value) {
                this[SET_COMPONENT_PROP]({
                    cid: CID_THE_MAP_CONTAINER,
                    prop: 'adminBounds',
                    value: value
                });
            }
        },
        mapContainerBingImagerySet: {
            get() {
                return this[GET_COMPONENT_PROP](CID_THE_MAP_CONTAINER, 'bingImagerySet');
            },
            set(value) {
                this[SET_COMPONENT_PROP]({
                    cid: CID_THE_MAP_CONTAINER,
                    prop: 'bingImagerySet',
                    value: value
                });
            }
        },
        mapContainerPointerCoords: {
            get() {
                return this[GET_COMPONENT_PROP](CID_THE_MAP_CONTAINER, 'pointerCoords');
            },
            set(value) {
                this[SET_COMPONENT_PROP]({
                    cid: CID_THE_MAP_CONTAINER,
                    prop: 'pointerCoords',
                    value: value
                });
            }
        },
        mapContainerPointerCoordX() {
            return this[GET_COMPONENT_PROP](CID_THE_MAP_CONTAINER, 'pointerCoords')[0];
        },
        mapContainerPointerCoordY() {
            return this[GET_COMPONENT_PROP](CID_THE_MAP_CONTAINER, 'pointerCoords')[1];
        },
        mapContainerVwSitesVisible: {
            get() {
                return this[GET_COMPONENT_PROP](CID_MAP_LAYER_VECTOR_WFS_VW_SITES, 'visible');
            },
            set() {
                this[TOGGLE_COMPONENT_PROP]({
                    cid: CID_MAP_LAYER_VECTOR_WFS_VW_SITES,
                    prop: 'visible'
                });
            }
        },
        mapContainerCallee: {
            get() {
                return this.componentsGetComponentProp(CID_THE_MAP_CONTAINER, 'callee');
            },
            set(value) {
                this.componentsSetComponentProp({
                    cid: CID_THE_MAP_CONTAINER,
                    prop: 'callee',
                    value: value
                });
            }
        },
    },
    methods: {
        /**
         * Set the "callee" store value
         * @param {string} method
         * @param args
         */
        mapContainerCallMethod(method, args) {
            this.mapContainerCallee = {
                method: method,
                args: args
            };
        }
    }
};
