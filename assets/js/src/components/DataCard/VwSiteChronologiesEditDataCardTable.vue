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
                <td>{{ props.item.chronology.code }}</td>
                <td class="text-xs-right">
                    {{ props.item.chronology.name }}
                </td>
                <td class="text-xs-right">
                    {{ yearToCanonicalString(props.item.chronology.date_low) }}
                </td>
                <td class="text-xs-right">
                    {{ yearToCanonicalString(props.item.chronology.date_high) }}
                </td>
            </template>
        </v-data-table>
    </div>
</template>

<script>
import {yearToCanonicalString} from '@/utils/utils';
import VwSiteChildrenEditDataCardTableMx from '@/mixins/VwSiteChildrenEditDataCardTableMx';

export default {
    name: 'VwSiteChronologiesEditDataCardTable',
    components: {
        VwSiteChronologyNewDataCardForm: () => import(
            /* webpackChunkName: "VwSiteChronologyNewDataCardForm" */
            './VwSiteChronologyNewDataCardForm'
        ),
        VwSiteChronologyEditDataCardForm: () => import(
            /* webpackChunkName: "VwSiteChronologyEditDataCardForm" */
            './VwSiteChronologyEditDataCardForm'
        ),
        VwSiteChronologyDeleteDataCardForm: () => import(
            /* webpackChunkName: "VwSiteChronologyDeleteDataCardForm" */
            './VwSiteChronologyDeleteDataCardForm'
        ),
    },
    mixins: [
        VwSiteChildrenEditDataCardTableMx
    ],
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
                    value: 'chronology.code'
                },
                {
                    text: 'name',
                    value: 'chronology.name'
                },
                {
                    text: 'date (low)',
                    value: 'chronology.date_low'
                },
                {
                    text: 'date (high)',
                    value: 'chronology.date_high'
                },
            ]
        };
    },
    methods: {
        yearToCanonicalString
    }
};
</script>
