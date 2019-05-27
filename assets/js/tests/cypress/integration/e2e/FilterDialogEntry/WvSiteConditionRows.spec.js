/* global context, cy */
import {getDataTestSelector} from '../../../../unit/utils';

const TID_DATA_CARD = 'vw-site-table--data-card';
const TID_ACTION_MENU = 'vw-site-table--action-menu';
const TID_DIALOG_CONDITION_ROWS = 'vw-site-table--condition-rows';

const emptyFeatureCollection = {'type':'FeatureCollection','features':[],'totalFeatures':0,'numberMatched':0,'numberReturned':0,'timeStamp':'2019-05-24T19:36:15.334Z','crs':null};
const districts = [{'id':78,'name':'Abu Al-Khaseeb','governorate':'Basrah'},{'id':80,'name':'Abu Ghraib','governorate':'Baghdad'},{'id':109,'name':'Adhamia','governorate':'Baghdad'},{'id':48,'name':'Afaq','governorate':'Qadissiya'},{'id':36,'name':'Ain Al-Tamur','governorate':'Kerbala'},{'id':27,'name':'Akre','governorate':'Ninewa'}];
const chronologies = [{'id':2,'code':'UBA','name':'UBAID','date_low':-6500,'date_high':-4000},,{'id':11,'code':'EDA','name':'EARLY DYNASTIC','date_low':-2900,'date_high':-2350},{'id':17,'code':'AKK','name':'AKKADIAN/POST AKKADIAN','date_low':-2350,'date_high':-2100},,{'id':36,'code':'ISLA','name':'ISLAMIC','date_low':650,'date_high':1500}];

const inputAlias = (conditionKey, inputKey) => {
    return `__${conditionKey}__${inputKey}__`;
};

const conditionAlias = (conditionKey) => {
    return `__condition__${conditionKey}__`;
};

const openDialog = () => {
    cy.get(getDataTestSelector(TID_DATA_CARD)).find('.v-toolbar__content .v-icon').click();
    cy.get(getDataTestSelector(TID_ACTION_MENU)).find ('> :nth-child(1)').click();
};

const setAliases = () => {
    openDialog();
    cy.get(getDataTestSelector(TID_DIALOG_CONDITION_ROWS)).as('conditions');
    cy.get('@conditions').closest('.v-dialog').as('dialog');
};

const getCondition = (key) => {
    return cy.get('@conditions').find(getDataTestSelector(key)).as(conditionAlias(key));
};

const getConditionInput = function(conditionKey, inputKey)  {
    return getCondition(conditionKey).find(conditionInputs[conditionKey][inputKey].selector).as(inputAlias(conditionKey, inputKey));
};

const checkConditionValues = (conditionKey, valueKey) => {
    for (let inputKey in conditionInputs[conditionKey]) {
        const conditionInputItem = conditionInputs[conditionKey][inputKey];
        if (conditionInputItem.hasOwnProperty(valueKey)) {
            getConditionInput(conditionKey, inputKey).then(($input) => {
                const valueKeyItem = conditionInputItem[valueKey];
                if (Array.isArray(valueKeyItem)) {
                    let expected = valueKeyItem[1];
                    let actual = valueKeyItem[0]($input);
                    expect(actual).to.equal(expected);
                } else {
                    expect($input).to.have.value(valueKeyItem);
                }
            });
        }
    }
};

const setConditionValues = function(conditionKey, valueKey)  {
    for (let inputKey in conditionInputs[conditionKey]) {
        const inputItem = conditionInputs[conditionKey][inputKey];
        if (inputItem.hasOwnProperty('inputFn')) {
            let fn = inputItem.inputFn;
            let value = inputItem.hasOwnProperty(valueKey) ? inputItem[valueKey] : [];
            if (typeof(fn) === 'function') {
                fn(conditionKey, inputKey, value);
            } else {
                getConditionInput(conditionKey, inputKey)[fn](...value);
            }
        }
    }
};

const setVSelectValues = function(conditionKey, inputKey, inputValues) {
    getConditionInput(conditionKey, inputKey).click({force: true});
    cy.get('.menuable__content__active .v-list__tile__title').filter(
        function () {
            return inputValues.indexOf(cy.$$(this).text()) !== -1;
        }
    ).click({force:true});
};

const getSwitchValue = function ($input) {
    return $input.prop('checked');
};

const conditionInputs = {
    modernName: {                                                           //conditionKey
        negate: {
            selector: '> :nth-child(1) input',
            defaultValue: [getSwitchValue, false],
            inputFn: 'check',
            inputValue: [{force: true}],
            displayValue: [getSwitchValue, true]
        },
        attribute: {
            selector: '> :nth-child(2) input',
            defaultValue: 'Modern Name',
        },
        operator: {
            selector: '> :nth-child(3) .v-select__selections > input',
            defaultValue: '',
            inputFn: setVSelectValues,
            inputValue: ['ILIKE'],
        },
        value: {
            selector: '> :nth-child(4) input',
            defaultValue: '',
            inputFn: 'type',
            inputValue: ['tell%'],
            displayValue: 'tell%'
        }
    },
    district: {
        negate: {
            selector: '> :nth-child(1) input',
            defaultValue: [getSwitchValue, false],
            inputFn: 'check',
            inputValue: [{force: true}],
            displayValue: [getSwitchValue, true]
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
            inputFn: setVSelectValues,
            inputValue: ['Afaq'],
        }
    },
    chronology: {
        negate: {
            selector: '> :nth-child(1) input',
            defaultValue: [getSwitchValue, false],
            inputFn: 'check',
            inputValue: [{force: true}],
            displayValue: [getSwitchValue, true]
        },
        attribute: {
            selector: '> :nth-child(2) input',
            defaultValue: 'Chronology',
        },
        operator: {
            selector: '> :nth-child(3) input',
            defaultValue: '=',
        },
        value: {
            selector: '> :nth-child(4) .v-select__selections > input',
            defaultValue: '',
            inputFn: setVSelectValues,
            inputValue: ['UBAID'],
        }
    }
};

context('<VwSiteConditionRows>', () => {
    beforeEach(() => {

        cy.server();

        cy.route('GET','_wdt/**', '');
        cy.route('data/geom-district/names', districts);
        cy.route('data/voc-chronology/names', chronologies);
        cy.route('POST','/geoserver/wfs', emptyFeatureCollection).as('wfsPost');
        cy.route(/geoserver\/wfs/, emptyFeatureCollection).as('wfsGet');
        cy.visit('http://archiraq.local/#/map/data/vw-site/list#data-table');
        setAliases();
    });

    it.skip('when open has default condition values', () => {
        for (let conditionKey in conditionInputs) {
            checkConditionValues(conditionKey, 'defaultValue');
            cy.get(`@${conditionAlias(conditionKey)}`).should('not.have.class','valid');
        }
    });

    it('valid values input does work', function()  {
        for (let conditionKey in conditionInputs) {
            setConditionValues(conditionKey, 'inputValue');
            cy.get(`@${conditionAlias(conditionKey)}`).should('have.class','valid');
        }
    });

    it.skip('"clear" button will restore default values', function()  {
        for (let conditionKey in conditionInputs) {
            setConditionValues(conditionKey, 'inputValue');
        }
        cy.get('@dialog').find(getDataTestSelector('clear')).click();
        for (let conditionKey in conditionInputs) {
            checkConditionValues(conditionKey, 'defaultValue');
            cy.get(`@${conditionAlias(conditionKey)}`).should('not.have.class','valid');
        }
    });

    it.skip('"submit" button will XHR request', function()  {
        for (let conditionKey in conditionInputs) {
            setConditionValues(conditionKey, 'inputValue');
        }
        cy.get('@dialog').find(getDataTestSelector('submit')).click();
        cy.wait('@wfsGet').then(function (xhr) {
            expect(xhr.url).not.to.match(/cql_filter=/);
        });
        cy.wait('@wfsGet').then(function (xhr) {
            expect(xhr.url).to.match(/cql_filter=/);
        });
    });

    it.skip('submitted values will be shown when dialog re-open', function()  {
        for (let conditionKey in conditionInputs) {
            setConditionValues(conditionKey, 'inputValue');
        }
        cy.get('@dialog').find(getDataTestSelector('submit')).click();
        cy.visit('http://archiraq.local/#/map');
        cy.visit('http://archiraq.local/#/map/data/vw-site/list#data-table');
        openDialog();
        for (let conditionKey in conditionInputs) {
            checkConditionValues(conditionKey, 'displayValue');
        }

    });
});
