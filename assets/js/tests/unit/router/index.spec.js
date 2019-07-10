import { beforeEach as beforeEachFn} from '@/router';

let to;
const next = jest.fn();
const mockDisplaySnackbar = jest.fn();

jest.mock('@/mixins/SnackbarComponentStoreMx', () => ({ displaySnackbarFn: () => mockDisplaySnackbar }));
jest.mock('@/store/auth/getters');

import {isAuthenticated} from '@/store/auth/getters';

afterEach(() => {
    mockDisplaySnackbar.mockClear();
    next.mockClear();
});

describe('router', () => {
    describe('"beforeEach"', () => {
        describe('when no matching route found', () => {
            const to = {matched: []};
            it ('display a warning snackbar', () => {
                beforeEachFn(to, {}, next);
                expect(mockDisplaySnackbar).toHaveBeenCalledWith({'color': 'warning', 'text': 'Requested resource does not exist'});
            });
            it ('abort the navigation', () => {
                beforeEachFn(to, {}, next);
                expect(next).toHaveBeenCalledWith(false);
            });
        });
        describe('when route meta "requiresAuthenticated" is true', () => {
            beforeEach(() => {
                to = {
                    fullPath: '/some/path',
                    matched: [
                        {
                            meta: {
                                requiresAuthenticated: true
                            }
                        }
                    ]};
            });
            describe('when user is authenticated', () => {
                beforeEach(() => {
                    isAuthenticated.mockReturnValue(true);
                });
                it ('proceed the navigation', () => {
                    beforeEachFn(to, {}, next);
                    expect(next).toHaveBeenCalledWith(undefined);
                });
            });
            describe('when user is not authenticated', () => {
                beforeEach(() => {
                    isAuthenticated.mockReturnValue(false);
                });
                describe('when route meta "silentFail" is true', () => {
                    beforeEach(() => {
                        to.matched[0].meta.silentFail = true;
                    });
                    it ('abort the navigation', () => {
                        beforeEachFn(to, {}, next);
                        expect(next).toHaveBeenCalledWith(false);
                    });
                });
                it ('redirect to "login" route', () => {
                    beforeEachFn(to, {}, next);
                    expect(next).toHaveBeenCalledWith(expect.objectContaining({
                        path: '/login',
                    }));
                });
                it ('route query has "redirect" key', () => {
                    beforeEachFn(to, {}, next);
                    expect(next).toHaveBeenCalledWith(expect.objectContaining({
                        query: expect.objectContaining({
                            redirect: '/some/path',
                        }),
                    }));
                });
                it ('display a warning snackbar', () => {
                    beforeEachFn(to, {}, next);
                    expect(mockDisplaySnackbar).toHaveBeenCalledWith({'color': 'warning', 'text': 'You must authenticate to access this content'});
                });
            });
        });
    });
});

