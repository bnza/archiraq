<template>
    <v-menu
        v-model="menu"
        :nudge-width="200"
        offset-x
    >
        <template #activator="{ on: menu }">
            <v-tooltip bottom>
                <template #activator="{ on: tooltip }">
                    <v-btn
                        color="primary"
                        dark
                        :icon="isIcon"
                        v-on="{ ...tooltip, ...menu }"
                    >
                        <slot name="activator">
                            <v-icon>menu</v-icon>
                        </slot>
                    </v-btn>
                </template>
                <span>{{ tooltipText }}</span>
            </v-tooltip>
        </template>
        <slot />
    </v-menu>
</template>

<script>
export default {
    name: 'ListRowActionsMenu',
    props: {
        tooltipText: {
            type: String,
            default: 'Actions'
        },
        isIcon: {
            type: Boolean,
            default: true
        }
    },
    data() {
        return {
            menu: false,
            tooltip: false
        };
    }
};
</script>

<style scoped>

</style>
