<template>
    <data-card
        v-if="localItem"
        color="indigo"
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
                    <v-autocomplete
                        v-model="localItem.survey"
                        label="Survey"
                        :attach="true"
                        :items="surveys"
                        :search-input.sync="search"
                        item-text="code"
                        return-object
                    />
                </v-flex>
                <v-flex
                    xs3
                    wrap
                >
                    <v-text-field
                        label="Reference"
                        v-model="localItem.ref"
                    />
                </v-flex>
                <v-flex
                    xs3
                    wrap
                >
                    <v-text-field
                        type="number"
                        label="Year (low)"
                        v-model="localItem.year_low"
                    />
                </v-flex>
                <v-flex
                    xs3
                    wrap
                >
                    <v-text-field
                        type="number"
                        label="Year (high)"
                        v-model="localItem.year_high"
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
                :disabled="!localItem.survey.code"
                @click="doChange"
            >
                Add
            </v-btn>
        </template>
    </data-card>
</template>

<script>
import {cloneDeep} from 'lodash';
import DataCard from '@/components/DataCard/DataCard';
import HttpClientMx from '@/mixins/HttpClientMx';

export default {
    name: 'VwSiteSurveyNewDataCardForm',
    components: {DataCard},
    mixins: [
        HttpClientMx
    ],
    props: {
        item: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            localItem: null,
            surveys: [],
            search: ''
        };
    },
    watch: {
        search(pattern) {
            this.fetchSurveys(pattern);
        }
    },
    mounted() {
        this.localItem = cloneDeep(this.item);
    },
    methods: {
        doChange()
        {
            this.$emit('change', this.localItem);
            this.$emit('close');
        },
        fetchSurveys(pattern) {
            return this.clientRequest({
                method:'get',
                url: `/data/voc-survey/codes/${pattern}`
            }).then(
                response => this.surveys = response.data
            );
        }
    }
};
</script>

<style scoped>

</style>
