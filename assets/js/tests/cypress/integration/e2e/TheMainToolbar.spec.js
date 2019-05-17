/* global context, cy */
import {getDataTestSelector} from '../../../unit/utils';
const TID_DRAWER = 'the-main-navigation-drawer--aside';
const TID_SIDE_ICON = 'the-main-toolbar--side-icon';

context('<TheMainToolbar>', () => {
    beforeEach(() => {
        cy.visit('http://archiraq.local');
    });

    it('click on left button show/hide <TheMainNavigationDrawer>', () => {
        const cyDrawerSelector = getDataTestSelector(TID_DRAWER);
        const cyButtonSelector = getDataTestSelector(TID_SIDE_ICON);
        cy.get(cyDrawerSelector).then(($drawer) => {
            expect($drawer.hasClass('v-navigation-drawer--close')).to.be.true;
        });

        cy.get(cyButtonSelector).click();

        cy.get(cyDrawerSelector).then(($drawer) => {
            expect($drawer.hasClass('v-navigation-drawer--open')).to.be.true;
        });

        cy.get(cyButtonSelector).click({force: true});

        cy.get(cyDrawerSelector).then(($drawer) => {
            expect($drawer.hasClass('v-navigation-drawer--close')).to.be.true;
        });
    });

});
