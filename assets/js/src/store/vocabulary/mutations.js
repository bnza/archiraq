export const SET_DISTRICTS = 'setDistricts';
export const SET_CHRONOLOGIES = 'setChronologies';

export default {
    [SET_DISTRICTS](state, districts) {
        state.districts = districts;
    },
    [SET_CHRONOLOGIES](state, chronologies) {
        state.chronologies = chronologies;
    },
};
