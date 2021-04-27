<template>
    <div>
        <b-table
            responsive
            :items="foodCategories"
            :fields="fields"
        >
            <template #cell(modify)="data">
                <b-row>
                    <b-col><b-button variant="info" :href="`/admin/food_category/edit/${data.item.id}`"><i class="fas fa-pen-square"></i></b-button></b-col>
                    <b-col><b-button variant="danger" @click="foodCategoryDelete(data.item.id)"><i class="fas fa-trash"></i></b-button></b-col>
                </b-row>
            </template>
        </b-table>
    </div>
</template>

<script>
export default {
    name: "FoodCategoryEditTable",
    data: () => {
        return {
            foodCategories: [],
            fields: [
                {key:'id', label:'ID', sortable: true},
                {key:'name', label:'name', sortable: true},
                {key:'description', label:'description', sortable: true},
                {key:'updated_at', label:'updated_at', sortable: true},
                'modify'
            ],
        }
    },
    methods: {
        foodCategoryFetch() {
            axios.get('/admin/food_category/list')
            .then(function (response) {
                this.foodCategories = response.data.food_categories
            }.bind(this))
            .catch(function (error){
                console.log(`food categories fetch error: ${error}`)
            })
        },
        foodCategoryDelete(foodCategoryId) {
            axios.post('/admin/food_category/delete', {
                food_category_id: foodCategoryId
            })
            .then(function (response) {

            }.bind(this))
            .catch(function (error){
                console.log(`delete food category fail: ${error}`)
            })
            this.foodCategoryFetch()
        }
    },
    mounted() {
        this.foodCategoryFetch()
    }

}
</script>

<style scoped>

</style>
