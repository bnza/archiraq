import AuthMx from '@/mixins/AuthMx';
import {ROLE_EDITOR} from '@/store/auth';

describe('AuthMx', () => {
    describe('methods', () => {
        it('authHasRoleEditor', () => {
            let $this = {
                authHasRoleFn: jest.fn()
            };
            AuthMx.computed.authHasRoleEditor.call($this)
            expect($this.authHasRoleFn).toHaveBeenCalledWith(ROLE_EDITOR);
        });
    });
});
