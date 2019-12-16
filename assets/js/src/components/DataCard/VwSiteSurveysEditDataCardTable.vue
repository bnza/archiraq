<template>
    <div>
        <v-dialog
            :value="!!dialog"
        >
            <component
                :is="dialogComponent"
                v-if="dialog"
                :item="item"
                @change="doChange"
                @close="dialog=''"
            />
        </v-dialog>
        <v-data-table
            :headers="headers"
            :items="items"
        >
            <template v-slot:items="props">
                <td>
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                            <v-icon
                                color="green darken-3"
                                dark
                                v-on="on"
                                @click="openEditDialog(props.item)"
                            >
                                edit
                            </v-icon>
                        </template>
                        <span>Edit chronology</span>
                    </v-tooltip>
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                            <v-icon
                                color="red darken-3"
                                dark
                                v-on="on"
                                @click="openDeleteDialog(props.item)"
                            >
                                delete_outline
                            </v-icon>
                        </template>
                        <span>Delete chronology</span>
                    </v-tooltip>
                </td>
                <td>{{ props.item.survey.code }}</td>
                <td>
                    {{ props.item.ref }}
                </td>
                <td>
                    {{ props.item.year_low }}
                </td>
                <td>
                    {{ props.item.year_high }}
                </td>
                <td>
                    {{ props.item.remarks }}
                </td>
            </template>
        </v-data-table>
    </div>
</template>

<script>
import VwSiteChildrenEditDataCardTableMx from '@/mixins/VwSiteChildrenEditDataCardTableMx';

export default {
    name: 'VwSiteSurveysEditDataCardTable',
    components: {
        VwSiteSurveyNewDataCardForm: () => import(
            /* webpackChunkName: "VwSiteSurveyNewDataCardForm" */
            './VwSiteSurveyNewDataCardForm'
        ),
        VwSiteSurveyEditDataCardForm: () => import(
            /* webpackChunkName: "VwSiteSurveyEditDataCardForm" */
            './VwSiteSurveyEditDataCardForm'
        ),
        VwSiteSurveyDeleteDataCardForm: () => import(
            /* webpackChunkName: "VwSiteSurveyDeleteDataCardForm" */
            './VwSiteSurveyDeleteDataCardForm'
        ),
    },
    mixins: [
        VwSiteChildrenEditDataCardTableMx
    ],
    props: {
        items: {
            type: Array,
            default() {
                return [];
            }
        }
    },
    data() {
        return {
            headers: [
                {
                    text: '',
                    value: 'id',
                    width: '20rem',
                    sortable: false
                },
                {
                    text: 'code',
                    value: 'survey.code'
                },
                {
                    text: 'reference',
                    value: 'ref'
                },
                {
                    text: 'year (low)',
                    value: 'year_low'
                },
                {
                    text: 'year (high)',
                    value: 'year_high'
                },
                {
                    text: 'remarks',
                    value: 'remarks'
                },
            ]
        };
    }
};
</script>

<style scoped>

</style>
