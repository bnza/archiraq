import {
    STORE_M_ROOT_A_ENV_DATA,
    STORE_M_ROOT_M_BING_API_KEY,
    STORE_M_GS_M_BASE_URL,
    STORE_M_GS_AUTH_M_GUEST_TOKEN,
} from '../../../src/utils/constants';
import actions from '../../../src/store/actions';

describe('root actions', () => {
    describe(STORE_M_ROOT_A_ENV_DATA, () => {
        it('Success', () => {
            const commit = jest.fn();
            actions[STORE_M_ROOT_A_ENV_DATA](
                {
                    commit
                },
                {
                    bingApiKey: 'BingApiKeyStringValue',
                    geoServer: {
                        baseUrl: 'baseUrlStringValue',
                        guestAuth: 'authStringValue'
                    }
                }
            );
            expect(commit).toBeCalledTimes(3);
            expect(commit).toHaveBeenNthCalledWith(1, STORE_M_ROOT_M_BING_API_KEY, 'BingApiKeyStringValue');
            expect(commit).toHaveBeenNthCalledWith(2, `geoserver/${STORE_M_GS_M_BASE_URL}`, 'baseUrlStringValue');
            expect(commit).toHaveBeenNthCalledWith(3, `geoserver/auth/${STORE_M_GS_AUTH_M_GUEST_TOKEN}`, {'auth': 'authStringValue'});
        });
    });
});
