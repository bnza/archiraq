/* global Cypress, cy */
// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
// Cypress.Commands.add("login", (email, password) => { ... })
//
//
// -- This is a child command --
// Cypress.Commands.add("drag", { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add("dismiss", { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This is will overwrite an existing command --
// Cypress.Commands.overwrite("visit", (originalFn, url, options) => { ... })

Cypress.Commands.add('simulateOpenLayersEvent', (ol, map, type, x, y, opt_shiftKey = undefined) => {
    let viewport = map.getViewport();
    let position = viewport.getBoundingClientRect();
    let clientX=position.left + x + (position.width / 2);
    let clientY= position.top + y + (position.height / 2);
    cy.get('canvas').trigger(type,
        x,
        y
    );
});

/**
 * Local only sign in using Cookie. For functional test only
 * @param {string} user
 * @param {string} password
 * @param {string[]} roles
 */
const cookieLocalSignIn = ({ user, password, roles=[]}) => {
    const auth = btoa(`${user}:${password}`);
    cy.setCookie('vuex', `{%22geoserver%22:{%22auth%22:{%22token%22:{%22auth%22:%22${auth}%22%2C%22roles%22:[${roles.join(',')}]}}}}`);
};
Cypress.Commands.add('cookieLocalSignIn', cookieLocalSignIn);

Cypress.Commands.add('setUpFunctionalTestRoutes', () => {
    cy.fixture('geoserver/wfs/emptyFeatureCollection.json').as('wfsEmptyFeatureCollection');
    cy.fixture('archiraq/geomDistrictNames.json').as('districtNames');
    cy.fixture('archiraq/someGeomDistrictNames.json').as('someDistrictNames');
    cy.fixture('archiraq/someVocChronologies.json').as('someVocChronologies');
    cy.fixture('bing/imageryMetadata.json').as('bingImageryMetadata');
    cy.fixture('bing/blankTile.png').as('blankTile');
    cy.server();
    cy.route('POST',/geoserver\/wfs/, '@wfsEmptyFeatureCollection').as('wfsPost');
    cy.route(/geoserver\/wfs/, '@wfsEmptyFeatureCollection').as('wfsGet');
    cy.route('Imagery/Metadata/**', '@bingImageryMetadata');
    cy.route('tiles.virtualearth.net/tiles/**', '@bingImageryMetadata');
    cy.route('data/geom-district/names', '@someDistrictNames');
    cy.route('data/voc-chronology/names', '@someVocChronologies');

    cy.route('GET','_wdt/**', '');
});

Cypress.Commands.add('containsElementTestId', (testId) => {
    return cy.contains(`[data-test="${testId}"]`);
});

Cypress.Commands.add('getElementByTestId', (testId) => {
    return cy.get(`[data-test="${testId}"]`);
});
