import {cloneDeep} from 'lodash';
import {defaultPagination} from '@/store/query/index';
import DataCardMx from '@/mixins/DataCardMx';

describe('DataCardQueryMx', () => {
    describe('methods', () => {
        it('getUrl', () => {
            let $this = {
                typename: 'vw-site',
                pagination: cloneDeep(defaultPagination)
            };
            expect(DataCardMx.methods.getUrl.call($this)).toEqual('data/vw-site?pagination%5Blimit%5D=25&pagination%5Boffset%5D=0&pagination%5Bsort%5D%5Bid%5D=ASC');
        });
    });
});
