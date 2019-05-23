/**
 * Mixin used for chain nested CQL condition/predicate components
 * @example
 *  <parent>                    <-- uses ConditionMx
 *      <component1>            <-- uses NestedPredicateMx
 *          <component2         <-- uses PredicateMx
 *              ref="predicate"
 *              :predicate-p="predicateP"
 *              :predicate-key="predicateKey"
 *              @change="$emit('change', $event)"   <-- MUST propagate change event to parent
 *          >
 *              <component3     <-- slot (for custom input)
 *                  @event="setPredicateExpression"
 *              >
 *          </component2>
 *      </component1>
 *  </parent>
 */
export default {
    props: {
        predicateP: {
            type: Object,
            default: () => {}
        },
        predicateKey: {
            type: String,
            required: true
        },
    },
    data() {
        return {
            value: []
        };
    },
    watch: {
        predicateP: {
            handler(predicate) {
                this.value = predicate.expressions[1];
            },
            deep: true
        }
    },
    methods: {
        /**
         * Forward event value to predicate component
         * @param $event
         */
        setPredicateExpression($event) {
            if (this.$refs.predicate) {
                if (typeof(this.$refs.predicate.setPredicateExpression) === 'function') {
                    this.$refs.predicate.setPredicateExpression($event);
                } else {
                    throw new Error('Your "predicate" child component MUST provide setPredicateExpression. Did you register "PredicateMx" mixin?');
                }
            } else {
                throw new Error('You must register a "predicate" reference in your component using ref="predicate"');
            }

        }
    }
};
