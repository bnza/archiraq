import LoginDataCard from '../../../../src/components/DataCard/LoginDataCard';
import {getVuetifyWrapper, catchLocalVueDuplicateVueBug, resetConsoleError} from '../../components/utils';
import {getDataTestSelector} from '../../utils';

let wrapper;

beforeAll(() => {
    catchLocalVueDuplicateVueBug();
});

afterAll(() => {
    resetConsoleError();
});


describe('LoginDataCard', () => {
    describe('buttons', () => {
        it.skip('close click', done => {
            wrapper = getVuetifyWrapper(
                'shallowMount',
                LoginDataCard,
                {
                    mocks: {
                        $router: {
                            go: jest.fn().mockReturnValue(false),
                            push: jest.fn()
                        },
                        $store: {
                            state: {
                                route: {
                                    from: '/'
                                }
                            }
                        }
                    }
                }
            );
            const submit = wrapper.find(getDataTestSelector('v-btn--close'));
            submit.trigger('click');
            wrapper.vm.$nextTick(() => {
                //expect(wrapper.vm.$router.go).toHaveBeenCalledWith(-1);
                expect(wrapper.vm.$router.push).toHaveBeenCalledWith('/');
                done();
            });
        });
    });
});
