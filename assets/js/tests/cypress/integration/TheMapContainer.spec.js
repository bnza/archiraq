/* global context, cy */
import {getDataTestSelector} from '../../unit/utils';


context('<TheMapToolbar>', () => {
    beforeEach(() => {
        cy.visit('http://archiraq.local');
    });

    context('default settings', () => {
        it('map has the expected height', () => {
            const TID_MAP_CONTAINER = 'the-map-container';
            const TID_DRAWER = 'the-map-layers-drawer--aside';
            const cyMapContainerSelector = getDataTestSelector(TID_MAP_CONTAINER);
            const cyDrawerSelector = getDataTestSelector(TID_DRAWER);
            cy.get(cyMapContainerSelector).then(($container) => {
                expect($container.height()).to.be.equal(500);
            });
            cy.get(cyDrawerSelector).then(($drawer) => {
                expect($drawer.height()).to.be.equal(500);
            });
        });

        it('Bing base map is visible', () => {
            const TID = 'base-map-tile-bingmaps';
            const cyBaseMapTile = getDataTestSelector(TID);
            cy.get(cyBaseMapTile).then(($baseMap) => {
                expect($baseMap[0].__vue__.visible).to.be.true;
            });
        });

        it('OpenStreetMap base map is not visible', () => {
            const TID = 'base-map-tile-osm';
            const cyBaseMapTile = getDataTestSelector(TID);
            cy.get(cyBaseMapTile).then(($baseMap) => {
                expect($baseMap[0].__vue__.visible).to.be.false;
            });
        });
    });
});
