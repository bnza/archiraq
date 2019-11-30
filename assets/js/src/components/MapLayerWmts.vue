<template>
    <vl-source-wmts
        :url="url"
        format="image/png"
        :layer-name="layerName"
        matrix-set="EPSG:900913"
        style-name="default"
    />
</template>

<script>
import VlSourceWmts from '@/components/VlSourceWmts';
import ComponentsStoreMx from '@/mixins/ComponentsStoreMx';
export default {
    name: 'MapLayerWmts',
    components: {
        VlSourceWmts
    },
    mixins: [
        ComponentsStoreMx
    ],
    props: {
        typename: {
            type: String,
            required: true,
        }
    },
    computed: {
        geoserverBaseUrl() {
            return this.$store.state.geoserver.baseUrl;
        },
        url() {
            /**
             * e.g. http://localhost:8080/geoserver/gwc/service/wmts
             */
            return this.geoserverBaseUrl+'gwc/service/wmts';
        },
        layerName() {
            return `archiraq:${this.typename}`;
        }
    },
    created() {
        this.setProp('visible', false);
    }
};
</script>

<style scoped>

</style>
