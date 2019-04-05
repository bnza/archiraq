<template>
    <v-dialog
        :value="true"
        persistent
        max-width="500px"
    >
        <data-card
            data-test="v-data-card--logot"
            :padding="true"
            color="indigo"
            dark
        >
            <v-toolbar-title
                slot="toolbar"
            >
                Logout
            </v-toolbar-title>
            <div slot="data">
                <p>Are you sure you want to logout?</p>
            </div>
            <template slot="actions">
                <v-spacer />
                <v-btn
                    color="blue darken-1"
                    flat
                    :disabled="isRequestPending"
                    @click.native="closeDialog"
                >
                    Close
                </v-btn>
                <v-btn
                    flat
                    :disabled="isRequestPending"
                    color="blue darken-1"
                    @click.native="performLogout"
                >
                    Logout
                </v-btn>
            </template>
        </data-card>
    </v-dialog>
</template>

<script>
import {mapActions, mapMutations} from 'vuex';
import DataCard from './DataCard/DataCard';
import SnackbarComponentStoreMx from '../mixins/SnackbarComponentStoreMx';
import {LOGOUT} from '../store/auth/actions';
import {SET_XSRF_TOKEN} from '../store/mutations';

const performLogoutRequest = (vm) => {
    vm.logout(vm.item).then((data) => {
        vm.displaySnackbar(data.message, 'success');
        vm.setXsrfToken(data.xsrfToken);
        vm.closeDialog();
    }).catch((error) => {
        vm.displaySnackbar(error.errorMessages, 'error');
    });
};

export default {
    name: 'TheLogoutModal',
    components: {
        DataCard
    },
    mixins: [
        SnackbarComponentStoreMx
    ],
    data() {
        return {
            isRequestPending: false
        };
    },
    methods: {
        ...mapMutations({
            setXsrfToken: SET_XSRF_TOKEN
        }),
        ...mapActions({
            logout: `auth/${LOGOUT}`
        }),
        closeDialog () {
            this.$router.replace(this.$store.state.route.from.fullPath);
        },
        performLogout () {
            performLogoutRequest(this);
        }
    },
};
</script>

<style scoped>

</style>
