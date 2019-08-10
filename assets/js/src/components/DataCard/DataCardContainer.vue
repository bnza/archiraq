<template>
    <component
        :is="dataComponent"
        id="data-table"
        :action="action"
        :query-typename="queryTypename"
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
        VwSiteSurveyListDataCard: () => import(
            /* webpackChunkName: "VwSiteListDataCard" */
            './VwSiteListDataCard'
        ),
        VwSiteRsListDataCard: () => import(
            /* webpackChunkName: "VwSiteListDataCard" */
            './VwSiteListDataCard'
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
