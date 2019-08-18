<template>
    <div>
        <v-layout
            row
            wrap
        >
            <v-flex
                xs12
            >
                <h4 class="text-sm-left red--text text--darken-1">
                    Shapefile - Spreadsheet entry key mismatch
                </h4>
            </v-flex>
        </v-layout>
        <v-layout
            v-if="error.value.hasOwnProperty('shapefile')"
            row
            wrap
        >
            <v-flex
                xs6
            >
                <p>
                    Following keys are present in shapefile but not in spreadsheet:
                </p>
            </v-flex>
            <v-flex
                xs6
            >
                <p>
                    {{ error.value.shapefile.join(', ') }}
                </p>
            </v-flex>
        </v-layout>
        <v-layout
            v-if="error.value.hasOwnProperty('spreadsheet')"
            row
            wrap
        >
            <v-flex
                xs6
            >
                <p>
                    Following keys are present in spreadsheet but not in shapefile:
                </p>
            </v-flex>
            <v-flex
                xs6
            >
                <p>
                    {{ error.value.spreadsheet.join(', ') }}
                </p>
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
import JobErrorDisplayMx from '@/mixins/JobErrorDisplayMx';

export default {
    name: 'JobErrorEntryMismatchDisplay',
    mixins: [
        JobErrorDisplayMx
    ]
};
</script>

<style scoped>

</style>
