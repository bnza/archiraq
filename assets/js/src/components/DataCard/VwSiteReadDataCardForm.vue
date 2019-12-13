<template>
    <v-container fluid>
        <v-layout
            row
            wrap
        >
            <v-flex xs12>
                <h4>Location</h4>
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
                    label="Nation"
                    :value="nationName"
                />
            </v-flex>
            <v-flex
                xs3
                wrap
            >
                <v-text-field
                    readonly
                    label="Governorate"
                    :value="governorateName"
                />
            </v-flex>
            <v-flex
                xs3
                wrap
            >
                <v-text-field
                    readonly
                    label="District"
                    :value="item.district.name"
                />
            </v-flex>
            <v-flex
                xs3
                wrap
            >
                <v-text-field
                    readonly
                    label="Nearest city"
                    :value="item.nearest_city"
                />
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex xs12>
                <h4>Identify</h4>
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
                    class="strong"
                    readonly
                    label="ID"
                    :value="item.id"
                />
            </v-flex>
            <v-flex
                xs3
                wrap
            >
                <v-text-field
                    readonly
                    label="SBAH number"
                    :value="item.sbah_no"
                />
            </v-flex>
            <v-flex
                xs3
                wrap
            >
                <v-text-field
                    readonly
                    label="Cadastre"
                    :value="item.cadastre"
                />
            </v-flex>
            <v-flex
                xs3
                wrap
            >
                <v-text-field
                    readonly
                    label="Entry ID"
                    :value="item.entry_id"
                />
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
                    label="Modern name"
                    :value="item.modern_name"
                />
            </v-flex>
            <v-flex
                xs3
                wrap
            >
                <v-text-field
                    readonly
                    label="Ancient name"
                    :value="item.ancient_name"
                />
            </v-flex>
            <v-flex
                xs3
                wrap
            >
                <v-checkbox
                    readonly
                    label="Ancient name uncertain"
                    :input-value="item.ancient_name_uncertain"
                />
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex xs12>
                <h4>Chronology</h4>
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex
                xs12
                wrap
            >
                <vw-site-chronologies-read-data-card-table
                    :items="item.chronologies || []"
                />
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex xs12>
                <h4>Surveys</h4>
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex
                xs12
                wrap
            >
                <vw-site-surveys-read-data-card-table
                    :items="item.surveys || []"
                />
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex
                xs4
                wrap
            >
                <v-checkbox
                    readonly
                    label="Remote sensing"
                    :input-value="item.remote_sensing"
                />
            </v-flex>
            <v-flex
                xs4
                wrap
            >
                <v-checkbox
                    readonly
                    label="Verified on field"
                    :input-value="item.survey_verified_on_field"
                />
            </v-flex>
            <v-flex
                xs4
                wrap
            >
                <v-text-field
                    readonly
                    label="Survey type"
                    :value="item.survey_type"
                />
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex xs12>
                <h4>Excavations</h4>
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex
                xs6
                wrap
            >
                <v-text-field
                    readonly
                    label="Campaigns"
                    :value="item.excavations_whom_when"
                />
            </v-flex>
            <v-flex
                xs6
                wrap
            >
                <v-text-field
                    readonly
                    label="Bibliography"
                    :value="item.excavations_bibliography"
                />
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex xs12>
                <h4>Features</h4>
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex
                xs4
                wrap
            >
                <v-checkbox
                    readonly
                    label="Ancient structures"
                    :input-value="item.features_ancient_structures"
                />
            </v-flex>
            <v-flex
                xs4
                wrap
            >
                <v-checkbox
                    readonly
                    label="Epigraphic"
                    :input-value="item.features_epigraphic"
                />
            </v-flex>
            <v-flex
                xs4
                wrap
            >
                <v-checkbox
                    readonly
                    label="Paleochannels"
                    :input-value="item.features_paleochannels"
                />
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex
                xs12
                wrap
            >
                <v-textarea
                    readonly
                    label="Features remarks"
                    :value="item.features_remarks"
                />
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex xs12>
                <h4>Threats</h4>
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex
                xs4
                wrap
            >
                <v-checkbox
                    readonly
                    label="Bulldozer"
                    :input-value="item.threats_bulldozer"
                />
            </v-flex>
            <v-flex
                xs4
                wrap
            >
                <v-checkbox
                    readonly
                    label="Cultivation trenches"
                    :input-value="item.threats_cultivation_threnches"
                />
            </v-flex>
            <v-flex
                xs4
                wrap
            >
                <v-checkbox
                    readonly
                    label="Looting"
                    :input-value="item.threats_looting"
                />
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex
                xs4
                wrap
            >
                <v-checkbox
                    readonly
                    label="Modern canals"
                    :input-value="item.threats_modern_canals"
                />
            </v-flex>
            <v-flex
                xs4
                wrap
            >
                <v-checkbox
                    readonly
                    label="Modern structures"
                    :input-value="item.threats_structures"
                />
            </v-flex>
            <v-flex
                xs4
                wrap
            >
                <v-checkbox
                    readonly
                    label="Natural dunes"
                    :input-value="item.threats_natural_dunes"
                />
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex xs12>
                <h4>Remarks</h4>
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex
                xs12
                wrap
            >
                <v-textarea
                    readonly
                    label="Remarks"
                    :value="item.remarks"
                />
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex xs12>
                <h4>Compilation</h4>
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
                    label="Compilation date"
                    :value="item.compilation_date.date"
                />
            </v-flex>
            <v-flex
                xs3
                wrap
            >
                <v-text-field
                    readonly
                    label="Compiler"
                    :value="item.compiler"
                />
            </v-flex>
            <v-flex
                xs6
                wrap
            >
                <v-text-field
                    readonly
                    label="Credits"
                    :value="item.credits"
                />
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import VwSiteChronologiesReadDataCardTable from '@/components/DataCard/VwSiteChronologiesReadDataCardTable';
import VwSiteSurveysReadDataCardTable from '@/components/DataCard/VwSiteSurveysReadDataCardTable';
import {GET_DISTRICT_GOVERNORATE_NAME, GET_DISTRICT_NATION_NAME} from '@/store/vocabulary/getters';
import {mapGetters} from 'vuex';

export default {
    name: 'VwSiteReadDataCardForm',
    components: {
        VwSiteChronologiesReadDataCardTable,
        VwSiteSurveysReadDataCardTable
    },
    props: {
        item: {
            type: Object,
            required: true
        }
    },
    computed: {
        ...mapGetters({
            getDistrictGovernorateName: `vocabulary/${GET_DISTRICT_GOVERNORATE_NAME}`,
            getDistrictNationName: `vocabulary/${GET_DISTRICT_NATION_NAME}`,
        }),
        governorateName() {
            return this.getDistrictGovernorateName(this.item.district.name);
        },
        nationName() {
            return this.getDistrictNationName(this.item.district.name);
        }
    },
};
</script>

<style scoped>
    /deep/ .flex.wrap{
        padding: 4px;
    }
</style>
