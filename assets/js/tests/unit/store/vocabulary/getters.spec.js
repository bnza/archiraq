import getters, * as consts from '@/store/vocabulary/getters';

describe('store/vocabulary getters', () => {
    let state;
    const districts = [
        {
            'id': 78,
            'name': 'Abu Al-Khaseeb',
            'governorate': 'Basrah',
            'nation': 'Iraq'
        },
        {
            'id': 80,
            'name': 'Abu Ghraib',
            'governorate': 'Baghdad',
            'nation': 'Iraq'
        },
        {
            'id': 109,
            'name': 'Adhamia',
            'governorate': 'Baghdad',
            'nation': 'Iraq'
        }
    ];

    beforeEach(() => {
        state = {
            districts
        };
    });
    describe(`${consts.FIND_DISTRICT_BY_NAME}`, () => {
        it('find district', () => {
            expect(getters[consts.FIND_DISTRICT_BY_NAME](state)('Adhamia')).toEqual(districts[2]);
        });
        it('return undefined when not found', () => {
            expect(getters[consts.FIND_DISTRICT_BY_NAME](state)('Non Existent')).toEqual(undefined);
        });
    });
    describe(`${consts.GET_DISTRICT_GOVERNORATE_NAME}`, () => {
        it.each([
            ['Abu Al-Khaseeb', 'Basrah', jest.fn().mockReturnValue(districts[0])],
            ['Non Exixstent', undefined, jest.fn().mockReturnValue(undefined)],
        ])(`${consts.GET_DISTRICT_GOVERNORATE_NAME}('%s') returns %s` , (name, expected, getter) => {
            const mockGetters = {
                [consts.FIND_DISTRICT_BY_NAME]: getter
            };
            expect(getters[consts.GET_DISTRICT_GOVERNORATE_NAME](state, mockGetters)(name)).toEqual(expected);
        });
    });
    describe(`${consts.GET_DISTRICT_NATION_NAME}`, () => {
        it.each([
            ['Abu Al-Khaseeb', 'Iraq', jest.fn().mockReturnValue(districts[0])],
            ['Non Exixstent', undefined, jest.fn().mockReturnValue(undefined)],
        ])(`${consts.GET_DISTRICT_NATION_NAME}('%s') returns %s` , (name, expected, getter) => {
            const mockGetters = {
                [consts.FIND_DISTRICT_BY_NAME]: getter
            };
            expect(getters[consts.GET_DISTRICT_NATION_NAME](state, mockGetters)(name)).toEqual(expected);
        });
    });
});
