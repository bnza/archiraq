<template>
    <v-layout
        wrap
        align-center
    >
        <v-flex
            xs12
            sm6
            d-flex
        >
            <v-select
                v-model="mapContainerBingImagerySet"
                :items="imagerySets"
                item-text="text"
                item-value="value"
                label="Imagery Set"
            >
            </v-select>
        </v-flex>
    </v-layout>
</template>

<script>
import MapContainerComponentStoreMx from '../../src/mixins/MapContainerComponentStoreMx';

export const CID = 'BingBaseMapSettingsDialog';
export default {
    name: CID,
    mixins: [
        MapContainerComponentStoreMx
    ],
    data() {
        return {
            imagerySets: [
                {
                    text: 'Aerial',
                    value: 'Aerial'
                },
                {
                    text: 'Aerial with labels',
                    value: 'AerialWithLabels'
                },
                {
                    text: 'Road (dynamic)',
                    value: 'RoadOnDemand'
                },
                {
                    text: 'Road (static)',
                    value: 'Road'
                }
            ]
        };
    }
};
</script>
