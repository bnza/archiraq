import {upperFirst, cloneDeep} from 'lodash';

export default {
    props: {
        items: {
            type: Array,
            default() {
                return [];
            }
        },
        type: {
            type: String,
            required: true,
            validator(value) {
                return ['chronology', 'survey'].indexOf(value) !== -1;
            }
        }
    },
    data() {
        return {
            newId: 0,
            item: null,
            dialog: ''
        };
    },
    computed: {
        dialogComponent() {
            return `VwSite${upperFirst(this.type)}${upperFirst(this.dialog)}DataCardForm`;
        },
    },
    methods: {
        openNewDialog() {
            this.item = {
                [this.type]: {}
            };
            this.dialog = 'new';
        },
        openEditDialog(item) {
            this.item = item;
            this.dialog = 'edit';
        },
        openDeleteDialog(item) {
            this.item = item;
            this.dialog = 'delete';
        },
        doChange(item) {
            this[`do${upperFirst(this.dialog)}`](item);
        },
        doNew(item) {
            item.id = --this.newId;
            const _items = cloneDeep(this.items);
            _items.push(item);
            this.$emit('change', _items);
        },
        findItemIndex(id) {
            return this.items.findIndex((_item) => {
                return _item.id === id;
            });
        },
        doEdit(item) {
            const i = this.findItemIndex(item.id);
            if (i !== -1) {
                const _items = cloneDeep(this.items);
                _items[i] = item;
                this.$emit('change', _items);
            }
        },
        doDelete(item) {
            const i = this.findItemIndex(item.id);
            if (i !== -1) {
                const _items = cloneDeep(this.items);
                _items.splice(i,1);
                this.$emit('change', _items);
            }
        }
    }
};
