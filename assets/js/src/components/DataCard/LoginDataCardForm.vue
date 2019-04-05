<template>
    <v-form data-test="v-form--login">
        <v-text-field
            v-model="item.username"
            data-test="v-text-field--username"
            label="Username"
            :disabled="isDisabled"
            required
        />
        <v-text-field
            v-model="item.password"
            data-test="v-text-field--password"
            label="Password"
            type="password"
            :disabled="isDisabled"
            required
        />
    </v-form>
</template>

<script>
import { validationMixin } from 'vuelidate';
import { required } from 'vuelidate/lib/validators';

export default {
    name: 'LoginDataCardForm',
    mixins: [
        validationMixin
    ],
    props: {
        item: {
            type: Object,
            default: () => {}
        },
        isRequestPending: {
            type: Boolean,
            required: true
        },
        isInvalid: {
            type: Boolean,
            required: true
        }
    },
    computed: {
        isDisabled() {
            return this.isValidationInvalid && this.isRequestPending;
        },
        /**
         * Vuelidate $v.$invalid (watched)
         * @return {validationGetters.$invalid}
         */
        isValidationInvalid()
        {
            return this.$v.$invalid;
        }
    },
    validations: {
        item: {
            username: { required },
            password: { required }
        }
    },
    watch: {
        isValidationInvalid(value) {
            this.$emit('update:isInvalid', value);
        }
    }
};
</script>
