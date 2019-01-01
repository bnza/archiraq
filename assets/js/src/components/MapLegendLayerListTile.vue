<template>
    <v-list-tile
        :class="{ current: isCurrentLayer }"
        @click="setCurrentLayer"
    >
        <v-list-tile-action>
            <v-list-tile-action>
                <slot name="visibility" />
            </v-list-tile-action>
        </v-list-tile-action>
        <v-list-tile-content>
            <v-list-tile-title>{{ title }}</v-list-tile-title>
        </v-list-tile-content>
        <v-list-tile-action v-if="$slots.action">
            <v-menu offset-y>
                <v-tooltip
                    slot="activator"
                    bottom
                >
                    <v-btn
                        slot="activator"
                        color="primary"
                        icon
                        flat
                    >
                        <v-icon>more_vert</v-icon>
                    </v-btn>
                    <span>Settings</span>
                </v-tooltip>
                <slot name="action" />
            </v-menu>
        </v-list-tile-action>
    </v-list-tile>
</template>

<script>
import MapContainerComponentStoreMx from '../../src/mixins/MapContainerComponentStoreMx';

export default {
    name: 'MapLayerListTile',
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
          && this.mapContainerComponentStoreMx_currentLayer === this.layerCid;
        }
    },
    methods: {
        setCurrentLayer() {
            if (this.layerCid !== '') {
                this.mapContainerComponentStoreMx_currentLayer = this.layerCid;
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