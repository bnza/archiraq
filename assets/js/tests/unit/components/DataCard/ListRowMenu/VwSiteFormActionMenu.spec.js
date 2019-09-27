import VwSiteFormActionMenu from '@/components/DataCard/ListRowMenu/VwSiteFormActionMenu';
import {getVuetifyWrapper, catchLocalVueDuplicateVueBug, resetConsoleError} from '../../../components/utils';

let wrapper;

beforeAll(() => {
    catchLocalVueDuplicateVueBug();
});

afterAll(() => {
    resetConsoleError();
});

describe('VwSiteFormActionMenu', () => {
    describe('rendering', () => {
        it.each([
            [true, 1],
            [false, 0]
        ])('When auth has role editor (%s) editor action tile is rendered (%i)', (hasRole, expected) => {
            wrapper = getVuetifyWrapper('shallowMount', VwSiteFormActionMenu, {
                computed: {
                    authHasRoleEditor: () => hasRole
                }
            });
            expect(wrapper.findAll('[data-test="edit-tile"]')).toHaveLength(expected);
        });
    });
    describe('child events', () => {
        it('edit <v-list-tile> @click trigger "edit" event', () => {
            wrapper = getVuetifyWrapper('shallowMount', VwSiteFormActionMenu, {
                computed: {
                    authHasRoleEditor: () => true
                }
            });
            wrapper.find('[data-test="edit-tile"]').vm.$emit('click');
            expect(wrapper.emitted().edit).toBeTruthy();
        });
    });
});
