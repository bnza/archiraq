jest.mock('@/utils/wfs');

import WfsDataCardMx from '@/mixins/WfsDataCardMx';
import {getFeatureQueryString, setWfsGetFeatureRequestHeaders, mapWfsFeatureToTableItem} from '@/utils/wfs';

beforeEach(() => {
    getFeatureQueryString.mockReset();
});

describe('WfsDataCardMx', () => {
    describe('methods', () => {
        it('getUrl', () => {
            const $this = {
                geoserver: {baseUrl: '/some/base/url/'},
                typename: 'vw-site',
                filter: 'some-filter',
                pagination: 'some-pagination'
            };
            getFeatureQueryString.mockReturnValue('feature-query-string');
            expect(WfsDataCardMx.methods.getUrl.call($this)).toEqual('/some/base/url/wfs?feature-query-string');
            expect(getFeatureQueryString).toHaveBeenCalledWith({
                typename: 'vw-site',
                filter: 'some-filter',
                pagination: 'some-pagination'
            });
        });
        it('fetch', async () => {
            const getUrl = jest.fn().mockReturnValue('/some/url/wfs');
            const clientRequest = jest.fn().mockResolvedValue({
                data: {
                    features: [0,1],
                    numberMatched: 2
                }
            });
            const $this = {
                getUrl,
                clientRequest,
                geoserver: {auth: {guest:'some-auth'}},
                totalItems: 0,
                items: [],
                typename: 'vw-site',
                filter: 'some-filter',
                pagination: 'some-pagination'
            };
            setWfsGetFeatureRequestHeaders.mockReturnValue({some: 'headers'});
            mapWfsFeatureToTableItem.mockReturnValue('item');
            await WfsDataCardMx.methods.fetch.call($this);
            expect(setWfsGetFeatureRequestHeaders).toHaveBeenCalledWith({}, 'some-auth');
            expect(mapWfsFeatureToTableItem).toHaveBeenCalledTimes(2);
            expect($this.items).toEqual(['item','item']);
            expect($this.totalItems).toEqual(2);
        });
    });
});
