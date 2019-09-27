<template>
    <data-card
        v-if="localItem"
        color="green darken-3"
        :dark="true"
        :padding="true"
    >
        <v-toolbar-title slot="toolbar">
            Edit Chronology
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
                        readonly
                        label="Code"
                        :value="localItem.chronology.code"
                    />
                </v-flex>
                <v-flex
                    xs3
                    wrap
                >
                    <v-autocomplete
                        v-model="localItem.chronology"
                        label="Name"
                        :attach="true"
                        :items="chronologies"
                        item-text="name"
                        return-object
                    />
                </v-flex>
                <v-flex
                    xs3
                    wrap
                >
                    <v-text-field
                        readonly
                        label="Date (low)"
                        :value="yearToCanonicalString(localItem.chronology.date_low || 0)"
                    />
                </v-flex>
                <v-flex
                    xs3
                    wrap
                >
                    <v-text-field
                        readonly
                        label="Date (high)"
                        :value="yearToCanonicalString(localItem.chronology.date_high || 0)"
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
                color="blue darken-3"
                :disabled="!localItem.chronology.code"
                @click="doChange"
            >
                Edit
            </v-btn>
        </template>
    </data-card>
</template>

<script>
import {yearToCanonicalString} from '@/utils/utils';
import {cloneDeep} from 'lodash';
import DataCard from '@/components/DataCard/DataCard';

export default {
    name: 'VwSiteChronologyEditDataCardForm',
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
