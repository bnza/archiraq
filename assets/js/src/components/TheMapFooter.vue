<template>
    <v-footer
        color="gray"
    >
        <v-layout
            row
            align-center
            justify-space-between
            fill-height
        >
            <v-flex xs8>
                {{mapContainerCurrentLayer}}
            </v-flex>
            <v-flex xs4>
                {{mapContainerPointerCoordX.toFixed(6)}},{{mapContainerPointerCoordY.toFixed(6)}}
            </v-flex>
        </v-layout>
    </v-footer>
</template>

<script>
import MapContainerComponentStoreMx from '../mixins/MapContainerComponentStoreMx';
import {CID_THE_MAP_FOOTER as CID} from '../utils/cids';

export default {
    name: CID,
    mixins: [
        MapContainerComponentStoreMx
    ],
};
</script>
