<template>
    <div>
        <input type="hidden" name="id" :value="foodCategoryId">
        <b-form-group
            id="input-group-name"
            label="Name:"
            label-for="input-name"
            description="Food category name"
        >
            <b-form-input
                id="input-name"
                v-model="foodCategory.name"
                name="name"
            >
            </b-form-input>
        </b-form-group>
        <b-form-group
            id="input-group-description"
            label="Description:"
            label-for="input-description"
            description="Food type description"
        >
            <b-form-input
                id="input-description"
                v-model="foodCategory.description"
                name="description"
            >
            </b-form-input>
        </b-form-group>
        <button type="submit" class="btn btn-success">Submit</button>
    </div>
</template>

<script>
export default {
    name: "FoodCategoryEditForm",
    props: ['foodCategoryId'],
    data: () => {
        return {
            foodCategory: {
                name: "",
                description: ""
            }
        }
    },
    methods: {
        foodCategoryFetch() {
            axios.get(`/admin/food_category/show/${this.foodCategoryId}`)
            .then(function (response) {
                this.foodCategory = response.data.food_category
            }.bind(this))
            .catch(function (error) {
                console.log(`food category fetch error: ${error}`)
            })
        }
    },
    mounted() {
        this.foodCategoryFetch()
    }
}
</script>

<style scoped>

</style>
