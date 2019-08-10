/* global context, cy */

import {getDataTestSelector} from '../../../../unit/utils';

const TID_DATA_CARD = 'vw-site-table--data-card';
const TID_ACTION_MENU = 'vw-site-table--action-menu';
const TID_DIALOG_EXPORT_CONTENT = 'vw-site-table--export-content';

const openDialog = () => {
    cy.get(getDataTestSelector(TID_DATA_CARD)).find('.v-toolbar__content .v-icon').click();
    cy.get(getDataTestSelector(TID_ACTION_MENU)).find ('> :nth-child(2)').click();
    cy.wait(100);
};

const setAliases = () => {
    openDialog();
    cy.get(getDataTestSelector(TID_DIALOG_EXPORT_CONTENT)).as('content');
    cy.get('@content').closest('.v-dialog').as('dialog');
};

context('<VwSiteExportDialogContent>', () => {
    beforeEach(() => {
        cy.setUpFunctionalTestRoutes();
    });

    context('Dialog', () => {
        beforeEach(() => {
            cy.cookieLocalSignIn('aUser', 'thePasswd', ['ROLE_USER']);
            cy.visit('http://archiraq.local/#/map/data/vw-site-survey/list#data-table');
            setAliases();
        });

        it('<close> button will close dialog', () => {
            cy.get('@dialog').should('not.have.css', 'display', 'none');
            cy.get('@dialog').find('[data-test="close"]').click();
            cy.get('@dialog').should('have.css', 'display', 'none');
        });

        it('<submit> button will close dialog', () => {
            cy.wait('@wfsGet').then(function (xhr) {
                expect(xhr.url).not.to.match(/content-disposition=attachment/);
            });
            cy.get('@dialog').should('not.have.css', 'display', 'none');
            cy.get('@dialog').find('[data-test="export"]').click();
            cy.wait('@wfsGet').then(function (xhr) {
                expect(xhr.url).to.match(/content-disposition=attachment/);
            });
        });
    });
});
