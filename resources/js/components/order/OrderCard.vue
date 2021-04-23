<template>
    <b-card v-show="show" :img-src="`/img/placeholder/burger.svg`" img-right img-height="250" :border-variant="variant">
        <b-card-title>Order ID: <span class="text-info">{{ orderId }}</span> <b-button class="ml-4" variant="info">Order Detail</b-button></b-card-title>
        <b-card-text>
            Total items: <span class="text-info">{{ totalItems }}</span>
        </b-card-text>
        <b-card-text>
            Total price: $<span class="text-info">{{ foodPriceFormatting(totalPrice) }}</span>
        </b-card-text>
        <b-card-text>
            <b-progress :max="totalItems" height="2rem">
                <b-progress-bar :value="processed" animated variant="success">
                    <span>Progress: <strong>{{ processed }} / {{ totalItems }}</strong></span>
                </b-progress-bar>
            </b-progress>
        </b-card-text>
        <b-card-text v-show="totalItems === processed">
            <span class="text-success">
                Your order is ready
            </span>
        </b-card-text>
    </b-card>
</template>

<script>
export default {
    name: "OrderCard",
    props: {
        orderId: {
            required: true
        }
    },
    data: () => {
        return {
            order: [],
            show: true,
            totalPrice: 0,
            totalItems: 0,
            processed: 0,
            variant: '',
        }
    },
    methods: {
        orderFetch() {
            axios.get(`/order/${this.orderId}`)
            .then(function (response) {
                this.order = response.data.order;
            }.bind(this))
            .catch(function (error) {
                this.show = false;
            }.bind(this))
        },
        orderTotalPrice() {
            axios.get(`/order/price/${this.orderId}`)
            .then(function (response) {
                this.totalPrice = response.data.total_price;
            }.bind(this))
            .catch(function (error) {
                console.log(`orderTotalPrice ${error}`)
                this.totalPrice = 0;
            }.bind(this))
        },
        foodPriceFormatting(price) {
            return `${Number(price).toLocaleString()}`;
        },
        listenChannel() {
            Echo.channel(`food-item-${this.orderId}`)
                .listen('.food-item-processed', (e) => {
                    this.orderFetch();
                })
        }
    },
    mounted() {
        this.orderFetch();
        this.orderTotalPrice();
        this.listenChannel();
    },
    watch: {
        order() {
            this.totalItems = this.order.length;
            this.processed = 0;
            $.each(this.order, function (index, obj) {
                if (obj.processed === 1) {
                    this.processed += 1;
                }
            }.bind(this));
        },
        processed() {
            this.variant = this.totalItems === this.processed ? 'success' : '';
        }
    }
}
</script>

<style scoped>

</style>
