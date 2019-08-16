export default {
    props: {
        feature: {
            type: Object,
            required: true
        }
    },
    computed: {
        properties() {
            return this.feature.properties || {};
        }
    }
};
