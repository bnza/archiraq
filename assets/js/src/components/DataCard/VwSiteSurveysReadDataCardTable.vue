<template>
    <v-data-table
        :headers="headers"
        :items="items"
    >
        <template v-slot:items="props">
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
</template>

<script>
import {yearToCanonicalString} from '@/utils/utils';

export default {
    name: 'VwSiteSurveysReadDataCardTable',
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
    },
    methods: {
        yearToCanonicalString
    }
};
</script>

<style scoped>

</style>
