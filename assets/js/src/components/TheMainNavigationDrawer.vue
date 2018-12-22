<template>
    <v-navigation-drawer
            clipped
            :hide-overlay="true"
            app
            v-model="visible"
    >
    </v-navigation-drawer>
</template>

<script>
    import ComponentsStoreMx from '../../src/mixins/ComponentsStoreMx'

    export default {
        name: "TheMainNavigationDrawer",
        mixins: [
            ComponentsStoreMx
        ],
        computed: {
            visible: {
                get() {
                    return this.getStoreProp('visible')
                },
                set(value) {
                    this.setStoreProp('visible', value)
                }
            }
        },
        created() {
            this.visible = false
            // console.log("TheMainNavigationDrawer")
        },
    }
</script>

<style scoped>

</style>