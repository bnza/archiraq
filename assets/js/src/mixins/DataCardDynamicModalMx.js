import {camelCase} from 'lodash';
import {pascalCase} from '@/utils/utils';
import DataCardMx from '@/mixins/DataCardMx';

/**
 * The slot component method to call parameters object
 * @typedef {Object} modalComponentMethodConfig
 * @property {string} method - Indicates the slot component method to call
 * @property {string} [ref] - Indicates the slot ref, default 'modalSlot'
 * @property {?Array} args - Indicates the slot component method parameters, default []
 *
 */

export default {
    mixins: [
        DataCardMx
    ],
    data() {
        return {
            modalComponentType: '',
            isModalVisible: false
        };
    },
    computed: {
        modalComponent() {
            return `DataCard${pascalCase(this.modalComponentType)}Dialog`;
        },
        modalSlotComponent() {
            return `${this.modalComponent}Slot`;
        },
    },
    methods: {
        /**
         *
         * @param {modalComponentMethodConfig} event
         */
        executeModalSlotMethod(event = {}) {
            const ref = event.ref || 'modalSlot';
            const args = event.args || [];
            if (!this.$refs.hasOwnProperty(ref)) {
                throw new Error(`No "${ref}" reference found in ${this.$options.name}`);
            }
            if (!event.hasOwnProperty('method')) {
                throw new Error('You must provide "method" property');
            }
            if (typeof(this.$refs[ref][event.method]) !== 'function') {
                throw new Error(`No "${event.method}" method found in ${this.$options.name}`);
            }
            this.$refs[ref][event.method](...args);
        },
        openModal(event) {
            this.modalComponentType = camelCase(event);
            this.isModalVisible = true;
        },
        closeModal() {
            this.isModalVisible = false;
        }
    },
};
