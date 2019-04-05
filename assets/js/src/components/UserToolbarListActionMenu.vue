<template>
    <v-menu
        v-model="menu"
        :nudge-width="200"
        offset-y
    >
        <template #activator="{ on: menu }">
            <v-tooltip bottom>
                <template #activator="{ on: tooltip }">
                    <v-btn
                        icon
                        v-on="{ ...tooltip, ...menu }"
                    >
                        <slot name="activator">
                            <v-icon :color="color">
                                {{ icon }}
                            </v-icon>
                        </slot>
                    </v-btn>
                </template>
                <span>User actions</span>
            </v-tooltip>
        </template>
        <v-list v-if="authIsAuthenticated">
            <v-list-tile @click="$router.push('/logout')">
                <v-list-tile-action>
                    <v-icon>power_settings_new</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                    <v-list-tile-title>Logout</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
        </v-list>
        <v-list v-else>
            <v-list-tile @click="$router.push('/login')">
                <v-list-tile-action>
                    <v-icon>exit_to_app</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                    <v-list-tile-title>Login</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
        </v-list>
    </v-menu>
</template>

<script>
import AuthMx from '../mixins/AuthMx';
export default {
    name: 'UserToolbarListActionMenu',
    mixins: [
        AuthMx
    ],
    data() {
        return {
            menu: false,
            tooltip: false
        };
    },
    computed: {
        color() {
            return this.authIsAuthenticated ? 'teal' : 'grey';
        },
        icon() {
            return this.authIsAuthenticated ? 'person' : 'person_outline';
        }
    }
};
</script>

<style scoped>

</style>
