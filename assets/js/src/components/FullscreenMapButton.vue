<template>
    <v-tooltip bottom>
        <template #activator="{ on: tooltip }">
            <v-btn
                color="primary"
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
    let heigth = 500;
    if (isFullScreen) {
        const mainToolbarHeight = 64;
        const mapToolbarHeight = 48;
        const mapFooterHeight = 36;
        const mainFooterHeight = 36;

        heigth = window.innerHeight - (mainToolbarHeight + mapToolbarHeight + mapFooterHeight + mainFooterHeight);
    }
    return heigth;
};

export default {
    name: 'FullscreenMapButton',
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
