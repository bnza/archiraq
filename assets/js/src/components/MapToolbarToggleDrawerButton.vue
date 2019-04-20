<template>
    <v-tooltip bottom>
        <template #activator="{ on: tooltip }">
            <v-btn
                icon
                v-on="{ ...tooltip }"
                @click="toggleMapLayersDrawerVisibility"
            >
                <slot name="activator">
                    <v-icon>{{ icon }}</v-icon>
                </slot>
            </v-btn>
        </template>
        <span>{{ tooltipText }}</span>
    </v-tooltip>
</template>

<script>
import ComponentsStoreMx from '../mixins/ComponentsStoreMx';
import {CID_THE_MAP_LAYERS_DRAWER} from '../utils/cids';

export default {
    name: 'MapToolbarToggleDrawerButton',
    mixins: [
        ComponentsStoreMx
    ],
    computed: {
        isDrawerVisible() {
            return this.componentsGetComponentProp(CID_THE_MAP_LAYERS_DRAWER , 'visible');
        },
        tooltipText() {
            return this.isDrawerVisible ? 'Hide map layers' : 'Show map layers';
        },
        icon() {
            return this.isDrawerVisible ? 'layers_clear' : 'layers';
        }
    },
    methods: {
        toggleMapLayersDrawerVisibility() {
            this.componentsToggleComponentProp({cid: CID_THE_MAP_LAYERS_DRAWER, prop: 'visible'});
        }
    }
};
</script>

<style scoped>

</style>
