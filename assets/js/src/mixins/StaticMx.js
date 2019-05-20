import Vue from 'vue';

Vue.prototype.$static = {};

/**
 * Add non reactive static data to component
 * @see https://github.com/vuejs/vue/issues/1988
 */
export default {
    beforeCreate() {
        const vueStatic = this.$options.static;
        const vueStaticDestination = this.$static || this;

        if (vueStatic && typeof(vueStatic) === 'function') {
            Object.assign(vueStaticDestination, vueStatic.apply(this));
        } else if (vueStatic && typeof(vueStatic) === 'object') {
            Object.assign(vueStaticDestination, vueStatic);
        }
    }
};
