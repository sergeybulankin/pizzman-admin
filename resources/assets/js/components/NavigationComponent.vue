<template>
    <div class="list-group">
        <nav class="navbar navbar-expand-lg" v-if="ROLE == 4">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav flex-column">
                    <li class="nav-item active">
                        <a class="nav-link" href="/dashboard">
                            <img src="/images/icons/home.png" width="24" height="24" class="d-inline-block align-top" alt="">
                            Заказы
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/control">
                            <img src="/images/icons/administration.png" width="24" height="24" class="d-inline-block align-top" alt="">
                            Управление
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/calls">
                            <img src="/images/icons/telephone.png" width="24" height="24" class="d-inline-block align-top" alt="">
                            Звонки <span class="count-calls">{{ CALLS }}</span>
                        </a>
                    </li>
                    <li class="nav-item logout">
                        <a class="nav-link" href="/logout">
                            <img src="/images/icons/logout.png" width="24" height="24" class="d-inline-block align-top" alt="">
                            выход
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <nav class="navbar navbar-expand-lg" v-else-if="ROLE == 3">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav flex-column">
                    <li class="nav-item active">
                        <a class="nav-link" href="/dashboard">
                            <img src="/images/icons/home.png" width="24" height="24" class="d-inline-block align-top" alt="">
                            Заказы
                        </a>
                    </li>
                    <li class="nav-item logout">
                        <a class="nav-link" href="/logout">
                            <img src="/images/icons/logout.png" width="24" height="24" class="d-inline-block align-top" alt="">
                            выход
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {
        mounted() {
            this.$store.commit('setAuthUser', window.Laravel.role);
            this.SELECTED_CALLS();
        },
        computed: mapGetters([
            'ROLE',
            'CALLS'
        ]),
        methods: mapActions([
            'SELECTED_CALLS'
        ])
    }
</script>