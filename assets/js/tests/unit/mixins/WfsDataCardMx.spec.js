jest.mock('@/utils/wfs');

import WfsDataCardMx from '@/mixins/WfsDataCardMx';
import {getFeatureQueryString, setWfsGetFeatureRequestHeaders, mapWfsFeatureToTableItem} from '@/utils/wfs';

beforeEach(() => {
    getFeatureQueryString.mockReset();
});

describe('WfsDataCardMx', () => {
    describe('methods', () => {
        it('fetch', async () => {
            //const getUrl = jest.fn().mockReturnValue('/some/url/wfs');
            const performWfsGetFeatureRequest = jest.fn().mockResolvedValue({
                data: {
                    features: [0,1],
                    numberMatched: 2
                }
            });
            const $this = {
                performWfsGetFeatureRequest,
                geoserver: {auth: {guest:'some-auth'}},
                totalItems: 0,
                items: [],
                typename: 'vw-site',
                filter: 'some-filter',
                pagination: 'some-pagination'
            };
            mapWfsFeatureToTableItem.mockReturnValue('item');
            await WfsDataCardMx.methods.fetch.call($this);
            expect(performWfsGetFeatureRequest).toHaveBeenCalledWith({
                typename: 'vw-site',
                filter: 'some-filter',
                pagination: 'some-pagination'
            });
            expect(mapWfsFeatureToTableItem).toHaveBeenCalledTimes(2);
            expect($this.items).toEqual(['item','item']);
            expect($this.totalItems).toEqual(2);
        });
    });
});
