import {SET_CHRONOLOGIES, SET_DISTRICTS} from '@/store/vocabulary/mutations';
import {REQUEST} from '@/store/client/actions';

export const FETCH_DISTRICTS = 'fetchDistricts';
export const FETCH_CHRONOLOGIES = 'fetchChronologies';

export default {
    [FETCH_DISTRICTS] ({commit, dispatch}) {
        const axiosRequestConfig = {
            method: 'get',
            url: '/data/geom-district/names',
        };

        return dispatch(`client/${REQUEST}`, axiosRequestConfig, {root: true}).then((response) => {
            commit(SET_DISTRICTS, response.data);
        });
    },
    [FETCH_CHRONOLOGIES] ({commit, dispatch}) {
        const axiosRequestConfig = {
            method: 'get',
            url: '/data/voc-chronology/names',
        };

        return dispatch(`client/${REQUEST}`, axiosRequestConfig, {root: true}).then((response) => {
            commit(SET_CHRONOLOGIES, response.data);
        });
    }
};
