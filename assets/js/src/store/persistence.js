import VuexPersistence from 'vuex-persist';
import Cookies from 'js-cookie';
import {SET_USER_TOKEN} from '@/store/geoserver/auth/mutations';

export const vuexCookie = new VuexPersistence({
    restoreState: (key) => Cookies.getJSON(key),
    saveState: (key, state) =>
        Cookies.set(key, state),
    reducer: (state) => ({
        geoserver: {
            auth: {
                token: state.geoserver.auth.token
            }
        }
    }),
    modules: ['geoserver'],
    filter: (mutation) => mutation.type === `geoserver/auth/${SET_USER_TOKEN}`
});
