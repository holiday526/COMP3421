<template>
    <div>
        <input type="hidden" name="id" :value="foodTypeId">
        <b-form-group
            id="input-group-name"
            label="Name:"
            label-for="input-name"
            description="Food type name"
        >
            <b-form-input
                id="input-name"
                v-model="foodType.name"
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
                v-model="foodType.description"
                name="description"
            >
            </b-form-input>
        </b-form-group>
        <button type="submit" class="btn btn-success">Submit</button>
    </div>
</template>

<script>
export default {
    name: "FoodTypeEditForm",
    props: ['foodTypeId'],
    data: () => {
        return {
            foodType: {
                name: "",
                description: ""
            }
        }
    },
    methods: {
        foodTypeFetch() {
            axios.get(`/admin/food_type/show/${this.foodTypeId}`)
                .then(function (response) {
                    this.foodType = response.data.food_type
                }.bind(this))
                .catch(function (error) {
                    console.log(`Food type fetch error: ${error}`)
                })
        }
    },
    mounted() {
        this.foodTypeFetch()
    }
}
</script>

<style scoped>

</style>
