/* global Cypress, context, cy */
/// <reference types="Cypress" />

context('Window', () => {
    beforeEach(() => {
        const baseUrl = Cypress.config('baseUrl') || 'http://localhost';
        cy.fixture('archiraq/geomDistrictNames.json').as('districtNames');
        cy.fixture('bing/imageryMetadata.json').as('bingImageryMetadata');
        cy.fixture('bing/blankTile.png').as('blankTile');
        cy.server();
        cy.route('POST','/geoserver/wfs', {});
        cy.route('Imagery/Metadata/**', '@bingImageryMetadata');
        cy.route('tiles.virtualearth.net/tiles/**', '@bingImageryMetadata')
        cy.route('data/geom-district/names', '@blankTile');
        cy.route('GET','_wdt/**', '');
        cy.visit(baseUrl);
    });

    it('cy.window() - get the global window object', () => {
    // https://on.cypress.io/window
        cy.window().should('have.property', 'top');
    });
});
