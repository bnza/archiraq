import {mapActions, mapGetters} from 'vuex';
import {REQUEST, XSRF_REQUEST} from '../store/client/actions';
import {HAS_PENDING_REQUESTS, PENDING_REQUESTS_NUM} from '../store/client/getters';

export default {
    computed: {
        ...mapGetters({
            clientHasPendingRequests: `client/${HAS_PENDING_REQUESTS}`,
            clientPendingRequestsNum: `client/${PENDING_REQUESTS_NUM}`,
        })
    },
    methods: {
        ...mapActions({
            clientRequest: `client/${REQUEST}`,
            clientXsrfRequest: `client/${XSRF_REQUEST}`
        })
    }
};
