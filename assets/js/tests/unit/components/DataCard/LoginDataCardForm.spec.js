import LoginDataCardForm from '../../../../src/components/DataCard/LoginDataCardForm';
import {getVuetifyWrapper, catchLocalVueDuplicateVueBug, resetConsoleError} from '../../components/utils';

let wrapper;

//Vue.use(Vuetify);

beforeAll(() => {
    catchLocalVueDuplicateVueBug();
});

afterAll(() => {
    resetConsoleError();
});


describe('LoginDataCardForm', () => {
    describe('watch', () => {
        it.skip('isValidationInvalid emit "update:isInvalid"', done => {
            wrapper = getVuetifyWrapper(
                'shallowMount',
                LoginDataCardForm,
                {
                    propsData: {
                        item: {
                            username: '',
                            password: ''
                        },
                        isRequestPending: false,
                        isInvalid: true
                    }
                }
            );
            expect(wrapper.vm.$v.$invalid).toEqual(true);
            expect(wrapper.vm.isInvalid).toEqual(true);
            wrapper.setProps({item: {username: 'user', password: 'passwd'}});
            //https://github.com/vuelidate/vuelidate/issues/384
            //wrapper.vm.$forceUpdate();
            wrapper.vm.$nextTick(() => {
                expect(wrapper.vm.$v.$invalid).toEqual(false);
                /*                 expect(wrapper.vm.isInvalid).toEqual(false);
                               expect(wrapper.emitted('update:isInvalid')).toBeTruthy();
                                expect(wrapper.emitted('update:isInvalid').length).toBe(1);
                                expect(wrapper.emitted('update:isInvalid')[0]).toEqual([false]);*/
                done();
            });
        });
    });
});
