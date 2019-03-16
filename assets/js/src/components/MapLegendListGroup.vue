<template>
    <v-list-group
        :prepend-icon="icon"
        no-action
        :data-test="tid"
    >
        <v-list-tile
            slot="activator"
        >
            <v-list-tile-content>
                <v-list-tile-title>{{ title }}</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>
        <slot />
    </v-list-group>
</template>

<script>
import kebabCase from 'lodash/kebabCase';

export const CID = 'MapLegendListGroup';
export default {
    name: CID,
    props: {
        icon: {
            type: String,
            required: true
        },
        title: {
            type: String,
            required: true
        }
    },
    computed: {
        tid() {
            return kebabCase(CID) + '--' + kebabCase(this.title);
        }
    }
};
</script>

<style scoped>

</style>
