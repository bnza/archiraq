import StaticMx from '@/mixins/StaticMx';
import {getNullableWfsFilter} from '@/utils/WFS/filter';

const defaultPredicate = () => {
    return {
        negate: false,
        expressions: [],
        operator: ''
    };
};

/**
 * @see https://docs.geoserver.org/stable/en/user/filter/ecql_reference.html
 */
export default {
    mixins: [
        StaticMx
    ],
    data() {
        return {
            predicate: {}
        };
    },
    props: {
        predicateP: {
            type: Object,
            default: () => {}
        },
        predicateAttributeLabel: {
            type: String
        },
        predicateKey: {
            type: String,
            required: true
        }
    },
    computed: {
        isPredicateValidColor() {
            return this.isPredicateValid ? 'blue lighten-5' : 'white';
        },
        isPredicateValid() {
            return !!getNullableWfsFilter(this.predicate);
        },
        attribute: {
            get() {
                return this.predicate.expressions[0];
            },
            set(value) {
                this.predicate.expressions[0] = value;
            }
        }
    },
    methods: {
        setNegatePredicate(flag) {
            this.$set(this.predicate, 'negate', flag);
        },
        setPredicateOperator(operator) {
            this.$set(this.predicate, 'operator', operator);
        },
        setPredicateExpression(expression, index=1) {
            this.predicate.expressions[index] = expression;
            this.$set(this.predicate, 'expressions', this.predicate.expressions.slice());
        }
    },
    watch: {
        predicate: {
            handler: function (predicate) {
                if (this.$static.predicatePropChanged) {
                    this.$static.predicatePropChanged = false;
                } else {
                    predicate.isValid = this.isPredicateValid;
                    this.$emit('change', {key: this.predicateKey, predicate});
                }
            },
            deep: true
        },
        predicateP: {
            handler: function (predicate) {
                this.$static.predicatePropChanged = true;
                this.predicate = Object.assign(defaultPredicate(), predicate);
            },
            deep: true,
            immediate: true
        }
    },
    static() {
        return {
            predicatePropChanged: false
        };
    }
};
