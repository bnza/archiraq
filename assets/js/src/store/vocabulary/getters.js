export const FIND_DISTRICT_BY_NAME = 'findDistrictByName';
export const GET_DISTRICT_GOVERNORATE_NAME = 'getDistrictGovernorateName';
export const GET_DISTRICT_NATION_NAME = 'getDistrictNationName';

export default {
    [FIND_DISTRICT_BY_NAME]: (state) => (name) => {
        return state.districts.find((item) => {
            return item.name === name;
        });
    },
    [GET_DISTRICT_GOVERNORATE_NAME]: (state, getters) => (name) => {
        const district = getters[FIND_DISTRICT_BY_NAME](name);
        return district ? district['governorate'] : undefined;
    },
    [GET_DISTRICT_NATION_NAME]: (state, getters) => (name) => {
        const district = getters[FIND_DISTRICT_BY_NAME](name);
        return district ? district['nation'] : undefined;
    },
};
