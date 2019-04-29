import DataCardQueryMx from './DataCardQueryMx';
import HttpClientMx from './HttpClientMx';
import {getHttpQueryString} from '../utils/httpRequestQuery';

export default {
    mixins: [
        DataCardQueryMx,
        HttpClientMx,
    ],
    props: {
        action: {
            type: String,
            required: true
        },
    },
    data() {
        return {
            sortDefaultField: 'id',
            items: [],
            totalItems: 0,
            isRequestPending: false
        };
    },
    methods: {
        getUrl() {
            const query = getHttpQueryString({pagination: this.pagination});
            return `data/${this.typename}?${query}`;
        },
        fetch: async function () {
            let axiosRequestConfig = {
                method: 'get',
                url: this.getUrl(),
            };
            try {
                this.isRequestPending = true;
                const response = await this.clientRequest(axiosRequestConfig);
                this.items = response.data.items;
                this.totalItems = response.data.totalItems;
            } finally {
                this.isRequestPending = false;
            }

        },
    },
    watch: {
        pagination: {
            handler: function (pagination) {
                if (pagination) {
                    //const route = getPaginatedRoute(this.$route, pagination);
                    //navigateToQuery(this.$router, route);
                    this.fetch();
                }
            },
            deep: true
        }
    }
};
