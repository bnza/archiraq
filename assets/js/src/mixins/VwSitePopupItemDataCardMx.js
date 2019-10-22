import WfsGetFeatureMx from '@/mixins/WfsGetFeatureMx';
import {getWfsFilter} from '@/utils/WFS/filter';

export default {
    mixins: [
        WfsGetFeatureMx
    ],
    data() {
        return {
            fullFeature: {}
        };
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
        featureId() {
            let properties = this.feature.properties || {};
            return properties.id;
        },
        properties() {
            return this.fullFeature.properties || {};
        }
    },
    methods: {
        fetchFeatureById(id, oldId) {
            if (!id) {
                return;
            }

            if (id === oldId) {
                return;
            }

            let config = {
                typename: this.typename.replace(/_point$/,'_poly'),
                filter: getWfsFilter('equalToFilter', ['id', id])
            };

            this.performWfsGetFeatureRequest(config).then(
                response => {
                    this.fullFeature = response.data.features[0];
                    if (this.fullFeature) {
                        this.$emit('fetched', this.fullFeature);
                    }
                }
            );
        }
    },
    watch: {
        featureId: {
            handler: 'fetchFeatureById',
            immediate: true
        }
    }
};
