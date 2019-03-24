import ComponentsStoreMx from './ComponentsStoreMx';
import {CID_THE_SNACKBAR} from '../utils/cids';


export default {
    mixins: [
        ComponentsStoreMx
    ],
    methods: {
        displaySnackbar(text, color='info') {
            this.componentsSetComponent({
                cid: CID_THE_SNACKBAR,
                obj: {
                    active: true,
                    text: text,
                    color: color
                }
            });
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
