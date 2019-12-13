<template>
    <v-card
        id="map"
        flat
    >
        <vl-map
            ref="map"
            data-test="the-map-container"
            :load-tiles-while-animating="true"
            :load-tiles-while-interacting="true"
            data-projection="EPSG:4326"
            :style="'height: '+mapContainerHeight"
            @pointermove="storePointerCoords"
        >
            <vl-view
                ref="view"
                :max-zoom="19"
                :min-zoom="6"
                :zoom.sync="zoom"
                :center.sync="center"
                :rotation.sync="rotation"
            />
            <vl-layer-tile
                id="bingmaps"
                data-test="base-map-tile-bingmaps"
                :visible="'bing'===mapContainerBaseMap"
            >
                <vl-source-bingmaps
                    :api-key="bingApiKey"
                    :imagery-set="mapContainerBingImagerySet"
                />
            </vl-layer-tile>
            <vl-layer-tile
                id="osm"
                data-test="base-map-tile-osm"
                :visible="'osm'===mapContainerBaseMap"
            >
                <vl-source-osm />
            </vl-layer-tile>
            <vl-layer-tile
                id="esri"
                data-test="base-map-tile-esri"
                :visible="'esri'===mapContainerBaseMap"
            >
                <vl-source-esri />
            </vl-layer-tile>
            <vl-layer-tile
                v-for="layer in WMTS_TYPENAME_SURVEY_TOPOS"
                :key="layer.typename"
                :visible="mapContainerWmtsMapIsVisible(layer.typename)"
            >
                <map-layer-wmts
                    :cid-p="layer.typename"
                    :typename="layer.typename"
                    style-name="raster"
                />
            </vl-layer-tile>
            <map-layer-vector-wfs
                v-for="layer in WFS_TYPENAME_SURVEY_AREAS"
                :key="layer.typename"
                :cid-p="layer.typename"
                :visible-p="false"
                :typename="layer.typename"
                geom-field="the_geom"
            />
            <vl-layer-tile
                :visible="mapContainerWmtsMapIsVisible(WMTS_TYPENAME_US_ARMY_TOPO_1)"
            >
                <map-layer-wmts
                    :cid-p="WMTS_TYPENAME_US_ARMY_TOPO_1"
                    :typename="WMTS_TYPENAME_US_ARMY_TOPO_1"
                    style-name="raster"
                />
            </vl-layer-tile>
            <vl-layer-tile
                :visible="mapContainerWmtsMapIsVisible(WMTS_TYPENAME_US_ARMY_TOPO_2)"
            >
                <map-layer-wmts
                    :cid-p="WMTS_TYPENAME_US_ARMY_TOPO_2"
                    :typename="WMTS_TYPENAME_US_ARMY_TOPO_2"
                    style-name="raster"
                />
            </vl-layer-tile>
            <vl-layer-tile
                v-for="layer in WMTS_TYPENAME_CORONA"
                :key="layer.typename"
                :visible="mapContainerWmtsMapIsVisible(layer.typename)"
            >
                <map-layer-wmts
                    :cid-p="layer.typename"
                    :typename="layer.typename"
                    style-name="raster"
                />
            </vl-layer-tile>
            <map-layer-group-admin-bounds />
            <map-layer-vector-wfs-vw-sites
                ref="layerVwSite"
                :cid-p="CID_MAP_LAYER_VECTOR_WFS_VW_SITES_SURVEY"
                :base-typename="WFS_TYPENAME_VW_SITES_SURVEY"
                feature-color="#EF6C00"
                :zoom="zoom"
            />
            <map-layer-vector-wfs-vw-sites
                ref="layerVwSiteRs"
                :cid-p="CID_MAP_LAYER_VECTOR_WFS_VW_SITES_RS"
                :base-typename="WFS_TYPENAME_VW_SITES_RS"
                feature-color="#8E24AA"
                :zoom="zoom"
            />
            <component
                :is="mapContainerDynamicEditComponent"
                v-if="mapContainerDynamicEditComponent"
                name="editVectorLayer"
            />
            <the-map-layers-drawer />
        </vl-map>
    </v-card>
</template>

<script>
import {bind, debounce} from 'lodash';
import {getMapPixelHeight} from '@/utils/utils';
import ComponentStoreVisibleMx from '@/mixins/ComponentStoreVisibleMx';
import MapContainerComponentStoreMx from '@/mixins/MapContainerComponentStoreMx';
import TheMapLayersDrawer from './TheMapLayersDrawer';
import MapLayerWmts from '@/components/MapLayerWmts';
import MapLayerVectorWfs from '@/components/MapLayerVectorWfs';
import MapLayerGroupAdminBounds from './MapLayerGroupAdminBounds';
import MapLayerVectorWfsVwSites from './MapLayerVectorWfsVwSites';
import VlSourceEsri from './VlSourceEsri';

import {
    CID_THE_MAP_CONTAINER as CID,
    CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2,
    WFS_TYPENAME_VW_SITES_SURVEY,
    WFS_TYPENAME_VW_SITES_RS,
    WMTS_TYPENAME_CORONA,
    WMTS_TYPENAME_CORONA_FORE,
    WMTS_TYPENAME_CORONA_AFT,
    WMTS_TYPENAME_US_ARMY_TOPO_1,
    WMTS_TYPENAME_US_ARMY_TOPO_2,
    WMTS_TYPENAME_SURVEY_TOPOS,
    WFS_TYPENAME_SURVEY_AREAS
} from '../utils/cids';
import {callObjectMethod} from '../utils/utils';

export const HEIGHT = '500px';
const center = [47.44, 33.37];

export default {
    name: CID,
    components: {
        TheMapLayersDrawer,
        MapLayerVectorWfsVwSites,
        MapLayerWmts,
        MapLayerGroupAdminBounds,
        VlSourceEsri,
        MapLayerVectorWfs,
        VwSiteInteractionModify: () => import(
            /* webpackChunkName: "VwSiteInteractionModify" */
            '@/components/DataCard/Interaction/VwSiteInteractionModify'
        ),
    },
    mixins: [
        ComponentStoreVisibleMx,
        MapContainerComponentStoreMx
    ],
    data() {
        return {
            cid: CID,
            zoom: 6,
            center: [0, 0],
            rotation: 0,
        };
    },
    computed: {
        WFS_TYPENAME_VW_SITES_SURVEY: () => WFS_TYPENAME_VW_SITES_SURVEY,
        WFS_TYPENAME_VW_SITES_RS: () => WFS_TYPENAME_VW_SITES_RS,
        WMTS_TYPENAME_CORONA: () => WMTS_TYPENAME_CORONA,
        WMTS_TYPENAME_CORONA_FORE: () => WMTS_TYPENAME_CORONA_FORE,
        WMTS_TYPENAME_CORONA_AFT: () => WMTS_TYPENAME_CORONA_AFT,
        WMTS_TYPENAME_US_ARMY_TOPO_1: () => WMTS_TYPENAME_US_ARMY_TOPO_1,
        WMTS_TYPENAME_US_ARMY_TOPO_2: () => WMTS_TYPENAME_US_ARMY_TOPO_2,
        WFS_TYPENAME_SURVEY_AREAS: () => WFS_TYPENAME_SURVEY_AREAS,
        WMTS_TYPENAME_SURVEY_TOPOS: () => WMTS_TYPENAME_SURVEY_TOPOS,
        bingApiKey() {
            return this.$store.state.bingApiKey;
        }
    },
    watch: {
        mapContainerCallee: {
            handler: function (callee) {
                callObjectMethod(this, callee);
                this.mapContainerCallee = null;
            }
        },
        mapContainerHeight: {
            handler: function () {
                if (this.$refs.map.$map) {
                    const map = this.$refs.map;
                    map.render().then((e) => {
                        map.$map.updateSize();
                    });
                }
            }
        }
    },
    created() {
        this.resizeMap(true);
        this.mapContainerAdminBounds = CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2;
        this.mapContainerCurrentLayer = WFS_TYPENAME_VW_SITES_SURVEY;
        this.mapContainerPointerCoords = center;
        this.mapContainerBaseMap = 'bing';
        this.mapContainerBingImagerySet = 'AerialWithLabels';
        this.mapContainerCallee = null;
        this.mapContainerDynamicEditComponent = '';
    },
    mounted() {
        window.addEventListener('resize', this.resizeMap);
        // get vl-map by ref="map" and await ol.Map creation
        this.$refs.map.$createPromise.then(() => {
            this.center = center;
            if (process.env.NODE_ENV !== 'production') {
                window.map = this.$refs.map.$map;
            }
        });
    },
    destroyed() {
        window.removeEventListener('resize', this.resizeMap);
    },
    methods: {
        isFullScreen() {
            return this.mapContainerHeight === HEIGHT;
        },
        storePointerCoords({pixel}) {
            const storeCoords = debounce(bind(function (pixel) {
                this.mapContainerPointerCoords =  this.$refs.map.getCoordinateFromPixel(pixel);
            }, this), 100);
            storeCoords(pixel);
        },
        zoomToItemGeometry(geom) {
            this.$refs.view.fit(geom);
        },
        fitExtent(extent) {
            this.$refs.view.fit(extent);
        },
        resizeMap(force = false) {
            if (force || this.isFullScreen()) {
                this.mapContainerHeight = getMapPixelHeight(true);
            }
        }
    },
};
</script>

<style scoped>

</style>
