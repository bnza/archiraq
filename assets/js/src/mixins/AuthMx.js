import {mapGetters} from 'vuex';
import {ROLE_EDITOR} from '@/store/auth';
import {GET_USERNAME, IS_AUTHENTICATED, HAS_ROLE} from '../store/auth/getters';

export default {
    computed: {
        ...mapGetters({
            authGetUsername: `auth/${GET_USERNAME}`,
            authIsAuthenticated: `auth/${IS_AUTHENTICATED}`,
            authHasRoleFn: `auth/${HAS_ROLE}`,
        }),
        authHasRoleEditor() {
            return this.authHasRoleFn(ROLE_EDITOR);
        }
    },
};
