/* global context, cy */
import {getDataTestSelector} from '../../unit/utils';
const TID_DRAWER = 'the-map-layers-drawer--aside';
const TID_SIDE_ICON = 'the-map-toolbar--side-icon';

context('<TheMapToolbar>', () => {
    beforeEach(() => {
        cy.visit('http://archiraq.local');
    });

    it('click on side button show/hide <TheMapLayersDrawer>', () => {
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
