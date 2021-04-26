<template>
    <b-nav-form :action="`/food_search`" method="get">
        <b-input-group class="mx-2">
            <b-form-input placeholder="Search food..." v-model="word" name="word"></b-form-input>
            <b-input-group-append>
                <b-button variant="outline-light" type="submit"><i class="fas fa-search"></i></b-button>
            </b-input-group-append>
        </b-input-group>
    </b-nav-form>
</template>

<script>
export default {
    name: "SearchBar",
    data: () => {
        return {
            word: "",
        }
    }
}
</script>

<style scoped>

</style>
