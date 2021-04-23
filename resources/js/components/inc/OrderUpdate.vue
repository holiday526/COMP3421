<template>

</template>

<script>
export default {
    name: "OrderUpdate",
    props: ['userUid'],
    methods: {
        toast(orderId, toaster = 'b-toaster-bottom-right', append = true) {
            this.$bvToast.toast(`Order ID: ${orderId} is done, please check`, {
                title: `Alert`,
                toaster: toaster,
                solid: true,
                appendToast: append,
                variant: 'info'
            })
        },
        listenOrderChannel() {
            Echo.channel(`order-update-${this.userUid}`)
                .listen('.notification', (e) => {
                    this.toast(e.order_id)
                });
        }
    },
    mounted() {
        this.listenOrderChannel()
    }
}
</script>

<style scoped>

</style>
