import {CREATE_COMPONENT} from '../../../src/store/components/mutations';
import {HAS_COMPONENT} from '../../../src/store/components/getters';
import ComponentsStoreMx from '../../../src/mixins/ComponentsStoreMx';
import {cid, getWrapper} from '../components/utils';
import {getNamespacedStoreProp} from '../utils';


let componentOptions;

beforeEach(() => {
    componentOptions = {
        mixins: [ComponentsStoreMx],
        data: function () {
            return {
                cid: cid
            };
        }
    };
});

describe('ComponentsStoreMx', () => {
    describe('lifecycle', () => {
        it('calls created hook wit data cid', () => {
            const hasComponent = jest.fn();
            const mountOptions = {
                $store: {
                    state: {
                        components: {
                            all: {}
                        }
                    },
                    getters: {
                        [getNamespacedStoreProp('components', HAS_COMPONENT)]: hasComponent,
                    }
                }
            };
            const wrapper = getWrapper('mount', componentOptions, mountOptions);
            expect(hasComponent).toBeCalledWith(cid);
            expect(wrapper.vm.$store.commit).toHaveBeenCalledWith(
                getNamespacedStoreProp('components', CREATE_COMPONENT),
                {cid}
            );
        });
    });
});
