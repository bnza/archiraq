import DataCardFilterDialog from '@/components/DataCard/DataCardFilterDialog';
import {getVuetifyWrapper, catchLocalVueDuplicateVueBug, resetConsoleError} from '../../components/utils';

let wrapper;
let mountOptions;

beforeAll(() => {
    catchLocalVueDuplicateVueBug();
});

afterAll(() => {
    resetConsoleError();
});

beforeEach(() => {
    mountOptions = {
        propsData: {
            visible: true
        }
    };
    wrapper = getVuetifyWrapper(
        'shallowMount',
        DataCardFilterDialog,
        mountOptions
    );
});


describe('DataCardFilterDialog', () => {
    describe('child components events', () => {
        describe('<submit> button', () => {
            it('@click $emit "action" event', () => {
                wrapper.find('[data-test="submit"]').vm.$emit('click');
                expect(wrapper.emitted('action')[0]).toEqual([{method: 'submit'}]);
            });
        });
        describe('<clear> button', () => {
            it('@click $emit "action" event', () => {
                wrapper.find('[data-test="clear"]').vm.$emit('click');
                expect(wrapper.emitted('action')[0]).toEqual([{method: 'clear'}]);
            });
        });
    });
});