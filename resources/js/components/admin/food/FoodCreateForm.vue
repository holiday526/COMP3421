<template>
    <b-row>
        <b-col sm="9">
            <div class="form-group">
                <label for="foodName">Food name</label>
                <input type="text" class="form-control" id="foodName" placeholder="Enter food name" name="name" v-model="foodName">
            </div>
            <div class="form-group">
                <label for="foodDescription">Food Description</label>
                <textarea
                    class="form-control"
                    id="foodDescription"
                    rows="3"
                    placeholder="Enter food description"
                    name="description"
                    v-model="foodDescription"
                >
                </textarea>
            </div>
            <div class="form-group">
                <label for="foodPrice">Food Price</label>
                <input type="number" class="form-control" id="foodPrice" placeholder="Enter food price" name="price" v-model="foodPrice" min="1" value="1">
            </div>
            <b-form-group
                id="foodTypeSelectGroup"
                label="Food Type"
                label-for="foodTypeSelect"

            >
                <b-form-select
                    id="foodTypeSelect"
                    v-model="selectedFoodTypeId"
                    :options="foodTypes"
                    text-field="name"
                    value-field="id"
                    name="type_id"
                    required
                >
                </b-form-select>
            </b-form-group>
            <b-form-group
                id="foodCategorySelectGroup"
                label="Food Category"
                label-for="foodCategorySelect"
                name="category_id"
            >
                <b-form-select
                    id="foodCategorySelect"
                    v-model="selectedFoodCategoryId"
                    :options="foodCategories"
                    text-field="name"
                    value-field="id"
                    :disabled="foodCategoryDisabled"
                >
                </b-form-select>
            </b-form-group>
            <div class="form-group">
                <label for="foodImageInput">Food Image</label>
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" accept="image/*" class="custom-file-input" id="foodImageInput" @change="previewImage" name="food_image">
                        <label class="custom-file-label" for="foodImageInput" aria-describedby="foodImageInputAddOn">Choose file</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </b-col>
        <b-col sm="3">
            <food-card
                :logged-in="false"
                :food-name="foodName"
                :food-description="foodDescription"
                :food-price="foodPrice"
                :food-type="foodTypeString"
                :food-category="selectedFoodCategoryFormatting"
                :food-image="preview"
            >
            </food-card>
        </b-col>
    </b-row>
</template>

<script>
import FoodCard from "../../menu/FoodCard";
export default {
    name: "FoodCreateForm",
    components: {
        FoodCard
    },
    props: {
        foodTypes: {
            required: true
        },
        foodCategories: {
            required: true
        }
    },
    data: () => {
        return {
            selectedFoodTypeId: "",
            selectedFoodCategoryId: "",
            selectedFoodCategory: "",
            selectedFoodType: {},
            foodName: "",
            foodDescription: "",
            foodPrice: 0.0,
            preview: null,
            image: null,
        }
    },
    computed: {
        foodCategoryDisabled() {
            if (Object.keys(this.selectedFoodType).length !== 0) {
                this.selectedFoodCategory = "";
                this.selectedFoodCategoryId = "";
                return this.selectedFoodType.description === "Burger" ? false : true;
            } else {
                this.selectedFoodCategory = "";
                this.selectedFoodCategoryId = "";
                return "disabled";
            }
        },
        foodTypeString() {
            return this.selectedFoodType.description !== null ? this.selectedFoodType.name : "";
        },
        selectedFoodCategoryFormatting() {
            return (this.selectedFoodCategory === '') ? "N.A." : this.selectedFoodCategory.name;
        }
    },
    methods: {
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
    watch: {
        selectedFoodTypeId() {
            if (this.selectedFoodTypeId)
                this.selectedFoodType = this.foodTypes.find(element => element.id === this.selectedFoodTypeId);
        },
        selectedFoodCategoryId() {
            if (this.selectedFoodCategoryId)
                this.selectedFoodCategory = this.foodCategories.find(obj => obj.id === this.selectedFoodCategoryId);
        }
    }
}
</script>

<style scoped>

</style>
