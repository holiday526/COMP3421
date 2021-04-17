<template>
    <b-card
        :title="`Item: ${foodName}`"
        :img-src="foodCardImage"
        :img-alt="foodName"
        img-top
        img-height="200"
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
            {{ `Category: ${foodCategoryFormatting}` }}
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
        },
        foodType: {
            type: String
        },
        foodCategory: {
            type: String,
            default: "N.A."
        },
        foodImage: {

        }
    },
    computed: {
        foodPriceFormatting() {
            return `$ ${Number(this.foodPrice).toLocaleString()}`;
        },
        foodCardImage() {
            return (this.foodImage == null || this.foodImage === "") ? `${window.location.origin}/img/placeholder/burger.svg` : `${this.foodImage}`;
        },
        foodCategoryFormatting() {
            return this.foodType !== "Burger" ? "N.A." : this.foodCategory;
        }
    }
}
</script>

<style scoped>

</style>
