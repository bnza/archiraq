<template>
    <data-card
        color="grey lighten-3"
        :height="32"
    >
        <v-toolbar-title
            slot="toolbar"
        >
            {{ title }}
        </v-toolbar-title>
        <template slot="actions">
            <v-spacer />
            <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                    <router-link :to="dataItemRoute">
                        <v-icon
                            color="primary"
                            dark
                            v-on="on"
                        >
                            view_list
                        </v-icon>
                    </router-link>
                </template>
                <span>Show more</span>
            </v-tooltip>
        </template>
        <component
            :is="dataComponent"
            id="data-table"
            slot="data"
            :feature="feature"
            :typename="typename"
        />
    </data-card>
</template>

<script>
import DataCard from '@/components/DataCard/DataCard';
import VwSiteSurveyPopupItemDataCard from '@/components/DataCard/Interaction/VwSiteSurveyPopupItemDataCard';
import VwSiteRsPopupItemDataCard from '@/components/DataCard/Interaction/VwSiteRsPopupItemDataCard';
import {getMapDataItemReadFullPath} from '@/utils/spaRouteQuery';
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
        },
        typename: {
            type: String,
            required: true
        }
    },
    computed: {
        dataItemRoute() {
            return getMapDataItemReadFullPath(this.queryTypename, this.feature.properties.id);
            //return `/map/data/${this.queryTypename}/${this.feature.properties.id}/read#item-form`;
        },
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
    /deep/ .v-card__actions a {
        text-decoration: none;
    }
</style>
