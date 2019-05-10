import PredicateMx from './PredicateMx';


/**
 * @see https://docs.geoserver.org/stable/en/user/filter/ecql_reference.html
 */
export default {
    mixins: [
        PredicateMx
    ],
    computed: {
        hasLeftOperand() {
            return !!this.expressions[0];
        },
        hasRightOperand() {
            return !!this.expressions[1];
        },
        isPredicateValid() {
            return !!this.operator &&  this.hasLeftOperand && this.hasRightOperand;
        }
    }
};
