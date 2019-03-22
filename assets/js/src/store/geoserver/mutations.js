export const SET_BASE_URL = 'setBaseUrl';
export const SET_ON = 'setOn';
export const SET_OFF = 'setOff';

export default {
    [SET_BASE_URL](state, baseUrl) {
        state.baseUrl = baseUrl;
    },
    [SET_ON](state) {
        state.on = true;
    },
    [SET_OFF](state) {
        state.on = false;
    }
};
