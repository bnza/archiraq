<template>
    <v-card
        :data-test="DT_THE_MAP_PROPERTIES_DRAWER"
        flat
    >
        <v-navigation-drawer
            floating
            absolute
            :value="visible"
            width="400"
            right=""
            style="min-height: 400px; z-index: 1;"
        />
    </v-card>
</template>

<script>
import {
    CID_THE_MAP_PROPERTIES_DRAWER,
    DT_THE_MAP_PROPERTIES_DRAWER
} from '../utils/constants';
import MapContainerComponentStoreMx from '../../src/mixins/MapContainerComponentStoreMx';

export default {
    name: 'TheMapPropertiesDrawer',
    mixins: [
        MapContainerComponentStoreMx
    ],
    data() {
        return {
            componentStoreMx_cid: CID_THE_MAP_PROPERTIES_DRAWER
        };
    },
    computed: {
        visible: {
            get() {
                return this.componentStoreMx_getStoreProp('visible');
            },
            set(value) {
                this.componentStoreMx_setStoreProp('visible', value);
            }
        },
        DT_THE_MAP_PROPERTIES_DRAWER: () => DT_THE_MAP_PROPERTIES_DRAWER
    },
    created() {
        this.visible = false;
    }
};
</script>

<style scoped>

</style>
