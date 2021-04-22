<template>
    <div>
        <b-row>
            <b-col sm="9">
                <input type="hidden" name="food_id" :value="food.food_id">
                <div class="form-group">
                    <label for="foodName">Food name</label>
                    <input type="text" class="form-control" id="foodName" placeholder="Enter food name" name="name" v-model="food.food_name">
                </div>
                <div class="form-group">
                    <label for="foodDescription">Food Description</label>
                    <textarea
                        class="form-control"
                        id="foodDescription"
                        rows="3"
                        placeholder="Enter food description"
                        name="description"
                        v-model="food.food_description"
                    >
                    </textarea>
                </div>
                <div class="form-group">
                    <label for="foodPrice">Food Price</label>
                    <input type="number" class="form-control" id="foodPrice" placeholder="Enter food price" name="price" v-model="food.food_price" min="1" value="1">
                </div>
                <b-form-group
                    id="foodTypeSelectGroup"
                    label="Food Type"
                    label-for="foodTypeSelect"
                >
                    <b-form-select
                        id="foodTypeSelect"
                        v-model="food.food_type_id"
                        :options="foodTypes"
                        text-field="name"
                        value-field="id"
                        name="type_id"
                        required
                    >
                    </b-form-select>
                </b-form-group>
                <div>
                    <b-form-group
                        id="foodCategorySelectGroup"
                        label="Food Category"
                        label-for="foodCategorySelect"
                        v-show="food.food_type_name === 'Burger'"
                    >
                        <b-form-select
                            id="foodCategorySelect"
                            v-model="food.food_category_id"
                            :options="foodCategories"
                            text-field="name"
                            name="category_id"
                            value-field="id"
                        >
                        </b-form-select>
                    </b-form-group>
                </div>
                <div class="form-group">
                    <label for="foodImageInput">Food Image</label>
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" accept="image/*" class="custom-file-input" id="foodImageInput" @change="previewImage" name="food_image">
                            <label class="custom-file-label" for="foodImageInput" aria-describedby="foodImageInputAddOn">Choose file</label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Update</button>
            </b-col>
            <b-col sm="3">
                <food-card
                    :logged-in="false"
                    :food-name="food.food_name"
                    :food-description="food.food_description"
                    :food-price="food.food_price"
                    :food-type="food.food_type_name"
                    :food-category="food.food_category_name"
                    :food-image="preview"
                >
                </food-card>
            </b-col>
        </b-row>
    </div>
</template>

<script>
import FoodCard from '../../menu/FoodCard';
export default {
    components: {
        FoodCard
    },
    name: "FoodEditForm",
    props: [
        'foodId', 'foodTypes', 'foodCategories'
    ],
    data: () => {
        return {
            food: {},
            selectedFoodCategoryId: "",
            preview: null,
            image: null,
        }
    },
    methods: {
        foodFetch() {
            axios.get('/admin/food/list', {
                params: {
                    food_id: this.foodId
                }
            })
            .then(function (response) {
                this.food = response.data.foods[0]
            }.bind(this))
            .catch(function (error) {

            }.bind);
        },
        setFoodTypeName(foodTypeId) {
            this.food.food_type_name = this.foodTypes.find(foodType => foodType.id === foodTypeId).name;
        },
        previewImage(event) {
            let input = event.target;
            if (input.files) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.preview = e.target.result;
                }
                this.image = input.files[0];
                reader.readAsDataURL(input.files[0]);
            }
        }
    },
    computed: {

    },
    mounted() {
        this.foodFetch();
    },
    watch: {
        'food.food_type_id': function (newVal, oldVal) {
            this.setFoodTypeName(newVal);
        },
        'food.food_category_id': function (newVal, oldVal) {
            this.food.food_category_name = this.foodCategories.find(foodCategory => foodCategory.id === newVal).name;
        }
    }
}
</script>

<style scoped>

</style>
