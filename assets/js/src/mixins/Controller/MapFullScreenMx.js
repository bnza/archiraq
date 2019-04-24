import {getMapPixelHeight} from '../../utils/utils';
import MapContainerComponentStoreMx from '../../mixins/MapContainerComponentStoreMx';

export default {
    mixins: [
        MapContainerComponentStoreMx
    ],
    computed: {
        isFullScreen() {
            return this.mapContainerHeight !== '500px';
        },
        tooltipText() {
            return this.isFullScreen ? 'Exit fullscreen' : 'Fullscreen';
        },
        icon() {
            return this.isFullScreen ? 'fullscreen' : 'fullscreen_exit';
        }
    },
    methods: {
        toggleFullScreen() {
            this.mapContainerHeight = getMapPixelHeight(!this.isFullScreen);
        }
    }
};
