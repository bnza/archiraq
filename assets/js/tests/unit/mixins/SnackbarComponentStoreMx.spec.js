import SnackbarComponentStoreMx from '../../../src/mixins/SnackbarComponentStoreMx';
import {state} from '../../../src/store/components/index';
import {SET_COMPONENT, SET_COMPONENT_PROP} from '../../../src/store/components/mutations';
import {CID_THE_SNACKBAR} from '../../../src/utils/cids';
import {getWrapper} from '../components/utils';
import {getNamespacedStoreProp} from '../utils';

let componentOptions;

beforeEach(() => {
    componentOptions = {
        mixins: [SnackbarComponentStoreMx]
    };
});

describe('ComponentsStoreMx', () => {
    describe('methods', () => {
        it ('"displaySnackbar" will update store', () => {
            const mountOptions = {
                $store: {
                    state: {
                        components: state
                    }
                }
            };
            const wrapper = getWrapper('mount', componentOptions, mountOptions);
            wrapper.vm.displaySnackbar('The message', 'warning');
            expect(wrapper.vm.$store.commit).toHaveBeenCalledWith(
                getNamespacedStoreProp('components', SET_COMPONENT),
                {
                    cid: CID_THE_SNACKBAR,
                    obj:{
                        text: 'The message',
                        color: 'warning',
                        active: true
                    }
                }
            );
        });
        it ('"hideSnackbar" will update store', () => {
            const mountOptions = {
                $store: {
                    state: {
                        components: state
                    }
                }
            };
            const wrapper = getWrapper('mount', componentOptions, mountOptions);
            wrapper.vm.hideSnackbar('The message', 'warning');
            expect(wrapper.vm.$store.commit).toHaveBeenCalledWith(
                getNamespacedStoreProp('components', SET_COMPONENT_PROP),
                {
                    cid: CID_THE_SNACKBAR,
                    prop: 'active',
                    value: false
                }
            );
        });
    });
});
