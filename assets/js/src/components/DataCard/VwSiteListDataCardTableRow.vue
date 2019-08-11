<template>
    <tr>
        <td
            class="text-xs-center"
        >
            <vw-site-list-row-action-menu :item="item" />
        </td>
        <td
            v-if="headersHaveElement('contribute_id')"
            data-test="td--contribute-id"
            class="text-xs-right"
        >
            {{ item.contribute_id }}
        </td>
        <td
            v-if="headersHaveElement('sbah_no')"
            data-test="td--sbah-no"
            class="text-xs-right"
        >
            {{ item.sbah_no }}
        </td>
        <td
            v-if="headersHaveElement('cadastre')"
            data-test="td--cadastre"
            class="text-xs-right"
        >
            {{ item.cadastre }}
        </td>
        <td
            v-if="headersHaveElement('modern_name')"
            data-test="td--modern-name"
            class="text-xs-right"
        >
            {{ item.modern_name }}
        </td>
        <td
            v-if="headersHaveElement('nearest_city')"
            data-test="td--nearest-city"
            class="text-xs-right"
        >
            {{ item.nearest_city }}
        </td>
        <td
            v-if="headersHaveElement('ancient_name')"
            data-test="td--ancient-name"
            class="text-xs-right"
        >
            {{ item.ancient_name }}
        </td>
        <td
            v-if="headersHaveElement('district')"
            data-test="td--district"
            class="text-xs-right"
        >
            {{ item.district }}
        </td>
        <td
            v-if="headersHaveElement('governorate')"
            data-test="td--governorate"
            class="text-xs-right"
        >
            {{ item.governorate }}
        </td>
        <td
            v-if="headersHaveElement('nation')"
            data-test="td--nation"
            class="text-xs-right"
        >
            {{ item.nation }}
        </td>
        <td
            v-if="headersHaveElement('chronology')"
            data-test="td--chronology"
            class="text-xs-right"
        >
            {{ item.chronology }}
        </td>
        <td
            v-if="headersHaveElement('survey_refs')"
            data-test="td--survey-refs"
            class="text-xs-right"
        >
            {{ item.survey_refs }}
        </td>
        <td
            v-if="headersHaveElement('features')"
            data-test="td--features"
            class="text-xs-right"
        >
            {{ item.features }}
        </td>
        <td
            v-if="headersHaveElement('threats')"
            data-test="td--threats"
            class="text-xs-right"
        >
            {{ item.threats }}
        </td>
        <td
            v-if="headersHaveElement('e')"
            data-test="td--e"
            class="text-xs-right"
        >
            {{ item.e }}
        </td>
        <td
            v-if="headersHaveElement('n')"
            data-test="td--n"
            class="text-xs-right"
        >
            {{ item.n }}
        </td>
        <td
            v-if="headersHaveElement('length')"
            data-test="td--length"
            class="text-xs-right"
        >
            {{ item.length }}
        </td>
        <td
            v-if="headersHaveElement('width')"
            data-test="td--width"
            class="text-xs-right"
        >
            {{ item.width }}
        </td>
        <td
            v-if="headersHaveElement('area')"
            data-test="td--area"
            class="text-xs-right"
        >
            {{ item.area }}
        </td>
        <td
            v-if="headersHaveElement('remarks')"
            data-test="td--remarks"
            class="text-xs-right"
        >
            {{ item.remarks }}
        </td>
    </tr>
</template>

<script>
import VwSiteListRowActionMenu from './ListRowMenu/VwSiteListRowActionMenu';

export default {
    name: 'VwSiteDataCardTableRow',
    components: {
        VwSiteListRowActionMenu
    },
    props: {
        item: {
            type:Object,
            required: true
        },
        headers: {
            type: Array,
            default() {
                return [];
            }
        }
    },
    methods: {
        headersHaveElement(value) {
            return undefined !== this.headers.find((element) => {
                return element.value === value;
            });
        }
    }
};
</script>

<style scoped>

</style>
