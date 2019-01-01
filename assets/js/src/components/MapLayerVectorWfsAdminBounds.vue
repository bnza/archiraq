<script>
import MapLayerVectorWfs from './MapLayerVectorWfs';

export default {
    name: 'MapLayerVectorWfsAdminBounds',
    extends: MapLayerVectorWfs,
    computed: {
        visible: {
            get() {
                return this.componentStoreMx_cid === this.mapContainerComponentStoreMx_currentAdminBoundsLayer;
            },
            set(value) {
                let currentAdminBoundsLayer;
                if (value) {
                    // set the $store property
                    currentAdminBoundsLayer = this.componentStoreMx_cid;
                } else {
                    try {
                        if (this.visible) {
                            // remove $store property
                            currentAdminBoundsLayer = '';
                        } else {
                            return;
                        }
                    } catch (e) {
                        // the $store property is not set so set it to default
                        currentAdminBoundsLayer = '';
                    }
                }
                this.mapContainerComponentStoreMx_currentAdminBoundsLayer = currentAdminBoundsLayer;
            }
        }
    },

};
</script>