import {mapGetters} from 'vuex';
import {GET_USERNAME, IS_AUTHENTICATED} from '../store/auth/getters';

export default {
    computed: {
        ...mapGetters({
            authGetUsername: `auth/${GET_USERNAME}`,
            authIsAuthenticated: `auth/${IS_AUTHENTICATED}`,
        })
    },
};
