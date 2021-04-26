<template>
    <div>
        <div v-if="emptyResult">
            <b-card
                bg-variant="dark"
            >
                <b-card-title class="text-white">
                    No search result match.
                </b-card-title>
                <b-button variant="info" href="/food_menu">
                    Return to food menu
                </b-button>
            </b-card>
        </div>
        <div v-else>
            <h4>Search result <span class="h6">(count: <span class="text-info">{{ searchResult.length }}</span>)</span></h4>
            <b-card-group class="my-4 mx-auto" deck v-for="(chunk, index) in foodsChunk" :key="index">
                <food-card
                    :logged-in="loggedIn"
                    v-for="food in chunk"
                    :key="food.id"
                    :food-id="food.food_id"
                    :food-name="food.food_name"
                    :food-description="food.food_description"
                    :food-price="food.food_price"
                    :food-image="food.food_image_location"
                    :food-type="food.food_type_name"
                    :food-category="food.food_category_name"
                >
                </food-card>
            </b-card-group>
        </div>
    </div>
</template>

<script>
import FoodCard from './FoodCard';
export default {
    components: {
        FoodCard
    },
    name: "SearchList",
    props: ['searchResult', 'loggedIn'],
    data: () => {
        return {
            emptyResult: true,
        }
    },
    methods: {
        checkEmptyResult() {
            this.emptyResult = (this.searchResult == undefined || this.searchResult.length === 0);
        },
    },
    computed: {
        foodsChunk() {
            if (this.foods !== null) {
                return _.chunk(Object.values(this.searchResult), 3);
            }
        },
    },
    mounted() {
        this.checkEmptyResult();
    },
    watch: {
        searchResult() {
            this.checkEmptyResult();
        }
    }
}
</script>

<style scoped>

</style>
