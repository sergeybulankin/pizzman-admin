<template>
    <div class="system-works">
        <div v-if="ROLE >=4">
            <div class="blobs-container">
                <div class="blob green"></div>

                <div class="system-title">
                    Система
                </div>
            </div>

            <div class="system">
                {{ SYSTEM_WORK_CALLS }}
            </div>

            <div class="system">
                {{ SYSTEM_WORK_STATUSES }}
            </div>

            <div class="system">
                {{ SYSTEM_WORK_ORDERS }}
            </div>
        </div>

        <div v-else>
            <div class="system">
                {{ SYSTEM_WORK_ORDERS_FOR_DRIVER }}
            </div>
        </div>

        <div class="system-last-update">
            {{ SYSTEM_DATE_UPDATE | format }}
        </div>
    </div>
</template>

<script>
    moment.locale('ru');

    import { mapGetters, mapMutations } from 'vuex';

    export default {
        computed: mapGetters([
            'ROLE',
            'SYSTEM_WORK_CALLS',
            'SYSTEM_WORK_STATUSES',
            'SYSTEM_WORK_ORDERS',
            'SYSTEM_DATE_UPDATE',
            'SYSTEM_WORK_ORDERS_FOR_DRIVER'
        ]),
        filters: {
            format: (date) => {
                return moment(date).format('D MMMM, H:mm:ss');
            }
        }
    }
</script>