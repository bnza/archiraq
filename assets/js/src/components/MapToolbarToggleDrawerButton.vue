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
import MapDrawerMx from '../mixins/Controller/MapDrawerMx';

export default {
    name: 'MapToolbarToggleDrawerButton',
    mixins: [
        MapDrawerMx
    ]
};
</script>

<style scoped>

</style>
