<template>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <h1>Режим доставки</h1>
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            Текущие
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            Архив
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div>
            <div v-for="(list, i) in ORDERS" :key="i">
                <div v-for="(food_additive, food_additive_i) in list.food" :key="food_additive_i">
                    <div class="food-position" v-for="(food, food_i) in food_additive.food" :key="food_i">
                        {{ food.name }}
                        <div class="additive-position" v-for="(additive, additive_i) in food_additive.additive" :key="additive_i">
                            добавки - {{ additive.name }}
                        </div>
                        <div class="count-food">
                            количество - {{ list.count }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {
        mounted() {
            setTimeout(() => {
                var id = document.querySelector("meta[name='user-id']").getAttribute('content');

                this.SELECTED_ORDERS_FOR_DRIVER(id)
            }, 1000)
        },
        computed: mapGetters([
            'ORDERS'
        ]),
        methods: mapActions([
            'SELECTED_ORDERS_FOR_DRIVER'
        ])
    }
</script>