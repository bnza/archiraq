import {createLocalVue, mount} from '@vue/test-utils'
import Vuetify from "vuetify";
import {Store} from '../store/MockStore'
import {silenziateLocalVueDuplicateVueBug, resetConsoleError} from '../utils'
import {defaultState as defaultComponentsState} from '../store/components/utils'
import TheMainTopToolbar from '../../src/components/TheMainTopToolbar'
import {MUTATIONS} from '../../src/store/components/mutations'

let logError
let localVue
let mocks = {}

const setStore = (state = {}, getters = {}, spy) => {
    mocks['$store'] = new Store({
        state: state,
        getters: getters,
        spy: spy
    })
}

beforeAll(() => {
    logError = silenziateLocalVueDuplicateVueBug()
});

afterAll(() => {
    return resetConsoleError(logError);
});

beforeEach(() => {
    localVue = createLocalVue();
    localVue.use(Vuetify)
});

afterEach(() => mocks.$store.reset())

describe('TheMainTopToolbar', () => {
    let wrapper
    describe('interaction', () => {
        beforeEach(() => {
            setStore(defaultComponentsState)
            wrapper = mount(TheMainTopToolbar, {localVue, mocks, propsData: {cidP: 'dummy-component'}})
        })

        it('v-toolbar-side-icon @click toggle "the-main-navigation-drawer"."visible" prop', () => {
            wrapper.vm.$_ComponentStoreMx_mutation = jest.fn()
            wrapper.find('button.v-toolbar__side-icon').trigger('click')
            expect(wrapper.vm.$_ComponentStoreMx_mutation).toHaveBeenCalledTimes(1)
            expect(wrapper.vm.$_ComponentStoreMx_mutation).toHaveBeenCalledWith(MUTATIONS.PROP.TOGGLE, {
                "cid": "the-main-navigation-drawer",
                "prop": "visible"
            })
        })
    })
})