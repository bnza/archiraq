import {GET_GUEST_AUTH} from '@/store/geoserver/auth/getters';
import DataCardMx from '@/mixins/DataCardMx';
import {getWfsGetFeatureQueryString, setWfsGetFeaturePostRequestHeaders, mapWfsFeatureToTableItem} from '@/utils/wfs';

export default {
    mixins: [
        DataCardMx
    ],
    computed: {
        hitsTypeName() {
            return this.typename;
        },
        limitTypeName() {
            return this.typename;
        }
    },
    methods: {
        getUrl() {
            return this.$store.state.geoserver.baseUrl + 'wfs?' +
                getWfsGetFeatureQueryString('EPSG:4326', this.limitTypeName, this.filter, this.pagination);
        },
        fetch: async function () {
            let axiosRequestConfig = {
                method: 'get',
                url: this.getUrl(),
                //data: getLimitFeatureRequestXmlBody('EPSG:4326', this.limitTypeName, this.filter),
                headers: setWfsGetFeaturePostRequestHeaders({}, this.$store.getters[`geoserver/auth/${GET_GUEST_AUTH}`])
            };
            try {
                this.isRequestPending = true;
                const response = await this.clientRequest(axiosRequestConfig);
                this.items = response.data.features.map(mapWfsFeatureToTableItem);
                this.totalItems = response.data.numberMatched;
            } finally {
                this.isRequestPending = false;
            }
        },
    },
};
