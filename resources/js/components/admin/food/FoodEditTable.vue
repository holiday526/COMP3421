<template>
    <div>
        <b-form-group
            label="Filter"
            label-for="filter-input"
            label-cols-sm="2"
            label-size="sm"
        >
            <b-input-group size="sm">
                <b-form-input
                    id="filter-input"
                    v-model="filter"
                    type="search"
                    placeholder="Type to Search"
                ></b-form-input>

                <b-input-group-append>
                    <b-button @click="filter = ''">Clear</b-button>
                </b-input-group-append>
            </b-input-group>
        </b-form-group>
        <b-table
            responsive
            :items="foods"
            :filter="filter"
            :filter-included-fields="filterOn"
            :fields="fields"
        >
            <template #cell(modify)="data">
                <b-row>
                    <b-col>
                        <b-button variant="info" :href="`/admin/food/edit/${data.item.food_id}`"><i class="fas fa-pen-square"></i></b-button>
                    </b-col>
                    <b-col>
                        <b-button v-if="data.item.food_delete_at == null" variant="danger" @click="foodDelete(data.item.food_id)"><i class="fas fa-trash"></i></b-button>
                        <b-button v-else variant="secondary" @click="foodRestore(data.item.food_id)"><i class="fas fa-trash-restore"></i></b-button>
                    </b-col>
                </b-row>
            </template>
        </b-table>
    </div>
</template>

<script>
export default {
    name: "FoodEditTable",
    props: {
        // foods: {
        //     required: true
        // }
    },
    data: () => {
        return {
            foods: [],
            fields: [
                { key: 'food_id', label: 'ID', sortable: true },
                { key: 'food_category_name', label: 'Food Category', sortable: true },
                { key: 'food_type_name', label: 'Food Type', sortable: true },
                { key: 'food_name', label: 'Food Name', sortable: true },
                { key: 'food_description', label: 'Description' },
                { key: 'food_price', label: 'Price', sortable: true },
                { key: 'food_updated_at', label: 'Updated at', sortable: true },
                { key: 'food_delete_at', label: 'Deleted at', sortable: true },
                'Modify'
            ],
            filter: "",
            filterOn: []
        }
    },
    methods: {
        foodFetch() {
            axios.get('/admin/food/list')
            .then(function (response){
                this.foods = response.data.foods
            }.bind(this))
            .catch(function (error) {

            });
        },
        foodDelete(foodId) {
            axios.post(
                '/admin/food/delete',
                { 'food_id': foodId },
                {
                    headers: {
                        'X-CSRF-Token': $('meta[name=_token]').attr('content')
                    }
                }
            )
            .then(function (response) {
                this.toast('success', `Food ID: ${foodId} is deleted`);
            }.bind(this))
            .catch(function (error) {
                this.toast('danger', `Food ID: ${foodId} cannot be deleted`);
                console.log(`cannot delete ${error}`);
            }.bind(this));
            this.foodFetch();
        },
        foodRestore(foodId) {
            axios.post(
                '/admin/food/restore',
                { 'food_id': foodId },
                {
                    headers: {
                        'X-CSRF-Token': $('meta[name=_token]').attr('content')
                    }
                }
            )
            .then(function(response){
                this.toast('success', `Food ID: ${foodId} is restored`);
            }.bind(this))
            .catch(function (error) {
                this.toast('danger', `Food ID: ${foodId} cannot be restored`);
                console.log(`cannot restore ${error}`)
            }.bind(this));
            this.foodFetch();
        },
        toast(variant, message, toaster = 'b-toaster-bottom-right', append = true) {
            this.$bvToast.toast(message, {
                title: `Alert`,
                toaster: toaster,
                solid: true,
                appendToast: append,
                variant: variant
            })
        },
    },
    mounted() {
        this.foodFetch();
    },
    watch: {
        foods() {
            if (this.foods.length !== 0) {
                $.each(this.foods, function(index, obj){
                    if (obj.food_delete_at != null) {
                        obj['_rowVariant'] = 'danger';
                    }
                })
            }
        }
    }
}
</script>

<style scoped>

</style>
