<template>
    <div>
        <div class="form-group">
            <label for="foodName">Food name</label>
            <input type="text" class="form-control" id="foodName" placeholder="Enter food name" name="name">
        </div>
        <div class="form-group">
            <label for="foodDescription">Food Description</label>
            <textarea
                class="form-control"
                id="foodDescription"
                rows="3"
                placeholder="Enter food description"
                name="description"
            >
            </textarea>
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
                required
            >
            </b-form-select>
        </b-form-group>
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
                required
            >
            </b-form-select>
        </b-form-group>
    </div>
</template>

<script>
export default {
    name: "FoodCreateForm",
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
            selectedFoodCategories: "",
        }
    },
}
</script>

<style scoped>

</style>
