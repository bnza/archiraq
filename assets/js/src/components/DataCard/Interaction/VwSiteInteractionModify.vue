<template>
    <div>
        <vl-layer-vector>
            <vl-source-vector
                ref="source"
                ident="editedVector"
                :features.sync="features"
            />
            <vl-style-box>
                <vl-style-fill color="rgba(255, 255, 255, 0.2)" />
                <vl-style-stroke
                    color="#ffcc33"
                    :width="2"
                />
            </vl-style-box>
        </vl-layer-vector>
        <vl-interaction-modify
            source="editedVector"
            @modifyend="setGeometryString($event)"
        />
    </div>
</template>



<script>
import GeoJSON from 'ol/format/GeoJSON';
import ComponentsStoreMx from '@/mixins/ComponentsStoreMx';
import {CID_VW_SITE_INTERACTION_MODIFY as CID, CID_VW_SITE_EDIT_DATA_CARD} from '@/utils/cids';
import {featureFromGeometryString} from '@/utils/utils';

const computed = {
    geometryString: {
        get() {
            return this.componentsGetComponentProp(
                CID_VW_SITE_EDIT_DATA_CARD,
                'geometryString'
            );
        },
        set(value) {
            this.componentsSetComponentProp({
                cid: CID_VW_SITE_EDIT_DATA_CARD,
                prop: 'geometryString',
                value
            });
        }
    }
};

const data = () => {
    return {
        cid: CID,
        features: []
    };
};

const methods = {
    setFeatures(geometryString) {
        let features = [];
        if (this.geometryString) {
            features.push(featureFromGeometryString(geometryString));
        }
        this.features = features;
        this.$refs.source.refresh();
        this.$refs.source.scheduleRecreate();
    },
    setStoreInteractionReady(flag) {
        this.componentsSetComponentProp({
            cid: CID_VW_SITE_EDIT_DATA_CARD,
            prop: 'interactionModifyReady',
            value: flag
        });
    },
    setGeometryString(payload) {
        const geometry = payload.features.item(0).getGeometry();
        const geoJson = (new GeoJSON({ featureProjection: 'EPSG:3857' })).writeGeometryObject(geometry, { dataProjection: 'EPSG:4326' });
        geoJson.crs = {'type':'name','properties':{'name':'EPSG:4326'}};
        this.geometryString = JSON.stringify(geoJson);
    }
};

const created = function () {
    const unwatch = this.$watch('geometryString', function (value) {
        this.setFeatures(value);
        unwatch();
    });
    this.setStoreInteractionReady(true);
};

const destroyed = function () {
    this.setStoreInteractionReady(false);
    this.geometryString = '';
};


export default {
    name: 'VwSiteInteractionModify',
    mixins: [ComponentsStoreMx],
    data,
    computed,
    created,
    destroyed,
    methods
};
</script>

<style scoped>

</style>
