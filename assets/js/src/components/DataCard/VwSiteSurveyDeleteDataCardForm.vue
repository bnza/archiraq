<template>
    <data-card
        v-if="localItem"
        color="red darken-3"
        :dark="true"
        :padding="true"
    >
        <v-toolbar-title slot="toolbar">
            New Chronology
        </v-toolbar-title>
        <v-container
            slot="data"
            fluid
        >
            <v-layout
                row
                wrap
            >
                <v-flex
                    xs3
                    wrap
                >
                    <v-text-field
                        v-model="localItem.survey.code"
                        readonly
                        label="Survey"
                    />
                </v-flex>
                <v-flex
                    xs3
                    wrap
                >
                    <v-text-field
                        v-model="localItem.ref"
                        readonly
                        label="Reference"
                    />
                </v-flex>
                <v-flex
                    xs3
                    wrap
                >
                    <v-text-field
                        v-model="localItem.year_low"
                        readonly
                        type="number"
                        label="Year (low)"
                    />
                </v-flex>
                <v-flex
                    xs3
                    wrap
                >
                    <v-text-field
                        v-model="localItem.year_high"
                        readonly
                        type="number"
                        label="Year (high)"
                    />
                </v-flex>
            </v-layout>
        </v-container>
        <template slot="actions">
            <v-spacer />
            <v-btn
                color="grey darken-3"
                flat
                @click="$emit('close')"
            >
                Close
            </v-btn>
            <v-btn
                flat
                color="red darken-3"
                :disabled="!localItem.survey.code"
                @click="doChange"
            >
                Delete
            </v-btn>
        </template>
    </data-card>
</template>

<script>
import {yearToCanonicalString} from '@/utils/utils';
import {cloneDeep} from 'lodash';
import DataCard from '@/components/DataCard/DataCard';

export default {
    name: 'VwSiteSurveyNewDataCardForm',
    components: {DataCard},
    props: {
        item: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            localItem: null,
            chronologies: [],
        };
    },
    created() {
        this.chronologies = this.getChronologies();
    },
    mounted() {
        this.localItem = cloneDeep(this.item);
    },
    methods: {
        yearToCanonicalString,
        getChronologies() {
            return this.$store.state.vocabulary.chronologies;
        },
        doChange()
        {
            this.$emit('change', this.localItem);
            this.$emit('close');
        }
    }
};
</script>

<style scoped>

</style>
