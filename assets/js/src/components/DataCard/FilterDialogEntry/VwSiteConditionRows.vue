<template>
    <div data-test="vw-site-table--condition-rows">
        <string-predicate-row
            v-if="rowPredicateIsVisible('modernName')"
            class="predicate-row"
            data-test="modernName"
            :predicate-p="conditions.modernName"
            predicate-key="modernName"
            predicate-attribute-label="Modern Name"
            @change="setCondition"
        />
        <string-predicate-row
            v-if="rowPredicateIsVisible('ancientName')"
            class="predicate-row"
            data-test="ancientName"
            :predicate-p="conditions.ancientName"
            predicate-key="ancientName"
            predicate-attribute-label="Ancient Name"
            @change="setCondition"
        />
        <string-predicate-row
            v-if="rowPredicateIsVisible('nearestCity')"
            class="predicate-row"
            data-test="nearestCity"
            :predicate-p="conditions.nearestCity"
            predicate-key="nearestCity"
            predicate-attribute-label="Nearest City"
            @change="setCondition"
        />
        <vw-site-district-predicate-row
            v-if="rowPredicateIsVisible('district')"
            class="predicate-row"
            data-test="district"
            :predicate-p="conditions.district"
            predicate-key="district"
            @change="setCondition"
        />
        <vw-site-chronology-predicate-row
            v-if="rowPredicateIsVisible('chronology')"
            class="predicate-row"
            data-test="chronology"
            :predicate-p="conditions.chronology"
            predicate-key="chronology"
            @change="setCondition"
        />
        <vw-site-survey-predicate-row
            v-if="rowPredicateIsVisible('survey')"
            predicate-attribute-label="Survey"
            class="predicate-row"
            data-test="survey"
            :predicate-p="conditions.survey"
            predicate-key="survey"
            @change="setCondition"
        />
        <string-multiple-predicate-row
            v-if="rowPredicateIsVisible('features')"
            class="predicate-row"
            data-test="features"
            :predicate-p="conditions.features"
            predicate-key="features"
            :values="siteFeatures"
            predicate-attribute-label="Features"
            @change="setCondition"
        />
        <string-multiple-predicate-row
            v-if="rowPredicateIsVisible('threats')"
            class="predicate-row"
            data-test="threats"
            :predicate-p="conditions.threats"
            predicate-key="threats"
            :values="siteThreats"
            predicate-attribute-label="Threats"
            @change="setCondition"
        />
        <string-predicate-row
            v-if="rowPredicateIsVisible('remarks')"
            class="predicate-row"
            data-test="remarks"
            :predicate-p="conditions.remarks"
            predicate-key="remarks"
            predicate-attribute-label="Remarks"
            @change="setCondition"
        />
    </div>
</template>

<script>
import StringPredicateRow from '@/components/DataCard/FilterDialogEntry/StringPredicateRow';
import StringMultiplePredicateRow from '@/components/DataCard/FilterDialogEntry/StringMultiplePredicateRow';
import VwSiteSurveyPredicateRow from '@/components/DataCard/FilterDialogEntry/VwSiteSurveyPredicateRow';
import VwSiteChronologyPredicateRow from '@/components/DataCard/FilterDialogEntry/VwSiteChronologyPredicateRow';
import VwSiteDistrictPredicateRow from '@/components/DataCard/FilterDialogEntry/VwSiteDistrictPredicateRow';
import ConditionMx from '@/mixins/CQL/ConditionMx';
import QueryMx from '@/mixins/QueryMx';
import {QUERY_TYPENAME_VW_SITES_SURVEY, QUERY_TYPENAME_VW_SITES_RS} from '@/utils/cids';

const predicateRowsVisibility = {
    chronology: [QUERY_TYPENAME_VW_SITES_SURVEY],
    district: [QUERY_TYPENAME_VW_SITES_SURVEY, QUERY_TYPENAME_VW_SITES_RS],
    modernName: [QUERY_TYPENAME_VW_SITES_SURVEY, QUERY_TYPENAME_VW_SITES_RS],
    ancientName: [QUERY_TYPENAME_VW_SITES_SURVEY, QUERY_TYPENAME_VW_SITES_RS],
    nearestCity: [QUERY_TYPENAME_VW_SITES_SURVEY],
    survey: [QUERY_TYPENAME_VW_SITES_SURVEY],
    threats: [QUERY_TYPENAME_VW_SITES_SURVEY, QUERY_TYPENAME_VW_SITES_RS],
    features: [QUERY_TYPENAME_VW_SITES_SURVEY],
    remarks: [QUERY_TYPENAME_VW_SITES_SURVEY, QUERY_TYPENAME_VW_SITES_RS],
};

const defaultConditions = () => {
    return {
        chronology: {
            negate: false,
            expressions: ['chronology', []],
            operator: 'MultipleIsInsensitiveLikeFilter'
        },
        district: {
            negate: false,
            expressions: ['district', []],
            operator: 'MultipleEqualToFilter'
        },
        modernName: {
            negate: false,
            expressions: ['modern_name'],
            operator: ''
        },
        ancientName: {
            negate: false,
            expressions: ['ancient_name'],
            operator: ''
        },
        nearestCity: {
            negate: false,
            expressions: ['nearest_city'],
            operator: ''
        },
        survey: {
            negate: false,
            expressions: ['survey_refs'],
            operator: 'surveyRefsMatchFilter'
        },
        features: {
            negate: false,
            expressions: ['features'],
            operator: 'MultipleIsInsensitiveLikeFilter'
        },
        threats: {
            negate: false,
            expressions: ['threats'],
            operator: 'MultipleIsInsensitiveLikeFilter'
        },
        remarks: {
            negate: false,
            expressions: ['remarks'],
            operator: ''
        },
    };
};

export default {
    name: 'VwSiteConditionRows',
    components: {
        StringMultiplePredicateRow,
        VwSiteChronologyPredicateRow,
        VwSiteDistrictPredicateRow,
        VwSiteSurveyPredicateRow,
        StringPredicateRow,
    },
    mixins: [
        QueryMx,
        ConditionMx
    ],
    props: {
        modalProps: {
            type: Object,
            required: true,
            validator: function (value) {
                return value.hasOwnProperty('queryTypename');
            }
        }
    },
    computed: {
        queryTypename() {
            return this.modalProps.queryTypename;
        },
        siteFeatures() {
            return [
                {text: 'ancient structures', value: 'structures'},
                {text: 'epigraphic', value: 'epigraphic'},
                {text: 'paleochannels', value: 'paleochannels'}
            ];
        },
        siteThreats() {
            return [
                {text: 'cultivation', value: 'cultivation'},
                {text: 'dunes', value: 'dunes'},
                {text: 'looting', value: 'looting'},
                {text: 'modern canals', value: 'canals'},
                {text: 'modern structures', value: 'structures'}
            ];
        }
    },
    created() {
        // Retrieve from store
        let conditions = Object.assign(defaultConditions(), this.getQueryConditions(this.queryTypename));
        this.conditions = conditions;
    },
    methods: {
        rowPredicateIsVisible(key) {
            return predicateRowsVisibility[key].indexOf(this.queryTypename) > -1;
        },
        submit() {
            this.setQueryConditions(this.conditions);
            this.setQueryFilter(this.getAndConditionsFilter());
        },
        clear() {
            this.conditions = defaultConditions();
            this.setQueryConditions(this.conditions);
            this.setQueryFilter(null);
        }
    }
};
</script>

<style scoped>
    >>> .predicate-row {
        margin: -0.75rem auto !important;
    }
</style>
