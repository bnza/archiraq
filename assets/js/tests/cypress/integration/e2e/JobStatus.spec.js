/// <reference types="cypress" />
/* eslint-env mocha */
/* global cy */

context('<JobStatus>', () => {
    beforeEach(() => {
        cy.fixture('archiraq/job/status/e6243678_1.json').as('jobStatus_e6243678_1');
        cy.fixture('archiraq/job/status/e6243678_2.json').as('jobStatus_e6243678_2');
        cy.server();
        cy.route('job/e6243678cde0be2501a4cdab9c0db3da6b3c55a6/status', '@jobStatus_e6243678_1').as('jobStatus');
    });

    beforeEach(() => {
        cy.visit('http://archiraq.local/#/contribute/e6243678cde0be2501a4cdab9c0db3da6b3c55a6/status');
    });

    it('click on fullscreen button will change <TheMapContainerHeight>', () => {
        //cy.getElementByTestId('statusJobRow').find('i').should('contain','Job e6243678cde0be2501a4cdab9c0db3da6b3c55a6 status');
        cy.wait('@jobStatus').then(() => {
            cy.route('job/e6243678cde0be2501a4cdab9c0db3da6b3c55a6/status', '@jobStatus_e6243678_2');
        });
        //cy.getElementByTestId('statusJobRow').find('i').should('contain','error_outline');
    });
});
