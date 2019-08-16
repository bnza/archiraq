<template>
    <data-card
        color="grey lighten-3"
        :height="32"
    >
        <v-toolbar-title
            slot="toolbar"
        >
            {{title}}
        </v-toolbar-title>
        <component
            :is="dataComponent"
            id="data-table"
            slot="data"
            :feature="feature"
        />
    </data-card>
</template>

<script>
import DataCard from '@/components/DataCard/DataCard';
import VwSiteSurveyPopupItemDataCard from '@/components/DataCard/Interaction/VwSiteSurveyPopupItemDataCard';
import VwSiteRsPopupItemDataCard from '@/components/DataCard/Interaction/VwSiteRsPopupItemDataCard';
import {
    QUERY_TYPENAME_VW_SITES_RS,
    QUERY_TYPENAME_VW_SITES_SURVEY,
    TITLE_TYPENAME_VW_SITES,
    TITLE_TYPENAME_VW_SITES_RS,
    TITLE_TYPENAME_VW_SITES_SURVEY
} from '@/utils/cids';

export default {
    name: 'VwSitePopupDataCard',
    components: {
        DataCard,
        VwSiteSurveyPopupItemDataCard,
        VwSiteRsPopupItemDataCard
    },
    props: {
        feature: {
            type: Object,
            required: true
        }
    },
    computed: {
        queryTypename() {
            return this.feature.properties.remote_sensing ? QUERY_TYPENAME_VW_SITES_RS : QUERY_TYPENAME_VW_SITES_SURVEY;
        },
        title() {
            let title;
            switch (this.feature.properties.remote_sensing) {
            case true:
                title = TITLE_TYPENAME_VW_SITES_RS;
                break;
            case false:
                title = TITLE_TYPENAME_VW_SITES_SURVEY;
                break;
            default:
                title = TITLE_TYPENAME_VW_SITES;
            }
            return title;
        },
        dataComponent() {
            return {
                [QUERY_TYPENAME_VW_SITES_RS]: VwSiteRsPopupItemDataCard,
                [QUERY_TYPENAME_VW_SITES_SURVEY]: VwSiteSurveyPopupItemDataCard,
            }[this.queryTypename];
        }
    },

};
</script>

<style scoped>
    .v-toolbar__title {
        font-size: 1rem;
    }
</style>
