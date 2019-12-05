import ComponentsStoreMx from './ComponentsStoreMx';
import {
    CID_THE_MAP_CONTAINER,
    WFS_TYPENAME_VW_SITES_RS,
    WFS_TYPENAME_VW_SITES_SURVEY,
    WMTS_TYPENAME_CORONA_AFT,
    WMTS_TYPENAME_CORONA_FORE,
    WMTS_TYPENAME_SURVEY_TOPO_01_AKKAD,
    WMTS_TYPENAME_SURVEY_TOPO_02_LBB,
    WMTS_TYPENAME_SURVEY_TOPO_03_HOC,
    WMTS_TYPENAME_SURVEY_TOPO_07_UR,
    WMTS_TYPENAME_SURVEY_TOPO_10_HAMMAR,
    WMTS_TYPENAME_SURVEY_TOPO_11_MANDALI,
    WMTS_TYPENAME_SURVEY_TOPO_12_MYINAB,
    WMTS_TYPENAME_SURVEY_TOPO_13_SWIRAN,
    WMTS_TYPENAME_SURVEY_TOPO_14_HORMUZ
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
        mapContainerWmtsCoronaAfVisible: {
            get() {
                return this.componentsGetComponentProp(WMTS_TYPENAME_CORONA_AFT, 'visible');
            },
            set() {
                this.componentsToggleComponentProp({
                    cid: WMTS_TYPENAME_CORONA_AFT,
                    prop: 'visible'
                });
            }
        },
        mapContainerWmtsCoronaDaVisible: {
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
        mapContainerWmtsTopo01Visible: {
            get() {
                return this.componentsGetComponentProp(WMTS_TYPENAME_SURVEY_TOPO_01_AKKAD, 'visible');
            },
            set() {
                this.componentsToggleComponentProp({
                    cid: WMTS_TYPENAME_SURVEY_TOPO_01_AKKAD,
                    prop: 'visible'
                });
            }
        },
        mapContainerWmtsTopo02Visible: {
            get() {
                return this.componentsGetComponentProp(WMTS_TYPENAME_SURVEY_TOPO_02_LBB, 'visible');
            },
            set() {
                this.componentsToggleComponentProp({
                    cid: WMTS_TYPENAME_SURVEY_TOPO_02_LBB,
                    prop: 'visible'
                });
            }
        },
        mapContainerWmtsTopo03Visible: {
            get() {
                return this.componentsGetComponentProp(WMTS_TYPENAME_SURVEY_TOPO_03_HOC, 'visible');
            },
            set() {
                this.componentsToggleComponentProp({
                    cid: WMTS_TYPENAME_SURVEY_TOPO_03_HOC,
                    prop: 'visible'
                });
            }
        },
        mapContainerWmtsTopo07Visible: {
            get() {
                return this.componentsGetComponentProp(WMTS_TYPENAME_SURVEY_TOPO_07_UR, 'visible');
            },
            set() {
                this.componentsToggleComponentProp({
                    cid: WMTS_TYPENAME_SURVEY_TOPO_07_UR,
                    prop: 'visible'
                });
            }
        },
        mapContainerWmtsTopo10Visible: {
            get() {
                return this.componentsGetComponentProp(WMTS_TYPENAME_SURVEY_TOPO_10_HAMMAR, 'visible');
            },
            set() {
                this.componentsToggleComponentProp({
                    cid: WMTS_TYPENAME_SURVEY_TOPO_10_HAMMAR,
                    prop: 'visible'
                });
            }
        },
        mapContainerWmtsTopo11Visible: {
            get() {
                return this.componentsGetComponentProp(WMTS_TYPENAME_SURVEY_TOPO_11_MANDALI, 'visible');
            },
            set() {
                this.componentsToggleComponentProp({
                    cid: WMTS_TYPENAME_SURVEY_TOPO_11_MANDALI,
                    prop: 'visible'
                });
            }
        },
        mapContainerWmtsTopo12Visible: {
            get() {
                return this.componentsGetComponentProp(WMTS_TYPENAME_SURVEY_TOPO_12_MYINAB, 'visible');
            },
            set() {
                this.componentsToggleComponentProp({
                    cid: WMTS_TYPENAME_SURVEY_TOPO_12_MYINAB,
                    prop: 'visible'
                });
            }
        },
        mapContainerWmtsTopo13Visible: {
            get() {
                return this.componentsGetComponentProp(WMTS_TYPENAME_SURVEY_TOPO_13_SWIRAN, 'visible');
            },
            set() {
                this.componentsToggleComponentProp({
                    cid: WMTS_TYPENAME_SURVEY_TOPO_13_SWIRAN,
                    prop: 'visible'
                });
            }
        },
        mapContainerWmtsTopo14Visible: {
            get() {
                return this.componentsGetComponentProp(WMTS_TYPENAME_SURVEY_TOPO_14_HORMUZ, 'visible');
            },
            set() {
                this.componentsToggleComponentProp({
                    cid: WMTS_TYPENAME_SURVEY_TOPO_14_HORMUZ,
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
        }
    }
};
