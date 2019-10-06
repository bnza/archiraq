import actions from './actions';
import getters from './getters';

export const ROLE_GUEST = 'ROLE_GUEST';
export const ROLE_USER = 'ROLE_USER';
export const ROLE_EDITOR = 'ROLE_EDITOR';
export const ROLE_ADMIN= 'ROLE_ADMIN';

export const ROLES_HIERARCHY = [
    ROLE_GUEST,
    ROLE_USER,
    ROLE_EDITOR,
    ROLE_ADMIN
];

export const state = {};

export default {
    namespaced: true,
    state,
    getters,
    actions
};
