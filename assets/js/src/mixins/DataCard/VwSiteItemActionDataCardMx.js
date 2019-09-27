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
        fetchItem() {
            let vm = this;
            let axiosRequestConfig = {
                method: 'get',
                url: `/data/site/${this.itemId}`,
            };
            this.clientRequest(axiosRequestConfig).then((response) => {
                vm.item = response.data;
            });
        },
    }
};
