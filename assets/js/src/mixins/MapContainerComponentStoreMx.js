import ComponentsStoreMx from './ComponentsStoreMx';
import {
    CID_THE_MAP_CONTAINER,
    CID_MAP_LAYER_VECTOR_WFS_VW_SITES,
    WFS_TYPENAME_VW_SITES_RS,
    WFS_TYPENAME_VW_SITES_SURVEY
} from '../utils/cids';

export default {
    mixins: [
        ComponentsStoreMx
    ],
    computed: {
        mapContainerHeight: {
            get() {
                return this.componentsGetComponentProp(CID_THE_MAP_CONTAINER, 'height');
            },
            set(value) {
                this.componentsSetComponentProp({
                    cid: CID_THE_MAP_CONTAINER,
                    prop: 'height',
                    value: value
                });
            }
        },
        mapContainerCurrentLayer: {
            get() {
                return this.componentsGetComponentProp(CID_THE_MAP_CONTAINER, 'currentLayer');
            },
            set(value) {
                this.componentsSetComponentProp({
                    cid: CID_THE_MAP_CONTAINER,
                    prop: 'currentLayer',
                    value: value
                });
            }
        },
        mapContainerBaseMap: {
            get() {
                return this.componentsGetComponentProp(CID_THE_MAP_CONTAINER, 'baseMap');
            },
            set(value) {
                this.componentsSetComponentProp({
                    cid: CID_THE_MAP_CONTAINER,
                    prop: 'baseMap',
                    value: value
                });
            }
        },
        mapContainerAdminBounds: {
            get() {
                return this.componentsGetComponentProp(CID_THE_MAP_CONTAINER, 'adminBounds');
            },
            set(value) {
                this.componentsSetComponentProp({
                    cid: CID_THE_MAP_CONTAINER,
                    prop: 'adminBounds',
                    value: value
                });
            }
        },
        mapContainerBingImagerySet: {
            get() {
                return this.componentsGetComponentProp(CID_THE_MAP_CONTAINER, 'bingImagerySet');
            },
            set(value) {
                this.componentsSetComponentProp({
                    cid: CID_THE_MAP_CONTAINER,
                    prop: 'bingImagerySet',
                    value: value
                });
            }
        },
        mapContainerPointerCoords: {
            get() {
                return this.componentsGetComponentProp(CID_THE_MAP_CONTAINER, 'pointerCoords');
            },
            set(value) {
                this.componentsSetComponentProp({
                    cid: CID_THE_MAP_CONTAINER,
                    prop: 'pointerCoords',
                    value: value
                });
            }
        },
        mapContainerPointerCoordX() {
            return this.componentsGetComponentProp(CID_THE_MAP_CONTAINER, 'pointerCoords')[0];
        },
        mapContainerPointerCoordY() {
            return this.componentsGetComponentProp(CID_THE_MAP_CONTAINER, 'pointerCoords')[1];
        },
        mapContainerVwSitesVisible: {
            get() {
                return this.componentsGetComponentProp(CID_MAP_LAYER_VECTOR_WFS_VW_SITES, 'visible');
            },
            set() {
                this.componentsToggleComponentProp({
                    cid: CID_MAP_LAYER_VECTOR_WFS_VW_SITES,
                    prop: 'visible'
                });
            }
        },
        mapContainerVwSitesSurveyVisible: {
            get() {
                return this.componentsGetComponentProp(WFS_TYPENAME_VW_SITES_SURVEY, 'visible');
            },
            set() {
                this.componentsToggleComponentProp({
                    cid: WFS_TYPENAME_VW_SITES_SURVEY,
                    prop: 'visible'
                });
            }
        },
        mapContainerVwSitesRemoteSensingVisible: {
            get() {
                return this.componentsGetComponentProp(WFS_TYPENAME_VW_SITES_RS, 'visible');
            },
            set() {
                this.componentsToggleComponentProp({
                    cid: WFS_TYPENAME_VW_SITES_RS,
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
