<template>
    <component
        :is="dataComponent"
        :action="action"
        :query-typename="queryTypename"
        :item-id="itemId"
    />
</template>

<script>
import DataCardQueryMx from '../../mixins/DataCardQueryMx';
import {camelCase, upperFirst} from 'lodash';
import {getRouteQueryFromFullPath} from '../../utils/spaRouteQuery';

export default {
    name: 'DataCardContainer',
    components: {
        VwSiteListDataCard: () => import(
            /* webpackChunkName: "VwSiteListDataCard" */
            './VwSiteListDataCard'
        ),
        VwSiteSurveyEditDataCard: () => import(
            /* webpackChunkName: "VwSiteEditDataCard" */
            './VwSiteEditDataCard'
        ),
        VwSiteRsEditDataCard: () => import(
            /* webpackChunkName: "VwSiteEditDataCard" */
            './VwSiteEditDataCard'
        ),
        VwSiteSurveyListDataCard: () => import(
            /* webpackChunkName: "VwSiteListDataCard" */
            './VwSiteListDataCard'
        ),
        VwSiteRsListDataCard: () => import(
            /* webpackChunkName: "VwSiteListDataCard" */
            './VwSiteListDataCard'
        ),
        VwSiteSurveyReadDataCard: () => import(
            /* webpackChunkName: "VwSiteReadDataCard" */
            './VwSiteReadDataCard'
        ),
        VwSiteRsReadDataCard: () => import(
            /* webpackChunkName: "VwSiteReadDataCard" */
            './VwSiteReadDataCard'
        )
    },
    mixins: [
        DataCardQueryMx
    ],
    props: {
        action: {
            type: String,
            required: true
        },
        itemId: {
            type: String,
            default: ''
        }
    },
    computed: {
        dataComponent() {
            const chunks = [this.queryTypename, this.action, 'DataCard'];
            return chunks.map(this.pascalCase).join('');
        }
    },
    created() {
        const query = getRouteQueryFromFullPath(this.$route);
        if (query.pagination) {
            this.pagination = query.pagination;
        }
    },
    methods: {
        pascalCase(string) {
            return upperFirst(camelCase(string));
        }
    },
    beforeRouteEnter (to, from, next) {
        next(vm => {
            if (to.hash) {
                vm.$root.$emit('triggerScroll');
            }
        });
    }

};
</script>

<style scoped>

</style>
