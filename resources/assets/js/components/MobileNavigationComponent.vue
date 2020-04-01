<template>
    <div class="modal-body">
        <div class="point--mobile">
            <div class="user-info--mobile" v-for="(account, a) in USER">
                <h1>{{ account.name }}</h1>

                {{ account.account.name }} {{ account.account.second_name }}
            </div>

            <div class="point-info--mobile" v-for="(address, i) in POINT" :key="i">
                {{ address.address }}
            </div>
        </div>


        <nav class="navbar d-inline-flex justify-content-between" v-if="ROLE == 4">
            <div>
                <ul class="nav">
                    <li class="nav-item li--mobile">
                        <a class="nav-link" href="/dashboard">
                            <img src="/images/icons/home.png" width="24" height="24" class="d-inline-block align-top" alt="">
                            Заказы
                        </a>
                    </li>
                    <li class="nav-item li--mobile">
                        <a class="nav-link" href="/control">
                            <img src="/images/icons/administration.png" width="24" height="24" class="d-inline-block align-top" alt="">
                            Управление
                        </a>
                    </li>
                    <li class="nav-item li--mobile">
                        <a class="nav-link" href="/calls">
                            <img src="/images/icons/telephone.png" width="24" height="24" class="d-inline-block align-top" alt="">
                            Звонки <span class="count-calls">{{ CALLS }}</span>
                        </a>
                    </li>
                    <li class="nav-item li--mobile">
                        <a class="nav-link" href="/statistics">
                            <img src="/images/icons/statistics.png" width="24" height="24" class="d-inline-block align-top" alt="">
                            Статистика
                        </a>
                    </li>
                    <li class="nav-item li--mobile">
                        <a class="nav-link" href="/logout">
                            <img src="/images/icons/logout.png" width="24" height="24" class="d-inline-block align-top" alt="">
                            выход
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <nav class="navbar navbar-expand-lg" v-else-if="ROLE == 3">
            <div>
                <ul class="nav">
                    <li class="nav-item li--mobile">
                        <a class="nav-link" href="/dashboard">
                            <img src="/images/icons/home.png" width="24" height="24" class="d-inline-block align-top" alt="">
                            Заказы
                        </a>
                    </li>
                    <li class="nav-item li--mobile">
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
        created() {
            this.$store.commit('setAuthUser', window.Laravel.role);
            this.LOADED_CALLS();
        },
        mounted() {
            this.$store.commit('setAuthUser', window.Laravel.role);
            this.SELECTED_CALLS();
            this.SELECTED_INFO_POINT();
        },
        computed: mapGetters([
            'ROLE',
            'CALLS',
            'USER',
            'POINT'
        ]),
        methods: mapActions([
            'LOADED_CALLS',
            'SELECTED_CALLS',
            'SELECTED_ALL_INFO_FOR_USER',
            'SELECTED_INFO_POINT'
        ])
    }
</script>