import {CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2} from '../utils/constants';
import mutations from './mutations';
import actions from './actions';
import geoserver from './geoserver';
import components from './components';


export const state = {
    bingApiKey: '',
    default: {
        baseMap: 'bing',
        bingImagerySet: 'AerialWithLabels',
        currentLayer: CID_MAP_LAYER_VECTOR_WFS_ADMIN_BOUNDS_2
    }
};

export const getters = {};

export const options = {
    strict: true, //process.env.NODE_ENV !== 'production',
    state,
    mutations,
    getters,
    actions,
    modules: {
        components: components,
        geoserver: geoserver
    }
};

export default options;
