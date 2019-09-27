<template>
    <data-card
        v-if="localItem"
        color="red darken-3"
        :dark="true"
        :padding="true"
    >
        <v-toolbar-title slot="toolbar">
            Delete Chronology
        </v-toolbar-title>
        <v-container
            slot="data"
            fluid
        >
            <v-layout
                row
                wrap
                justify-center
            >
                <v-flex
                    xs3
                    wrap
                >
                    <h4>Are you sure you want do delete following item?</h4>
                </v-flex>
            </v-layout>
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
                        readonly
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
                color="red darken-3"
                :disabled="!localItem.chronology.code"
                @click="doChange"
            >
                Delete
            </v-btn>
        </template>
    </data-card>
</template>

<script>
import {yearToCanonicalString} from '@/utils/utils';
import DataCard from '@/components/DataCard/DataCard';
import VwSiteChildrenActionDataCardFormMx from '@/mixins/VwSiteChildrenActionDataCardFormMx';

export default {
    name: 'VwSiteChronologyEditDataCardForm',
    components: {DataCard},
    mixins: [
        VwSiteChildrenActionDataCardFormMx
    ],
    data() {
        return {
            chronologies: [],
        };
    },
    created() {
        this.chronologies = this.getChronologies();
    },
    methods: {
        yearToCanonicalString,
        getChronologies() {
            return this.$store.state.vocabulary.chronologies;
        }
    }
};
</script>
