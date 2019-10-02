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
                        v-model="localItem.ref"
                        label="Reference"
                    />
                </v-flex>
                <v-flex
                    xs3
                    wrap
                >
                    <v-text-field
                        :value="localItem.year_low"
                        type="number"
                        label="Year (low)"
                        @input="localItem.year_low = $event || null"
                    />
                </v-flex>
                <v-flex
                    xs3
                    wrap
                >
                    <v-text-field
                        :value="localItem.year_high"
                        type="number"
                        label="Year (high)"
                        @input="localItem.year_high = $event || null"
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
                color="green darken-3"
                :disabled="!localItem.survey.code"
                @click="doChange"
            >
                Update
            </v-btn>
        </template>
    </data-card>
</template>

<script>
import HttpClientMx from '@/mixins/HttpClientMx';
import {cloneDeep} from 'lodash';
import DataCard from '@/components/DataCard/DataCard';

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
    created() {
        this.surveys.push(this.item.survey);
    },
    methods: {
        doChange() {
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
