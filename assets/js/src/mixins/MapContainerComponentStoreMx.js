import ComponentsStoreMx from './ComponentsStoreMx';
import {GET_COMPONENT_PROP} from '../store/components/getters';
import {SET_COMPONENT_PROP, TOGGLE_COMPONENT_PROP} from '../store/components/mutations';

const CID_THE_MAP_CONTAINER = 'TheMapContainer';
const CID_MAP_LAYER_VECTOR_WFS_VW_SITES = 'MapLayerVectorWfsVwSites';

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
    },
};
