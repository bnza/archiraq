import HttpClientMx from '@/mixins/HttpClientMx';
import {getFeatureQueryString, setWfsGetFeatureRequestHeaders} from '@/utils/wfs';
import {GET_GUEST_AUTH} from '@/store/geoserver/auth/getters';

/**
 * @typedef  {import('@/utils/wfs').HttpGetWFSGetFeatureConfig} HttpGetWFSGetFeatureConfig
 */
export default {
    mixins: [
        HttpClientMx
    ],
    computed: {
        geoserver() {
            return {
                auth: {
                    guest: this.$store.getters[`geoserver/auth/${GET_GUEST_AUTH}`]
                },
                baseUrl: this.$store.state.geoserver.baseUrl
            };
        }
    },
    methods: {
        getUrl(config) {
            return this.geoserver.baseUrl
                + 'wfs?'
                + getFeatureQueryString(config);
        },
        /**
         * @param {HttpGetWFSGetFeatureConfig} config
         * @param {Object} headers
         */
        performWfsGetFeatureRequest(config, headers = {}) {
            let axiosRequestConfig = {
                method: 'get',
                url: this.getUrl(config),
                headers: setWfsGetFeatureRequestHeaders(headers, this.geoserver.auth.guest)
            };
            return this.clientRequest(axiosRequestConfig).finally(
                () => {
                    this.isRequestPending = false;
                }
            );
        }
    }
};
