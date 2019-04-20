<template>
    <v-tooltip bottom>
        <template #activator="{ on: tooltip }">
            <v-btn
                icon
                v-on="{ ...tooltip }"
                @click="toggleFullScreen"
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
import MapContainerComponentStoreMx from '../mixins/MapContainerComponentStoreMx';

const getPixelMapHeight = (isFullScreen) => {
    let height = 500;
    if (isFullScreen) {
        const mainToolbarHeight = 64;
        const mainFooterHeight = 36;

        height = window.innerHeight - (mainToolbarHeight + mainFooterHeight);
    }
    return height;
};

export default {
    name: 'MapToolbarFullscreenButton',
    mixins: [
        MapContainerComponentStoreMx
    ],
    computed: {
        isFullScreen() {
            return this.mapContainerHeight !== '500px';
        },
        tooltipText() {
            return this.isFullScreen ? 'Exit fullscreen' : 'Open Fullscreen';
        },
        icon() {
            return this.isFullScreen ? 'fullscreen' : 'fullscreen_exit';
        }
    },
    methods: {
        toggleFullScreen() {
            this.mapContainerHeight = getPixelMapHeight(!this.isFullScreen) + 'px';
        }
    }
};
</script>

<style scoped>

</style>
