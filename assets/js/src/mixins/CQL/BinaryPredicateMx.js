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
        //@TODO improve observable check
        hasRightOperand() {
            let operand = this.expressions[1];
            return !!operand && !!this.expressions[1].length;
        },
        isPredicateValid() {
            return !!this.operator &&  this.hasLeftOperand && this.hasRightOperand;
        }
    }
};
