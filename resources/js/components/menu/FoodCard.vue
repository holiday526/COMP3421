<template>
    <b-card
        :title="`Item: ${foodName}`"
        img-src="https://picsum.photos/600/300/?image=25"
        :img-alt="foodName"
        img-top
        tag="article"
        style="max-width: 20rem;"
        class="mb-2"
    >
        <b-card-text>
            {{ foodDescription }}
        </b-card-text>
        <b-card-text>
            {{ `Price: ${foodPriceFormatting}` }}
        </b-card-text>
        <b-card-text>
            {{ `Type: ${foodType}` }}
        </b-card-text>
        <b-card-text>
            {{ `Category: ${foodCategory}` }}
        </b-card-text>

        <b-button v-if="!loggedIn" href="#" block variant="warning">Login for ordering</b-button>
        <b-button v-else block href="#" block variant="success">Add to cart</b-button>
    </b-card>
</template>

<script>
export default {
    name: "FoodCard",
    props: {
        loggedIn: {
            required: true,
            default: false,
            type: Boolean
        },
        foodName: {
            default: "*Food name*",
            type: String
        },
        foodDescription: {
            default: "*Food description*",
            type: String
        },
        foodPrice: {
            default: 0.0,
            type: Number
        },
        foodType: {
            type: String
        },
        foodCategory: {
            type: String,
            default: "N.A."
        }
    },
    computed: {
        foodPriceFormatting() {
            return `$ ${Number(this.foodPrice).toLocaleString()}`;
        }
    }
}
</script>

<style scoped>

</style>
