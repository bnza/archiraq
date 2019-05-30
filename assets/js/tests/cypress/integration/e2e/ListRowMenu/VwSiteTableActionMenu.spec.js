/* global context, cy */

import {getDataTestSelector} from '../../../../unit/utils';

const TID_DATA_CARD = 'vw-site-table--data-card';
const TID_ACTION_MENU = 'vw-site-table--action-menu';

context('<VwSiteTableActionMenu>', () => {
    beforeEach(() => {
        cy.setUpFunctionalTestRoutes();
    });
    //TODO move to <VwSiteTableActionMenu>
    context('Security', () => {
        it('when user is not legged in "Export Features" menu entry is not shown', () => {
            cy.visit('http://archiraq.local/#/map/data/vw-site/list#data-table');
            cy.get(getDataTestSelector(TID_DATA_CARD)).find('.v-toolbar__content .v-icon').click();
            cy.get(getDataTestSelector(TID_ACTION_MENU)).find('.v-list__tile__title').then(($titles) => {
                expect($titles.filter((i, el) => {
                    return cy.$$(el).text() === 'Export features';
                })).to.have.length(0);
            });
        });

        it('when user is legged in "Export Features" menu entry is shown', () => {
            cy.cookieLocalSignIn('aUser', 'thePasswd', ['ROLE_USER']);
            cy.visit('http://archiraq.local/#/map/data/vw-site/list#data-table');
            cy.get(getDataTestSelector(TID_DATA_CARD)).find('.v-toolbar__content .v-icon').click();
            cy.get(getDataTestSelector(TID_ACTION_MENU)).find('.v-list__tile__title').then(($titles) => {
                expect($titles.filter((i, el) => {
                    return cy.$$(el).text() === 'Export features';
                })).to.have.length(1);
            });
        });

    });
});
