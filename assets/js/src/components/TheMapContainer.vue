<template>
    <v-card flat>
        <v-toolbar
                flat
                dense
        >
            <v-toolbar-side-icon
                    @click.stop="$_ComponentStoreMx_mutation($_ComponentStoreMx_STORE.COMPONENTS.MUTATIONS.PROP.TOGGLE,{cid: 'the-map-layers-drawer', prop: 'visible'})"/>
            <v-toolbar-title>Title</v-toolbar-title>
        </v-toolbar>

        <vl-map
                :load-tiles-while-animating="true"
                :load-tiles-while-interacting="true"
                data-projection="EPSG:4326"
                style="height: 400px"
        >
            <vl-view :zoom.sync="zoom" :center.sync="center" :rotation.sync="rotation" projection="EPSG:4326"/>
            <vl-layer-tile
                    :visible="'bing'===$_MapContainerComponentStoreMx_currentBaseMap"
                    id="bingmaps"
            >
                <vl-source-bingmaps :api-key="apiKey" :imagery-set="$_MapContainerComponentStoreMx_currentBingImagerySet"/>
            </vl-layer-tile>
            <vl-layer-tile
                    :visible="'osm'===$_MapContainerComponentStoreMx_currentBaseMap"
                    id="osm"
            >
                <vl-source-osm/>
            </vl-layer-tile>
            <the-map-layers-drawer
                    cid-p="the-map-layers-drawer"
            />
        </vl-map>
    </v-card>
</template>

<script>
    import TheMapLayersDrawer from './TheMapLayersDrawer'
    import MapContainerComponentStoreMx from '../../src/mixins/MapContainerComponentStoreMx'

    export default {
        name: "TheMapContainer",
        components: {
            TheMapLayersDrawer
        },
        mixins: [
            MapContainerComponentStoreMx
        ],
        data() {
            return {
                zoom: 6,
                center: [0,0],
                rotation: 0,
                apiKey: this.$store.state.bingApiKey,
            }
        },
        created() {
            this.$_MapContainerComponentStoreMx_currentBaseMap = this.$store.state.default.baseMap
            this.$_MapContainerComponentStoreMx_currentBingImagerySet =  this.$store.state.default.bingImagerySet
        },
    }
</script>

<style scoped>
    .test-size {
        border: 1px #1a237e;
    }
</style>