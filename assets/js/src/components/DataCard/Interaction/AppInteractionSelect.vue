<template>
    <vl-interaction-select
        :features.sync="selectedFeatures"
        :condition="selectCondition"
        :toggle-condition="toggleCondition"
    >
        <vl-overlay
            v-if="currentFeature && currentFeature.properties"
            :position="pointOnSurface(currentFeature.geometry)"
            :positioning="positioning"
            :auto-pan="true"
            :auto-pan-animation="{ duration: 300 }"
        >
            <slot :feature="currentFeature" />
        </vl-overlay>
    </vl-interaction-select>
</template>

<script>
import {findPointOnSurface, OVERLAY_POSITIONING} from 'vuelayers/lib/ol-ext';
import { shiftKeyOnly, singleClick } from 'ol/events/condition';
import MapContainerComponentStoreMx from '@/mixins/MapContainerComponentStoreMx';

export default {
    name: 'AppInteractionSelect',
    mixins: [
        MapContainerComponentStoreMx
    ],
    props: {
        layerCid: {
            type: String,
            required: true
        },
        currentFeatureIndex: {
            type: Number,
            default: 0
        }
    },
    data() {
        return {
            selectedFeatures: [],
        };
    },
    computed: {
        positioning() {
            return OVERLAY_POSITIONING.BOTTOM_LEFT;
        },
        currentFeature() {
            return this.selectedFeatures && this.selectedFeatures[this.currentFeatureIndex];
        },
        isCurrentLayer() {
            return this.mapContainerCurrentLayer === this.layerCid;
        },
        visible() {
            return this.componentsGetComponentProp(this.layerCid, 'visible');
        }
    },
    watch: {
        isCurrentLayer: function (flag) {
            this.toggleSelectedFeatures(flag);
        },
        visible: function (flag) {
            this.toggleSelectedFeatures(flag);
        },
        selectedFeatures: function (features) {
            if (this.isCurrentLayer && this.visible) {
                this.componentsSetComponentProp({
                    cid: this.layerCid,
                    prop: 'selectedFeatures',
                    value: features
                });
            }
        }
    },
    created() {
        this.setProp('selectedFeatures', this.selectedFeatures);
    },
    methods: {
        pointOnSurface: findPointOnSurface,
        selectCondition(olMapBrowserEvent)  {
            return this.isCurrentLayer
                && singleClick(olMapBrowserEvent);
        },
        toggleCondition(olMapBrowserEvent)  {
            return this.isCurrentLayer
                && shiftKeyOnly(olMapBrowserEvent);
        },
        toggleSelectedFeatures(flag) {
            if (flag) {
                this.selectedFeatures = this.componentsGetComponentProp(this.layerCid, 'selectedFeatures');
            } else {
                this.selectedFeatures = [];
            }
        }
    },
};
</script>

<style scoped>
    /deep/ .v-card {
        bottom: 12px;
        left: -50px;
        border-radius: 5px;
    }
    /deep/ .v-card:after, .v-card:before {
        top: 100%;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
    }
    /deep/ .v-card:after {
        border-top-color: white;
        border-width: 10px;
        left: 48px;
        margin-left: -10px;
    }
    /deep/ .v-card:before {
        border-top-color: #cccccc;
        border-width: 11px;
        left: 48px;
        margin-left: -11px;
    }
</style>
