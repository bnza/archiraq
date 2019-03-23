<template>
    <component
        :is="dataComponent"
        :action="action"
        :typename="typename"
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
            const chunks = [this.typename, this.action, 'DataCard'];
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
    }
};
</script>

<style scoped>

</style>
