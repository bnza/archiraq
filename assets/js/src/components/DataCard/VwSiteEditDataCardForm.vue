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
                    label="Nearest city"
                    :value="item.nearest_city"
                    @change="updateItemProp('nearest_city', $event)"
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
                    label="SBAH number"
                    :value="item.sbah_no"
                    @change="updateItemProp('sbah_no', $event)"
                />
            </v-flex>
            <v-flex
                xs3
                wrap
            >
                <v-text-field
                    label="Cadastre"
                    :value="item.cadastre"
                    @change="updateItemProp('cadastre', $event)"
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
                    label="Modern name"
                    :value="item.modern_name"
                    @change="updateItemProp('modern_name', $event)"
                />
            </v-flex>
            <v-flex
                xs3
                wrap
            >
                <v-text-field
                    label="Ancient name"
                    :value="item.ancient_name"
                    @change="updateItemProp('ancient_name', $event)"
                />
            </v-flex>
            <v-flex
                xs3
                wrap
            >
                <v-checkbox
                    label="Ancient name uncertain"
                    :input-value="item.ancient_name_uncertain"
                    @change="updateItemProp('ancient_name_uncertain', $event)"
                />
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex xs12>
                <h4>
                    Chronology
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                            <v-icon
                                color="indigo"
                                dark
                                v-on="on"
                                @click="openChronologiesNewDialog"
                            >
                                add_circle_outline
                            </v-icon>
                        </template>
                        <span>Add chronology</span>
                    </v-tooltip>
                </h4>
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
                <vw-site-chronologies-edit-data-card-table
                    ref="chronologiesTable"
                    :items="item.chronologies || []"
                    type="chronology"
                    @change="updateItemProp('chronologies', $event)"
                />
            </v-flex>
        </v-layout>
        <v-layout
            row
            wrap
        >
            <v-flex xs12>
                <h4>
                    Surveys
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                            <v-icon
                                color="indigo"
                                dark
                                v-on="on"
                                @click="openSurveysNewDialog"
                            >
                                add_circle_outline
                            </v-icon>
                        </template>
                        <span>Add survey</span>
                    </v-tooltip>
                </h4>
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
                <vw-site-surveys-edit-data-card-table
                    ref="surveysTable"
                    :items="item.surveys || []"
                    type="survey"
                    @change="updateItemProp('surveys', $event)"
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
                    label="Ancient structures"
                    :input-value="item.features_ancient_structures"
                    @change="updateItemProp('features_ancient_structures', $event)"
                />
            </v-flex>
            <v-flex
                xs4
                wrap
            >
                <v-checkbox
                    label="Epigraphic"
                    :input-value="item.features_epigraphic"
                    @change="updateItemProp('features_epigraphic', $event)"
                />
            </v-flex>
            <v-flex
                xs4
                wrap
            >
                <v-checkbox
                    label="Paleochannels"
                    :input-value="item.features_paleochannels"
                    @change="updateItemProp('features_paleochannels', $event)"
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
                    label="Features remarks"
                    :value="item.features_remarks"
                    @change="updateItemProp('features_remarks', $event)"
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
                    label="Bulldozer"
                    :input-value="item.threats_bulldozer"
                    @change="updateItemProp('threats_bulldozer', $event)"
                />
            </v-flex>
            <v-flex
                xs4
                wrap
            >
                <v-checkbox
                    label="Cultivation trenches"
                    :input-value="item.threats_cultivation_threnches"
                    @change="updateItemProp('threats_cultivation_threnches', $event)"
                />
            </v-flex>
            <v-flex
                xs4
                wrap
            >
                <v-checkbox
                    label="Looting"
                    :input-value="item.threats_looting"
                    @change="updateItemProp('threats_looting', $event)"
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
                    :input-value="item.threats_modern_canals"
                    label="Modern canals"
                    @change="updateItemProp('threats_modern_canals', $event)"
                />
            </v-flex>
            <v-flex
                xs4
                wrap
            >
                <v-checkbox
                    label="Modern structures"
                    :value="item.threats_structures"
                    @change="updateItemProp('threats_structures', $event)"
                />
            </v-flex>
            <v-flex
                xs4
                wrap
            >
                <v-checkbox
                    label="Natural dunes"
                    :value="item.threats_natural_dunes"
                    @change="updateItemProp('threats_natural_dunes', $event)"
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
                    label="Remarks"
                    :value="item.remarks"
                    @change="updateItemProp('remarks', $event)"
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
                    label="Compiler"
                    :value="item.compiler"
                    @change="updateItemProp('compiler', $event)"
                />
            </v-flex>
            <v-flex
                xs6
                wrap
            >
                <v-text-field
                    label="Credits"
                    :value="item.credits"
                    @change="updateItemProp('credits', $event)"
                />
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import MapContainerComponentStoreMx from '@/mixins/MapContainerComponentStoreMx';
import {CID_VW_SITE_INTERACTION_MODIFY, CID_VW_SITE_EDIT_DATA_CARD, QUERY_TYPENAME_VW_SITES_EDIT} from '@/utils/cids';
import VwSiteChronologiesEditDataCardTable from '@/components/DataCard/VwSiteChronologiesEditDataCardTable';
import VwSiteSurveysEditDataCardTable from '@/components/DataCard/VwSiteSurveysEditDataCardTable';
import {GET_DISTRICT_GOVERNORATE_NAME, GET_DISTRICT_NATION_NAME} from '@/store/vocabulary/getters';
import {mapGetters} from 'vuex';
import {cloneDeep} from 'lodash';

export default {
    name: 'VwSiteEditDataCardForm',
    components: {
        VwSiteChronologiesEditDataCardTable,
        VwSiteSurveysEditDataCardTable
    },
    mixins: [
        MapContainerComponentStoreMx
    ],
    props: {
        item: {
            type: Object,
            required: true
        },
        interactionModifyReady: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            modal: '',
            activeLayer: ''
        };
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
        },
        geometryString: {
            get() {
                return this.componentsGetComponentProp(
                    CID_VW_SITE_EDIT_DATA_CARD,
                    'geometryString'
                );
            },
            set(value) {
                this.componentsSetComponentProp({
                    cid: CID_VW_SITE_EDIT_DATA_CARD,
                    prop: 'geometryString',
                    value
                });
            }
        },

    },
    watch: {
        interactionModifyReady(flag) {
            if (flag) {
                this.geometryString = this.item.geom.geom;
                this.activeLayer = this.mapContainerCurrentLayer;
                this.mapContainerCurrentLayer = QUERY_TYPENAME_VW_SITES_EDIT;
            }
        },
        geometryString(value) {
            const _geom = cloneDeep(this.item.geom);
            _geom.geom = value;
            this.updateItemProp('geom', _geom);
        }
    },
    created() {
        this.mapContainerDynamicEditComponent = CID_VW_SITE_INTERACTION_MODIFY;
    },
    destroyed() {
        this.mapContainerCurrentLayer = this.activeLayer;
        this.mapContainerDynamicEditComponent = '';
    },
    methods: {
        updateItemProp(prop, value) {
            const _item = cloneDeep(this.item);
            _item[prop] = value;
            this.$emit('update:item', _item);
        },
        openChronologiesNewDialog() {
            this.$refs.chronologiesTable.openNewDialog();
        },
        openSurveysNewDialog() {
            this.$refs.surveysTable.openNewDialog();
        }
    }
};
</script>

<style scoped>
    /deep/ .flex.wrap{
        padding: 4px;
    }
</style>
