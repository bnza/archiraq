import {GET_GUEST_AUTH} from '@/store/geoserver/auth/getters';
import DataCardMx from '@/mixins/DataCardMx';
import {getFeatureQueryString, setWfsGetFeatureRequestHeaders, mapWfsFeatureToTableItem} from '@/utils/wfs';

export default {
    mixins: [
        DataCardMx
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
        getUrl() {
            return  this.geoserver.baseUrl + 'wfs?' +
                getFeatureQueryString({
                    typename: this.typename,
                    filter: this.filter,
                    pagination: this.pagination
                });
        },
        //@TODO check exceptions
        fetch: async function () {
            let axiosRequestConfig = {
                method: 'get',
                url: this.getUrl(),
                headers: setWfsGetFeatureRequestHeaders({}, this.geoserver.auth.guest)
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
