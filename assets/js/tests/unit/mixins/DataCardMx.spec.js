import {state, defaultPagination} from '../../../src/store/query/index';
import DataCardMx from '../../../src/mixins/DataCardMx';
import {getNamespacedStoreProp} from '../utils';
import {GET_PAGINATION} from '../../../src/store/query/getters';
import {getWrapper} from '../components/utils';

let componentOptions;

beforeEach(() => {
    componentOptions = {
        mixins: [DataCardMx]
    };
});

describe('DataCardQueryMx', () => {
    describe('methods', () => {
        it('getUrl', () => {
            let $this = {
                typename: 'vw-site',
                pagination: defaultPagination
            };
            expect(DataCardMx.methods.getUrl.call($this)).toEqual('data/vw-site?pagination%5Blimit%5D=25&pagination%5Boffset%5D=0&pagination%5Bsort%5D%5Bid%5D=ASC');
        });
    });
});
