<template>
    <v-snackbar
        v-model="active"
        :timeout="timeout"
        :color="color"
        top
        vertical
    >
        {{ text }}
        <v-btn
            dark
            flat
            @click.native="active = false"
        >
            Close
        </v-btn>
    </v-snackbar>
</template>

<script>
import {CID_THE_SNACKBAR as CID} from '../utils/cids';
import ComponentsStoreMx from '../mixins/ComponentsStoreMx';

export default {
    name: CID,
    mixins: [
        ComponentsStoreMx
    ],
    data() {
        return {
            cid: CID
        };
    },
    computed: {
        active: {
            get () {
                return this.getProp('active');
            },
            set (value) {
                this.setProp('active', value);
            }
        },
        text: {
            get () {
                return this.getProp('text');
            },
            set (value) {
                this.setProp('text', value);
            }
        },
        color: {
            get () {
                return this.getProp('color');
            },
            set (value) {
                this.setProp('color', value);
            }
        },
        timeout() {
            return this.color === 'error' ? 0 : 6000;
        }
    },
    created() {
        this.componentsSetComponent({
            cid: CID,
            obj: {
                active: false,
                message: '',
                color: 'info'
            }
        });
    }
};
</script>

<style scoped>

</style>
