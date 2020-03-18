<template>
    <div class="control-field">
        <span class="account-control" id="dropdownMenuUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="/images/icons/user.png" width="36" height="36" class="d-inline-block align-top" alt="">
            {{ USER.account.name }} ▼
        </span>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuUser">
            <a class="dropdown-item" :href="'edit/user/' + USER.id">Изменить профиль</a>
        </div>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {
        mounted() {
            this.SELECTED_ALL_INFO_FOR_USER();
        },
        computed: mapGetters([
            'USER'
        ]),
        methods: mapActions([
            'SELECTED_ALL_INFO_FOR_USER'
        ])
    }
</script>