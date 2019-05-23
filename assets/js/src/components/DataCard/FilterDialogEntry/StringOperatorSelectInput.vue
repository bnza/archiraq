<template>
    <v-select
        ref="select"
        :value="value"
        :items="items"
        label="Operator"
        :hint="hint"
        persistent-hint
        attach
        @input="emitInputValue"
    />
</template>

<script>
export default {
    name: 'StringOperatorSelectInput',
    props: {
        value: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            items: [
                {
                    text: '',
                    value: ''
                },
                {
                    text: '=',
                    value: 'EqualToFilter'
                },
                {
                    text: 'ILIKE',
                    value: 'IsInsensitiveLikeFilter'
                },
                {
                    text: 'LIKE',
                    value: 'IsLikeFilter'
                },
            ],
            hints: {
                'EqualToFilter': 'Equals',
                'IsInsensitiveLikeFilter': 'Case insensitive string pattern. Use % as wildcard',
                'IsLikeFilter': 'Case sensitive string pattern. Use % as wildcard',
            }
        };
    },
    computed: {
        hint() {
            return this.value ? this.hints[this.value] : 'Choose the operator';
        }
    },
    methods: {
        emitInputValue(value) {
            this.$emit('update:value', value);
        }
    }
};
</script>
