<template>
    <div>
        <b-form-group></b-form-group>
        <b-table
            responsive
            :items="foodTypes"
            :fields="fields"
        >
            <template #cell(modify)="data">
                <b-row>
                    <b-col>
                        <b-button v-if="data.item.name !== 'Burger'" variant="info" :href="`/admin/food_type/edit/${data.item.id}`"><i class="fas fa-pen-square"></i></b-button>
                    </b-col>
                    <b-col>
                        <b-button v-if="data.item.name !== 'Burger'" variant="danger" @click="foodTypeDelete(data.item.id)"><i class="fas fa-trash"></i></b-button>
                    </b-col>
                </b-row>
            </template>
        </b-table>
    </div>
</template>

<script>
export default {
    name: "FoodTypeEditTable",
    data: () => {
        return {
            foodTypes: [],
            filter: "",
            filterOn: [],
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
        foodTypeFetch() {
            axios.get('/admin/food_type/list')
            .then(function (response) {
                this.foodTypes = response.data.food_types
            }.bind(this))
            .catch(function (error){
                console.log(`Food Type fetch error: ${error}`)
            })
        },
        foodTypeDelete(foodTypeId) {
            axios.post('/admin/food_type/delete', {
                    id: foodTypeId
                })
                .then(function (response) {

                }.bind(this))
                .catch(function (error) {
                    console.log(`delete food type fail: ${error}`)
                })
            this.foodTypeFetch()
        }
    },
    mounted() {
        this.foodTypeFetch()
    }
}
</script>

<style scoped>

</style>
