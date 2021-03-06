import ComponentsStoreMx from './ComponentsStoreMx';
import {
    CID_THE_MAP_CONTAINER,
    WFS_TYPENAME_VW_SITES_RS,
    WFS_TYPENAME_VW_SITES_SURVEY,
    WMTS_TYPENAME_CORONA_FORE,
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
            return this.mapContainerPointerCoords[0];
        },
        mapContainerPointerCoordY() {
            return this.mapContainerPointerCoords[1];
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
        mapContainerWmtsCoronaForeVisible: {
            get() {
                return this.componentsGetComponentProp(WMTS_TYPENAME_CORONA_FORE, 'visible');
            },
            set() {
                this.componentsToggleComponentProp({
                    cid: WMTS_TYPENAME_CORONA_FORE,
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
        mapContainerDynamicEditComponent: {
            get() {
                return this.componentsGetComponentProp(CID_THE_MAP_CONTAINER, 'dynamicEditComponent');
            },
            set(value) {
                this.componentsSetComponentProp({
                    cid: CID_THE_MAP_CONTAINER,
                    prop: 'dynamicEditComponent',
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
        },
        zoomToItemFeature(geom) {
            this.mapContainerCallMethod('zoomToItemGeometry', geom);
            this.$vuetify.goTo('#map');
        },
        zoomToLayerExtent(cid) {
            const extent = this.componentsGetComponentProp(cid, 'extent');
            this.mapContainerCallMethod('fitExtent', [extent]);
            this.$vuetify.goTo('#map');
        },
        mapContainerWmtsMapIsVisible(cid) {
            return this.componentsGetComponentProp(cid, 'visible');
        },
        mapContainerWmtsMapToggleVisible(cid) {
            this.componentsToggleComponentProp({
                cid: cid,
                prop: 'visible'
            });
        },
    }
};
