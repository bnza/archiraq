import HttpClientMx from '@/mixins/HttpClientMx';
import VwSiteActionDataCardMx from '@/mixins/DataCard/VwSiteActionDataCardMx';

export default {
    mixins: [
        HttpClientMx,
        VwSiteActionDataCardMx
    ],
    data() {
        return {
            item: null
        };
    },
    watch: {
        itemId() {
            this.fetchItem();
        }
    },
    mounted() {
        this.fetchItem();
    },
    methods: {
        fetchCallback() {},
        fetchItem() {
            let axiosRequestConfig = {
                method: 'get',
                url: `/data/site/${this.itemId}`,
            };
            return this.clientRequest(axiosRequestConfig).then((response) => {
                this.item = response.data;
                this.fetchCallback();
            });
        },
    }
};
