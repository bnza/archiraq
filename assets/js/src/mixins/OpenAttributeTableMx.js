/**
 * Config object used for attribute table URI fragment generation
 * @typedef {Object} OpenAttributeTableConfig
 * @property {string} table
 * @property {string} prefix - Default 'data'
 * @property {string} action - Default 'list'
 * @property {string} context - Default 'map'
 *
 */

/**
 *
 */
export default {
    methods: {
        /**
         * @param {OpenAttributeTableConfig}
         */
        openAttributeTable({
            table,
            context = 'map',
            prefix = 'data',
            action = 'list'
        }) {
            const path = `/${context}/${prefix}/${table}/${action}#data-table`;

            const pattern = new RegExp('^'+path);
            if (this.$route.fullPath.match(pattern)) {
                document.getElementById('data-table').scrollIntoView({behavior: 'smooth'});
            } else {
                this.$router.push(path);
            }
        }
    }
};
