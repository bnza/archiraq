<template>
    <v-data-table
        :headers="headers"
        :items="items"
    >
        <template v-slot:items="props">
            <td>{{ props.item.survey.code }}</td>
            <td class="text-xs-right">
                {{ props.item.ref }}
            </td>
            <td class="text-xs-right">
                {{ props.item.year_low }}
            </td>
            <td class="text-xs-right">
                {{ props.item.year_high}}
            </td>
            <td>
                {{ props.item.remarks }}
            </td>
        </template>
    </v-data-table>
</template>

<script>
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
        yearToCanonicalString(year) {
            return year < 0 ? `${Math.abs(year)} b.C.` : `${year} a.D.`;
        }
    }
};
</script>

<style scoped>

</style>
