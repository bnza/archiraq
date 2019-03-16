<script>
import MapLayerVectorWfs from './MapLayerVectorWfs';

export default {
    name: 'MapLayerVectorWfsAdminBounds',
    extends: MapLayerVectorWfs,
    computed: {
        visible: {
            get() {
                return !!this.cid && this.cid === this.mapContainerAdminBounds;
            },
            set(value) {
                let currentAdminBoundsLayer;
                if (value) {
                    // set the $store property
                    currentAdminBoundsLayer = this.cid;
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
                this.mapContainerAdminBounds = currentAdminBoundsLayer;
            }
        }
    },
};
</script>
