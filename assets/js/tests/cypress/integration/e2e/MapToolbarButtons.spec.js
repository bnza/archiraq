/* global context, cy */
import {getDataTestSelector} from '../../../unit/utils';
const TID_DRAWER = 'the-map-layers-drawer--aside';
const TID_MAP_CONTAINER = 'the-map-container';
const TID_DRAWER_ICON = 'icon--map-toggle-map-drawer';
const TID_FULLSCREEN_ICON = 'icon--map-toggle-fullscreen';

context('<TheMapToolbar>', () => {
    beforeEach(() => {
        cy.visit('http://archiraq.local/#/map');
    });

    it('click on fullscreen button will change <TheMapContainerHeight>', () => {
        const cyMapSelector = getDataTestSelector(TID_MAP_CONTAINER);
        const cyButtonSelector = getDataTestSelector(TID_FULLSCREEN_ICON);
        cy.get(cyMapSelector).then(($container) => {
            expect($container.css('height')).to.equal('500px');
        });

        cy.get(cyButtonSelector).click();

        cy.get(cyMapSelector).then(($container) => {
            expect($container.css('height')).to.equal('560px');
        });

        cy.get(cyButtonSelector).click();

        cy.get(cyMapSelector).then(($container) => {
            expect($container.css('height')).to.equal('500px');
        });
    });

    it('click on toggle button show/hide <TheMapLayersDrawer>', () => {
        const cyDrawerSelector = getDataTestSelector(TID_DRAWER);
        const cyButtonSelector = getDataTestSelector(TID_DRAWER_ICON);
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
