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
            beforeEach(() => {
                wrapper.find('[data-test="submit"]').vm.$emit('click');
            })
            it('@click $emit "action" (submit) event', () => {
                expect(wrapper.emitted('action')[0]).toEqual([{method: 'submit'}]);
            });
            it('@click $emit "update:visible" (false) event', () => {
                wrapper.find('[data-test="submit"]').vm.$emit('click');
                expect(wrapper.emitted('update:visible')[0]).toEqual([false]);
            });
        });
        describe('<clear> button', () => {
            it('@click $emit "action" (clear) event', () => {
                wrapper.find('[data-test="clear"]').vm.$emit('click');
                expect(wrapper.emitted('action')[0]).toEqual([{method: 'clear'}]);
            });
        });
        describe('<close> button', () => {
            it('@click $emit "update:visible" (false) event', () => {
                wrapper.find('[data-test="clear"]').vm.$emit('click');
                expect(wrapper.emitted('action')[0]).toEqual([{method: 'clear'}]);
            });
        });
    });
});
