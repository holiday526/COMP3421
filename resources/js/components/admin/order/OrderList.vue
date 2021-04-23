<template>
    <div>

        <div v-if="!transformedOrders || transformedOrders.length == 0">Loading...</div>
        <b-card v-else v-for="(order, index) in transformedOrders" :key="index" class="my-2" :border-variant="doneVariant(order)">
            <b-row>
                <b-card-text class="ml-2">
                    Order ID: <span class="text-info">{{ order[0].order_id }}</span>, User UID: <span class="text-info">{{ order[0].user_uid }}</span>
                </b-card-text>
            </b-row>
            <b-row>
                <b-col cols="10">
                    <b-list-group horizontal>
                        <b-list-group-item v-for="obj in order" :key="reRender[index]">
                            <b-button :class="{'btn-secondary': obj.processed === 0, 'btn-success': obj.processed === 1 }" @click="updateItemStatus(obj, index)">{{ `${obj.food_name}, qty: ${obj.quantity}` }}</b-button>
                        </b-list-group-item>
                    </b-list-group>
                </b-col>
                <b-col>
                    <b-button v-if="doneVariant(order) === 'success'" class="ml-2" variant="warning">notify user</b-button>
                    <b-card-text v-else class="ml-2 text-danger">Not yet done</b-card-text>
                </b-col>
            </b-row>
        </b-card>
        <b-button @click="ordersFetch">Fetch</b-button>
    </div>
</template>

<script>
export default {
    name: "OrderList",
    data: () => {
        return {
            orders: [],
            transformedOrders: [],
            reRender: []
        }
    },
    methods: {
        async ordersFetch() {
             await axios.get('/admin/order/list')
                .then(function (response){
                    this.orders = response.data.orders;
                }.bind(this))
                .catch(function (error){
                    console.log(`ordersFetch ${error}`);
                });
            this.ordersTransform();
        },
        ordersTransform() {
            if (this.orders.length !== 0) {
                let orderIndex = 0;
                for (let i = 0; i < this.orders.length; i++) {
                    if (i === 0) {
                        this.transformedOrders[orderIndex] = [this.orders[i]];
                        continue;
                    }
                    if (this.transformedOrders[orderIndex].length > 0) {
                        if (this.transformedOrders[orderIndex][0].order_id === this.orders[i].order_id) {
                            this.transformedOrders[orderIndex].push(this.orders[i]);
                        } else {
                            orderIndex++;
                            this.transformedOrders[orderIndex] = [this.orders[i]];
                        }
                    }
                }
            }
            this.$set(this.transformedOrders, this.transformedOrders, this.transformedOrders);
        },
        updateItemStatus(orderObj, index) {
            axios.post('/admin/order/item/update',
                {
                    'food_id': orderObj.food_id,
                    'order_id': orderObj.order_id
                },
                {
                    headers: {
                        'X-CSRF-Token': $('meta[name=_token]').attr('content')
                    }
                }
                )
                .then(function (response) {
                    this.ordersFetch();
                }.bind(this))
                .catch(function (error){
                    console.log(`updateItemStatus ${error}`)
                });
            this.transformedOrders[index].find(ele => ele.food_id === orderObj.food_id ).processed
                = this.transformedOrders[index].find(ele => ele.food_id === orderObj.food_id ).processed === 0 ? 1 : 0;
            this.reRender++;
        },
        processedVariant(processed) {
            return processed ? 'success' : 'secondary';
        },
        doneVariant(order) {
            for (let i = 0; i < order.length; i++) {
                if (order[i].processed === 0) {
                    return 'danger';
                }
            }
            return 'success';
        },
        setReRenderKey() {
            for (let i = 0; i < this.transformedOrders.length; i++) {
                this.reRender[i] = 0;
            }
        }
    },
    computed: {

    },
    mounted() {
        this.ordersFetch();
    }
}
</script>

<style scoped>

</style>
