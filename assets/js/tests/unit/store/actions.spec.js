import Store from 'vuex-mock-store';
import {MUTATIONS as ROOT_MUTATIONS} from '../../../src/store/mutations';
import {MUTATIONS as GS_MUTATIONS} from '../../../src/store/geoserver/mutations';
import {MUTATIONS as GS_AUTH_MUTATIONS} from '../../../src/store/geoserver/auth/mutations';
import actions, {ACTIONS as ROOT_ACTIONS} from '../../../src/store/actions';

describe('root actions', () => {
    describe(ROOT_ACTIONS.SET_ENV_DATA, () => {
        it('Success', () => {
            const commit = jest.fn();
            actions[ROOT_ACTIONS.SET_ENV_DATA](
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
            expect(commit).toHaveBeenNthCalledWith(1, ROOT_MUTATIONS.SET_BING_API_KEY, 'BingApiKeyStringValue');
            expect(commit).toHaveBeenNthCalledWith(2, `geoserver/${GS_MUTATIONS.SET_BASE_URL}`, 'baseUrlStringValue');
            expect(commit).toHaveBeenNthCalledWith(3, `geoserver/auth/${GS_AUTH_MUTATIONS.SET_GUEST_TOKEN}`, {'auth': 'authStringValue'});
        });
    });
});