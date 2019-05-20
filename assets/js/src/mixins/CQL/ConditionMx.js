import Vue from 'vue';
import {getNullableWfsFilter, getConditionsWfsFilters} from '@/utils/WFS/filter';
import {and} from 'ol/format/filter';

/**
 * @see https://docs.geoserver.org/stable/en/user/filter/ecql_reference.html
 */
export default {
    data() {
        return {
            conditions: {}
        };
    },
    methods: {
        /**
         *
         * @param key
         * @return {Filter|null}
         */
        getFilter(key) {
            return this.conditions.hasOwnProperty(key) ?
                getNullableWfsFilter(this.conditions[key]) :
                null;
        },
        /**
         * @return {Filter[]}
         */
        getConditionsFilters() {
            return getConditionsWfsFilters(this.conditions);
        },
        /**
         * @return {null|And} - The ol And filter or null
         */
        getAndConditionsFilter() {
            const conditions = this.getConditionsFilters();
            if (conditions.length) {
                return conditions.length === 1 ? conditions[0] : and(...conditions);
            }
            return null;
        },
        setCondition({key, predicate}) {
            if (predicate === null) {
                this.unsetCondition(key);
            } else {
                this.$set(this.conditions, key, predicate);
            }
        },
        unsetCondition(key) {
            if (this.conditions.hasOwnProperty(key)) {
                Vue.delete(this.conditions, key);
            }
        },
    }
};
