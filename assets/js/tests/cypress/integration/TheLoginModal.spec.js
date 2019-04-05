/* global context, cy */
import {getDataTestSelector} from '../../unit/utils';
const TID_USERNAME = 'v-text-field--username';
const TID_PASSWORD = 'v-text-field--password';
const TID_SUBMIT = 'v-btn--submit';

context('<TheLoginModal>', () => {
    beforeEach(() => {
        cy.visit('http://archiraq.local/#/login');
    });

    it('<LoginDataCardForm> validation works as expected', () => {
        const cyUsernameSelector = getDataTestSelector(TID_USERNAME);
        const cyPasswordSelector = getDataTestSelector(TID_PASSWORD);
        const cySubmitButtonSelector = getDataTestSelector(TID_SUBMIT);
        cy.get(cySubmitButtonSelector).then(($submit) => {
            expect($submit.is(':disabled')).to.be.true;
        });

        cy.get(cyUsernameSelector).type('user');

        cy.get(cySubmitButtonSelector).then(($submit) => {
            expect($submit.is(':disabled')).to.be.true;
        });

        cy.get(cyPasswordSelector).type('passwd');

        cy.get(cySubmitButtonSelector).then(($submit) => {
            expect($submit.is(':disabled')).to.be.false;
        });

        cy.get(cyPasswordSelector).clear();

        cy.get(cySubmitButtonSelector).then(($submit) => {
            expect($submit.is(':disabled')).to.be.true;
        });
    });

});
