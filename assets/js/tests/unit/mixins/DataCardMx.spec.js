import {cloneDeep} from 'lodash';
import {defaultPagination} from '@/store/query/index';
import DataCardMx from '@/mixins/DataCardMx';

describe('DataCardMx', () => {
    describe('methods', () => {
        it('getUrl', () => {
            let $this = {
                typename: 'vw-site',
                pagination: cloneDeep(defaultPagination)
            };
            expect(DataCardMx.methods.getUrl.call($this)).toEqual('data/vw-site?pagination%5Blimit%5D=25&pagination%5Boffset%5D=0&pagination%5Bsort%5D%5Bid%5D=ASC');
        });
        it('fetch', async () => {
            const getUrl = jest.fn().mockReturnValue('/some/url');
            const clientRequest = jest.fn().mockResolvedValue({
                data: {
                    items: [0,1],
                    totalItems: 2
                }
            });
            const $this = {
                getUrl,
                clientRequest,
                geoserver: {auth: {guest:'some-auth'}},
                totalItems: 0,
                items: []
            };
            await DataCardMx.methods.fetch.call($this);
            expect($this.items).toEqual([0,1]);
            expect($this.totalItems).toEqual(2);
        });
    });
});
