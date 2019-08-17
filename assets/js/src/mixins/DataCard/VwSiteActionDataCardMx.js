import {snakeCase} from 'lodash';

export default {
    data() {
        return {
            cid: this.$options.name,
        };
    },
    props: {
        queryTypename  : {
            type: String,
            required: true
        },
        itemId  : {
            type: String,
            default: ''
        },
    },
    computed: {
        /**
         * Base typename: query name like string (e.g. "base_type_name") used as map layer id
         * @return {string}
         */
        baseTypename() {
            return snakeCase(this.queryTypename);
        },
        typename() {
            return `archiraq:${this.baseTypename}_poly`;
        }
    }
};
