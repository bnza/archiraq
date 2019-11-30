<script>
import VlSourceWmts from 'vuelayers/src/component/wmts-source/source';
import {hasView} from 'vuelayers/lib/util/assert';
import {createExtentFromProjection, getExtentCorner} from 'vuelayers/lib/ol-ext/extent';
import {resolutionsFromExtent} from 'vuelayers/lib/ol-ext/tile-grid';
import {EXTENT_CORNER} from 'vuelayers/lib/ol-ext/consts';
import WMTSTileGrid from 'ol/tilegrid/WMTS';
import {range} from 'vuelayers/lib/util/minilo';

export default {
    name: 'VlSourceWmts',
    extends: VlSourceWmts,
    methods: {
        /**
         * @return {WMTS}
         * @protected
         */
        createTileGrid () {
            hasView(this);
            const extent = createExtentFromProjection(this.$view.getProjection());
            const resolutions = this.resolutions ? this.resolutions : resolutionsFromExtent(extent, this.maxZoom, this.tileSize);
            const origin = this.origin ? this.origin : getExtentCorner(extent, EXTENT_CORNER.TOP_LEFT);
            const matrixIds = Array.from(range(this.minZoom, resolutions.length)).map((z) => `EPSG:900913:${z}`);

            return new WMTSTileGrid({
                extent: extent,
                origin: origin,
                resolutions: resolutions,
                tileSize: this.tileSize,
                minZoom: this.minZoom,
                matrixIds: matrixIds
            });
        },
    }
};
</script>
