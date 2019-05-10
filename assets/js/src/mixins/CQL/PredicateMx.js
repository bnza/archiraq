import {lowerFirst} from 'lodash';
import {getWfsFilter} from '@/utils/WFS/filter';


/**
 * @see https://docs.geoserver.org/stable/en/user/filter/ecql_reference.html
 */
export default {
    data() {
        return {
            negate: false,
            expressions: [],
            operator: '',

        };
    },
    props: {
        predicateAttributeName: {
            type: String
        },
        predicateAttributeLabel: {
            type: String
        },
        predicateIndex: {
            type: Number,
            required: true
        }
    },
    computed: {
        isPredicateValid() {
            throw new Error('You must implement "isPredicateValid" method in your component!');
        },
        predicate() {
            return this.isPredicateValid ? this.getFilter() : null;
        },
        predicateAttribute: {
            get() {
                return this.expressions[0];
            },
            set(value) {
                this.expressions[0] = value;
            }
        }
    },
    methods: {
        setNegatePredicate(flag) {
            this.negate = flag;
        },
        setPredicateOperator(operator) {
            this.operator = operator;
        },
        setPredicateExpression(expression, index=1) {
            this.expressions[index] = expression;
            this.expressions = this.expressions.slice();
        },
        getFilter() {
            const filterFn = lowerFirst(this.operator);
            return this.operator ? getWfsFilter(filterFn, this.expressions, this.negate) : null;
        }
    },
    created() {
        if (this.predicateAttributeName) {
            this.predicateAttribute = this.predicateAttributeName;
        }
    },
    watch: {
        predicate: function (predicate) {
            this.$emit('change', this.predicateIndex, predicate);
        },
        deep: true
    }
};
