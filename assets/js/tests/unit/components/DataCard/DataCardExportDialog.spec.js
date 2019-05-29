import DataCardExportDialog from '@/components/DataCard/DataCardExportDialog';
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
        DataCardExportDialog,
        mountOptions
    );
});


describe('DataCardExportDialog', () => {
    describe('child components events', () => {
        describe('<export> button', () => {
            it('@click $emit "action" event', () => {
                wrapper.find('[data-test="export"]').vm.$emit('click');
                expect(wrapper.emitted('action')[0]).toEqual([{method: 'export'}]);
            });
        });
        describe('<clear> button', () => {
            it('@click $emit "action" event', () => {
                wrapper.find('[data-test="close"]').vm.$emit('click');
                expect(wrapper.emitted('update:visible')[0]).toEqual([false]);
            });
        });
    });
});
