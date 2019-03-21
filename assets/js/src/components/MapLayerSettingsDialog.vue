<template>
    <v-dialog
        v-model="visible"
        max-width="500px"
    >
        <v-tooltip
            slot="activator"
            bottom
        >
            <v-btn
                slot="activator"
                color="primary"
                icon
                flat
            >
                <v-icon>settings</v-icon>
            </v-btn>
            <span>Settings</span>
        </v-tooltip>
        <v-card>
            <v-card-title
                primary-title
            >
                <v-icon
                    left
                    class="grey--text"
                >
                    settings
                </v-icon>
                <span class="subheading">
                    {{ title }}
                </span>
            </v-card-title>
            <v-card-text>
                <v-container
                    fluid
                    grid-list-xl
                >
                    <slot :title="title" />
                </v-container>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
import {CID_MAP_LAYER_SETTINGS_DIALOG as CID} from '../utils/cids';

export default {
    name: CID,
    props: {
        title: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            visible: false
        };
    },
};
</script>
