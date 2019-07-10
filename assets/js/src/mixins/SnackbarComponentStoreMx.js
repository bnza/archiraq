import {SET_COMPONENT} from '@/store/components/mutations';
import ComponentsStoreMx from './ComponentsStoreMx';
import {CID_THE_SNACKBAR} from '../utils/cids';


/**
 * @typedef {Object} SnackbarOptions
 * @property {boolean} [active]
 * @property {String} [text]
 * @property {string} [color]
 */

export const displaySnackbarFn = (store) => (
    /**
     *
     * @param {String} text
     * @param {String} color
     * @return {never}
     */
    ({text, color='info'}) => (
        store.commit(`components/${SET_COMPONENT}`, {
            cid: CID_THE_SNACKBAR,
            obj: {
                active: true,
                text: text,
                color: color
            }
        })
    )
);

export default {
    mixins: [
        ComponentsStoreMx
    ],
    methods: {
        displaySnackbar(text, color='info') {
            displaySnackbarFn(this.$store)({text,color});
        },
        hideSnackbar() {
            this.componentsSetComponentProp({
                cid: CID_THE_SNACKBAR,
                prop: 'active',
                value: false
            });
        }
    }
};
