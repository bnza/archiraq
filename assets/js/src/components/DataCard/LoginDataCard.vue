<template>
    <data-card
        data-test="v-data-card--login"
        :padding="true"
        color="indigo"
        dark
    >
        <v-toolbar-title
            slot="toolbar"
        >
            Login
        </v-toolbar-title>
        <div slot="data">
            <login-data-card-form
                :is-invalid.sync="isInvalid"
                :item.sync="item"
                :is-request-pending="isRequestPending"
            />
        </div>
        <template slot="actions">
            <v-spacer />
            <v-btn
                color="blue darken-1"
                flat
                :disabled="isRequestPending"
                data-test="v-btn--close"
                @click.native="closeDialog"
            >
                Close
            </v-btn>
            <v-btn
                flat
                :disabled="isInvalid || isRequestPending"
                color="blue darken-1"
                data-test="v-btn--submit"
                @click.native="performLoginRequest"
            >
                Submit
            </v-btn>
        </template>
    </data-card>
</template>

<script>
import {mapActions} from 'vuex';
import {LOGIN} from '../../store/auth/actions';
import SnackbarComponentStoreMx from '../../mixins/SnackbarComponentStoreMx';
import DataCard from './DataCard';
import LoginDataCardForm from './LoginDataCardForm';

const performLoginRequest = (vm) => {
    vm.login(vm.item).then((response) => {
        const text = `User ${response.username} logged in`;
        vm.displaySnackbar(text, 'success');
        vm.closeDialog();
    }).catch((error) => {
        vm.displaySnackbar(error.errorMessages, 'error');
    });
};

export default {
    name: 'LoginDataCard',
    components: {
        DataCard,
        LoginDataCardForm
    },
    mixins: [
        SnackbarComponentStoreMx
    ],
    data() {
        return {
            item: {
                username: '',
                password: ''
            },
            isRequestPending: false,
            isInvalid: true
        };
    },
    methods: {
        ...mapActions({
            login: `auth/${LOGIN}`
        }),
        closeDialog() {
            this.$router.push(this.$store.state.route.from.fullPath);
        },
        performLoginRequest() {
            performLoginRequest(this);
        }
    }
};
</script>

<style scoped>

</style>
