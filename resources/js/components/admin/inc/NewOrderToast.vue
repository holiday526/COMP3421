<template>

</template>

<script>
export default {
    name: "NewOrderToast",
    methods: {
        toast(orderId, toaster = 'b-toaster-bottom-right', append = true) {
            this.$bvToast.toast(`Order ID: ${orderId} is added`, {
                title: `Alert`,
                toaster: toaster,
                solid: true,
                appendToast: append,
                variant: 'info'
            })
        },
        listenOrderChannel() {
            Echo.channel('order-create')
                .listen('.user-order-create', (e)=> {
                    this.toast(e.order_id);
                })
        }
    },
    mounted() {
        this.listenOrderChannel();
    }
}
</script>

<style scoped>

</style>
