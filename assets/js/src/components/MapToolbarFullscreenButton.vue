<template>
    <v-tooltip bottom>
        <template #activator="{ on: tooltip }">
            <v-btn
                icon
                v-on="{ ...tooltip }"
                @click="toggleFullScreen"
            >
                <slot name="activator">
                    <v-icon
                        data-test="icon--map-toggle-fullscreen"
                    >
                        {{ icon }}
                    </v-icon>
                </slot>
            </v-btn>
        </template>
        <span>{{ tooltipText }}</span>
    </v-tooltip>
</template>

<script>
import MapFullScreenMx from '../mixins/Controller/MapFullScreenMx';

export default {
    name: 'MapToolbarFullscreenButton',
    mixins: [
        MapFullScreenMx
    ]
};
</script>
