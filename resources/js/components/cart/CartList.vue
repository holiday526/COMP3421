<template>
    <div>
        <div v-if="emptyCart">
            <b-card bg-variant="dark" text-variant="white">
                <b-card-title style="font-size: 2.5rem">No food in cart</b-card-title>
                <b-card-text style="font-size: 1.5rem">
                    Back to menu to order food
                </b-card-text>
                <b-button href="/food_menu" variant="info">Food menu</b-button>
            </b-card>
        </div>
        <div v-else>
            <b-table
                responsive
                :items="cartItems"
                :fields="fields"
            >
                <template #cell(index)="data">
                    <span class="text-info">
                        {{ data.index + 1 }}
                    </span>
                </template>
                <template #cell(edit)="data">
                    <div style="display: inline-block;">
                        <b-button variant="danger" @click="updateQuantity('delete', data.item.cart_food_id)" size="sm"><i class="fas fa-minus"></i></b-button>
                        <b-button variant="success" @click="updateQuantity('add', data.item.cart_food_id)" size="sm"><i class="fas fa-plus"></i></b-button>
                        <b-button variant="info" @click="updateQuantity('clear', data.item.cart_food_id)" size="sm"><i class="fas fa-trash"></i></b-button>
                    </div>
                </template>
                <template #cell(subtotal)="data">
                    $ {{ foodPriceFormatting(data.item.food_price * data.item.cart_quantity) }}
                </template>
            </b-table>
            <b-card align="right" style="border: none">
                <b-card-text style="font-size: 1.5rem">Total: <span class="text-info">{{ foodPriceFormatting(total) }}</span></b-card-text>
                <div style="display: inline-block" class="pr-2"><b-button variant="info" href="/food_menu">return to menu</b-button></div>
                <b-button variant="success">checkout</b-button>
            </b-card>
        </div>
    </div>
</template>

<script>
export default {
    name: "CartList",
    data: () => {
        return {
            fields: [
                'index',
                { key: 'edit'},
                { key: 'food_name', sortable: true, label: 'Name'},
                { key: 'food_type_name', sortable: true, label: 'Type' },
                { key: 'cart_updated_at', sortable: true, label: 'Item added at' },
                { key: 'cart_quantity', sortable: true, label: 'Qty'},
                { key: 'food_price', sortable: true, label: 'Price'},
                'subtotal'
            ],
            cartItems: [],
            total: 0
        }
    },
    methods: {
        getCarts() {
            axios.get('/cart/list')
            .then(function (response) {
                console.log(response);
                this.cartItems = response.data.record;
            }.bind(this))
            .catch(function (error) {
                console.log(`CartList ${error}`);
            })
        },
        updateQuantity(action, foodId) {
            axios({
                method: 'post',
                url: '/cart/modify',
                data: {
                    'food_id': foodId,
                    'action': action
                }
            })
            .then(function (response) {
                console.log(response.status);
                this.getCarts();
            }.bind(this))
            .catch(function (error) {
                this.errorToast(error.status)
                console.log(error);
            }.bind(this));
        },
        errorToast(errorStatus) {
            this.$bvToast.toast(`Food: ${this.foodName} cannot be modify, error status -> ${errorStatus}`, {
                title: `Alert`,
                toaster: 'b-toaster-bottom-right',
                solid: true,
                appendToast: true,
                variant: 'danger',
            })
        },
        foodPriceFormatting(price) {
            return `${Number(price).toLocaleString()}`;
        },
    },
    computed: {
        emptyCart() {
            return this.cartItems.length === 0;
        },
    },
    mounted() {
        this.getCarts();
    },
    watch: {
        cartItems() {
            if (this.cartItems.length !== null && this.cartItems.length !== 0) {
                let total = 0;
                $.each(this.cartItems, function (key, value) {
                    total += (value.cart_quantity * value.food_price)
                });
                this.total = total;
            } else {
                this.total = 0;
            }
        }
    }
}
</script>

<style scoped>
</style>
