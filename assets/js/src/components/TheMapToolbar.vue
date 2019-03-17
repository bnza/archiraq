<template>
    <v-toolbar
        flat
        dense
    >
        <v-toolbar-side-icon
            data-test="the-map-toolbar--side-icon"
            @click.stop="toggleMapLayersDrawerVisibility"
        />
        <v-toolbar-title>Map</v-toolbar-title>
    </v-toolbar>
</template>

<script>
import ComponentsStoreMx from '../mixins/ComponentsStoreMx';
import {TOGGLE_COMPONENT_PROP} from '../store/components/mutations';
import {
    CID_THE_MAP_TOOLBAR as CID,
    CID_THE_MAP_LAYERS_DRAWER
} from '../utils/cids';

export default {
    name: CID,
    mixins: [
        ComponentsStoreMx
    ],
    data() {
        return {
            cid: CID
        };
    },
    methods: {
        toggleMapLayersDrawerVisibility() {
            this[TOGGLE_COMPONENT_PROP]({cid: CID_THE_MAP_LAYERS_DRAWER, prop: 'visible'});
        }
    }
};
</script>

