import {MUTATIONS} from './mutations';
import {GETTERS} from './getters';
import AUTH from './auth';

export default {
    GETTERS: GETTERS,
    MUTATIONS: MUTATIONS,
    MODULES: {
        AUTH: AUTH
    }
};

