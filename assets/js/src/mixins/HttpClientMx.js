import {mapActions, mapGetters} from 'vuex';
import {REQUEST} from '../store/client/actions';
import {HAS_PENDING_REQUESTS, PENDING_REQUESTS_NUM} from '../store/client/getters';

export default {
    computed: {
        ...mapGetters({
            clientHasPendingRequests: `client/${HAS_PENDING_REQUESTS}`
        })
    },
    methods: {
        ...mapActions('client', [
            REQUEST
        ])
    }
};
