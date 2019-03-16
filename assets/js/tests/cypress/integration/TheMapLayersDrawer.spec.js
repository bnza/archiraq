/* global context, cy */
import {getDataTestSelector} from '../../unit/utils';
const TID_SIDE_ICON = 'the-map-toolbar--side-icon';
const TID_TILE_GROUP_BASE_MAP = 'map-legend-list-group--base-maps';
const TID_CHECKBOX_BING = 'the-map-layers-drawer--checkbox-base-map-bing-visibility';
const TID_CHECKBOX_OSM = 'the-map-layers-drawer--checkbox-base-map-osm-visibility';


context('<TheMapLayersDrawer>', () => {
    beforeEach(() => {
        cy.visit('http://archiraq.local');
    });

    it('click base map <MapLegendLayerListTile> checkbox will toggle visibility', () => {
        //Opening drawer
        let cyButtonSelector = getDataTestSelector(TID_SIDE_ICON);

        cy.get(cyButtonSelector).click();

        cy.wait(100);

        //Opening tile group
        cyButtonSelector = getDataTestSelector(TID_TILE_GROUP_BASE_MAP);

        cy.get(cyButtonSelector).debug();
        cy.get(`${cyButtonSelector} .v-list__group__header__append-icon`).click();

        cyButtonSelector = getDataTestSelector(TID_CHECKBOX_OSM);

        cy.get(`${cyButtonSelector} input`).check({force: true});

        const TID_BASE_MAP_OSM = 'base-map-tile-osm';
        const cyBaseMapTileOsm = getDataTestSelector(TID_BASE_MAP_OSM);
        cy.get(cyBaseMapTileOsm).then(($baseMap) => {
            expect($baseMap[0].__vue__.visible).to.be.true;
        });

        const TID_BASE_MAP_BING = 'base-map-tile-bingmaps';
        const cyBaseMapTileBing = getDataTestSelector(TID_BASE_MAP_BING);
        cy.get(cyBaseMapTileBing).then(($baseMap) => {
            expect($baseMap[0].__vue__.visible).to.be.false;
        });

        cyButtonSelector = getDataTestSelector(TID_CHECKBOX_BING);

        cy.get(`${cyButtonSelector} input`).check({force: true});

        cy.get(cyBaseMapTileOsm).then(($baseMap) => {
            expect($baseMap[0].__vue__.visible).to.be.false;
        });

        cy.get(cyBaseMapTileBing).then(($baseMap) => {
            expect($baseMap[0].__vue__.visible).to.be.true;
        });

    });

});
