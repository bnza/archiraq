import Vue from 'vue';
import {and} from 'ol/format/filter';

const getIndexKey = /*@ PURE*/ function (index) {
    return `k${index}`;
};
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
        getConditions() {
            const conditions = [];
            for (let key in this.conditions) {
                conditions.push(this.conditions[key]);
            }
            return conditions;
        },
        getAndCondition() {
            const conditions = this.getConditions();
            if (conditions) {
                return conditions.length === 1 ? conditions[0] : and(conditions);
            }
            return null;
        },
        setCondition(index, condition) {
            if (condition === null) {
                this.unsetCondition(index);
            } else {
                this.$set(this.conditions, getIndexKey(index), condition);
            }
        },
        unsetCondition(index) {
            const key = getIndexKey(index);
            if (this.conditions.hasOwnProperty(key)) {
                Vue.delete(this.conditions, key);
            }
        },

    }
};
