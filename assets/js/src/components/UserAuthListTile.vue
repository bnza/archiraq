<template>
    <v-list-tile
        v-if="authIsAuthenticated"
        @click="$router.push('/logout')"
    >
        <v-list-tile-action>
            <v-icon>power_settings_new</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
            <v-list-tile-title>Logout</v-list-tile-title>
        </v-list-tile-content>
    </v-list-tile>
    <v-list-tile
        v-else
        @click="$router.push('/login')"
    >
        <v-list-tile-action>
            <v-icon>exit_to_app</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
            <v-list-tile-title>Login</v-list-tile-title>
        </v-list-tile-content>
    </v-list-tile>
</template>

<script>
import AuthMx from '../mixins/AuthMx';

export default {
    name: 'UserAuthListTile',
    mixins: [
        AuthMx
    ],
};
</script>

<style scoped>

</style>
