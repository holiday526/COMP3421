<template>
    <div class="container">
        <span>
            <a href="/food_menu" :class="{ 'text-info': hasFoodType, 'disabled': !hasFoodType }">All food</a>
            <span v-if="foodType"> > <span>{{ foodType }}</span></span>
        </span>
        <div class="float-right">
            Page:
            <select name="page_number" id="pageNumber">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>
        </div>
        <b-card-group class="my-4" deck>
            <food-card></food-card>
            <food-card></food-card>
            <food-card></food-card>
        </b-card-group>
        <b-card-group class="my-4" deck>
            <food-card></food-card>
            <food-card></food-card>
            <food-card></food-card>
        </b-card-group>
        <div class="mt-2">
            <b-pagination
                v-model="currentPage"
                :total-rows="rows"
                align="center"
                :per-page="perPage"
            >
            </b-pagination>
        </div>
    </div>
</template>

<script>

import FoodCard from "./FoodCard";

export default {
    name: "FoodList",
    components: {
        FoodCard
    },
    data: () => {
        return {
            emptyFoodList: true,
            foodType: "",
            currentPage: 1,
            perPage: 1,
            rows: 50,
        }
    },
    props: {
        foods: {
            required: false,
        }
    },
    methods: {
        checkEmptyFood() {
            this.emptyFoodList = (this.foods == undefined || this.foods.length === 0);
        },
        getFoodType() {
            this.foodType = new URL(window.location.href).searchParams.get("foodType");
        }
    },
    computed: {
        hasFoodType() {
            return this.foodType !== "";
        },
    },
    watch: {
        foods() {
            this.checkEmptyFood();
        }
    },
    created() {
        this.checkEmptyFood();
        this.getFoodType();
    }

}
</script>

<style scoped>
a.disabled {
    pointer-events: none;
    cursor: default;
}
</style>
