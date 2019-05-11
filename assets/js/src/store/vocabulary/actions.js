import {SET_DISTRICTS} from '@/store/vocabulary/mutations';
import {REQUEST} from '@/store/client/actions';

export const FETCH_DISTRICTS = 'fetchDistricts';

export default {
    [FETCH_DISTRICTS] ({commit, dispatch}) {
        const axiosRequestConfig = {
            method: 'get',
            url: '/data/geom-district/names',
        };

        return dispatch(`client/${REQUEST}`, axiosRequestConfig, {root: true}).then((response) => {
            commit(SET_DISTRICTS, response.data);
        });
    }
};
