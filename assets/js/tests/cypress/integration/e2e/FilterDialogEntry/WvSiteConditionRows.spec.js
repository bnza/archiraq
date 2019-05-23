/* global context, cy */
import {getDataTestSelector} from '../../../../unit/utils';

const TID_DATA_CARD = 'vw-site-table--data-card';
const TID_ACTION_MENU = 'vw-site-table--action-menu';
const TID_DIALOG_CONDITION_ROWS = 'vw-site-table--condition-rows';

const conditionInputs = {
    modernName: {
        negate: {
            selector: '> :nth-child(1) input',
            defaultValue: 'false',
            inputFn: 'check',
            inputValue: [{force: true}],
        },
        attribute: {
            selector: '> :nth-child(2) input',
            defaultValue: 'Modern Name',
        },
        operator: {
            selector: '> :nth-child(3) input',
            defaultValue: '',
        },
        value: {
            selector: '> :nth-child(4) input',
            defaultValue: '',
            inputFn: 'type',
            inputValue: ['tell%'],
        }
    },
    district: {
        negate: {
            selector: '> :nth-child(1) input',
            defaultValue: 'false'
        },
        attribute: {
            selector: '> :nth-child(2) input',
            defaultValue: 'District',
        },
        operator: {
            selector: '> :nth-child(3) input',
            defaultValue: '=',
        },
        value: {
            selector: '> :nth-child(4) .v-select__selections > input',
            defaultValue: '',
        }
    }
};

const inputAlias = (conditionKey, inputKey) => {
    return `__${conditionKey}__${inputKey}__`;
};

const setAliases = () => {
    cy.get(getDataTestSelector(TID_DATA_CARD)).find('.v-toolbar__content .v-icon').click();
    cy.get(getDataTestSelector(TID_ACTION_MENU)).find ('> :nth-child(1)').click();
    cy.get(getDataTestSelector(TID_DIALOG_CONDITION_ROWS)).as('conditions');
    cy.get('@conditions').closest('.v-dialog').as('dialog');
};

const getCondition = (key) => {
    return cy.get('@conditions').find(getDataTestSelector(key));
};

const getConditionInput = function(conditionKey, inputKey)  {
    return getCondition(conditionKey).find(conditionInputs[conditionKey][inputKey].selector).as(inputAlias(conditionKey, inputKey));
};

const checkConditionValues = (conditionKey, valueKey) => {
    for (let inputKey in conditionInputs[conditionKey]) {
        getConditionInput(conditionKey, inputKey).then(($input) => {
            expect($input).to.have.value(conditionInputs[conditionKey][inputKey][valueKey]);
        });
    }
};

const setConditionValues = function(conditionKey, valueKey)  {
    for (let inputKey in conditionInputs[conditionKey]) {
        const inputItem = conditionInputs[conditionKey][inputKey];
        if (inputItem.hasOwnProperty('inputFn')) {
            let alias = inputAlias(conditionKey, inputKey);
            let fn = inputItem.inputFn;
            let value = inputItem.hasOwnProperty(valueKey) ? inputItem[valueKey] : [];
            getConditionInput(conditionKey, inputKey);
            cy.get(`@${alias}`)[fn](...value);
        }

    }
};

context('<VwSiteConditionRows>', () => {
    beforeEach(() => {
        cy.visit('http://archiraq.local/#/map/data/vw-site/list#data-table');
        setAliases();
    });

    it.skip('when open has default condition values', () => {
        for (let conditionKey in conditionInputs) {
            checkConditionValues(conditionKey, 'defaultValue');
        }
    });

    context('condition input', () => {
        it('modern name', function()  {
            for (let conditionKey in conditionInputs) {
                setConditionValues(conditionKey, 'inputValue');
                //console.log(this, this[inputAlias(conditionKey, 'negate')]);
            }
        });
    });
});
