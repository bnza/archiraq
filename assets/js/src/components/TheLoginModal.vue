<template>
    <v-dialog
        :value="true"
        persistent
        max-width="500px"
    >
        <login-data-card />
    </v-dialog>
</template>

<script>
import LoginDataCard from './DataCard/LoginDataCard';
export default {
    name: 'TheLoginModal',
    components: {
        LoginDataCard
    }
};
</script>

<style scoped>

</style>
