<template>
    <div class="container">
        <Admin v-if="ROLE == 4"></Admin>
        <Driver v-if="ROLE == 3"></Driver>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import Admin from './AdminComponent';
    import Driver from './DriverComponent';

    export default {
        mounted() {
            this.$store.commit('setAuthUser', window.Laravel.role);
        },
        computed: mapGetters([
            'ROLE'
        ]),
        components: {
            Admin: Admin,
            Driver: Driver
        }
    }
</script>