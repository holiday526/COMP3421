<template>
    <b-container>
        <b-form-group
            id="category-listgroup"
            label-cols-sm="3"
            label-cols-lg="3"
            label="Food Category"
            label-align="center"
            content-cols-sm
            content-cols-lg="9"
            class="mt-auto"
        >
            <template #label><div class="w-100 h-100 m-auto p-3">Food Type</div></template>
            <b-list-group id="category-listgroup" horizontal class="w-100 my-2">
                <b-list-group-item
                    v-for="foodType in foodTypes"
                    :key="foodType.id"
                    :href="`/food_menu?foodType=${foodType.name}`"
                    :class="{'w-100': true, 'list-group-item-info': (urlParam.foodType == foodType.name)}"
                >
                    {{ foodType.name }}
                </b-list-group-item>
            </b-list-group>
        </b-form-group>

        <span>
            <a href="/food_menu" :class="{ 'text-info': true, 'disabled': !hasFoodType }" >All food</a>
            <span v-if="foodType"> > <span>{{ foodType }}</span></span>
        </span>
        <div class="float-right">
            Paginator:
            <select name="paginator" id="paginator" onchange="location = this.value" class="mr-4">
                <option v-for="index in paginationGenerator" :key="index" :value="`${locationOnChange}&pagination=${index}`" :selected="index==urlParam.pagination">{{ index }}</option>
            </select>
<!--            Page:-->
<!--            <select name="page_number" id="pageNumber" onchange="location = this.value">-->
<!--                <option v-for="index in pagesFormatting" :key="index" :value="`${locationOnChange}&page=${index}`" :selected="index==currentPage">{{ index }}</option>-->
<!--            </select>-->
        </div>

        <div v-if="!emptyFoodList">
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
            <div class="mt-2">
                <b-pagination
                    v-model="currentPage"
                    :total-rows="totalNumber"
                    align="center"
                    :per-page="perPage"
                >
                </b-pagination>
            </div>
        </div>
        <div v-else class="pt-3">
            <h3>No food is available</h3>
        </div>

    </b-container>
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
            urlParam: {},
            pagination: null,
        }
    },
    props: {
        foods: {
            required: false,
        },
        loggedIn: {
            required: true
        },
        totalNumber: {
            required: true
        },
        pages: {
            required: true
        },
        currentPage: {
            required: true
        },
        perPage: {
            required: true
        },
        foodTypes: {

        }
    },
    methods: {
        checkEmptyFood() {
            this.emptyFoodList = (this.foods == undefined || this.foods.length === 0);
        },
        getFoodType() {
            this.foodType = new URL(window.location.href).searchParams.get("foodType");
        },
        setUrlParams() {
            var result = {};
            for (const [key, value] of new URL(window.location.href).searchParams.entries()) {
                result[key] = value;
            }
            delete result["page"];
            this.urlParam = result;
        },
    },
    computed: {
        hasFoodType() {
            return this.urlParam.foodType !== undefined;
        },
        foodsChunk() {
            if (this.foods !== null) {
                return _.chunk(Object.values(this.foods), 3);
            }
        },
        pagesFormatting() {
            let arr = [];
            for(var i = 0; i < this.pages; i++) {
                arr[i] = i+1;
            }
            return arr;
        },
        locationOnChange() {
            let init = 0;
            let location = '?';
            $.each(this.urlParam, (key, value)=>{
                if (init === 0) {
                    init = 1;
                    location += `${key}=${value}`
                } else {
                    location += `&${key}=${value}`
                }
            })
            return location;
        },
        paginationGenerator() {
            let arr = [];
            for (let i = 1; i <= 4; i++) {
                arr[i-1] = i*3;
            }
            return arr;
        }
    },
    watch: {
        foods() {
            this.checkEmptyFood();
        },
        currentPage() {
            window.location.href = window.location.origin + window.location.pathname + this.locationOnChange + `&page=${this.currentPage}`
        },
    },
    created() {
        this.checkEmptyFood();
        this.getFoodType();
        this.setUrlParams();
    }
}
</script>

<style scoped>
a.disabled {
    pointer-events: none;
    cursor: default;
}
</style>
