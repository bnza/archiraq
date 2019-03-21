<template>
    <v-list-tile
        :class="{ current: isCurrentLayer }"
        @click="setCurrentLayer"
    >
        <v-list-tile-action>
            <slot name="visibility" />
        </v-list-tile-action>
        <v-list-tile-content>
            <v-list-tile-title>{{ title }}</v-list-tile-title>
        </v-list-tile-content>
        <v-list-tile-action v-if="$slots.action">
            <slot name="action" />
        </v-list-tile-action>
    </v-list-tile>
</template>

<script>
import MapContainerComponentStoreMx from '../../src/mixins/MapContainerComponentStoreMx';

export default {
    name: 'MapLegendLayerListTile',
    mixins: [
        MapContainerComponentStoreMx
    ],
    props: {
        layerCid: {
            type: String,
            default: ''
        },
        title: {
            type: String,
            required: true
        }
    },
    computed: {
        isCurrentLayer() {
            return !!this.layerCid
          && this.mapContainerCurrentLayer === this.layerCid;
        }
    },
    methods: {
        setCurrentLayer() {
            if (this.layerCid !== '') {
                this.mapContainerCurrentLayer = this.layerCid;
            }
        }
    }
};
</script>

<style lang="scss" scoped>
    .current {
        background-color: rgba(#fdd835, .25);
    }
</style>
