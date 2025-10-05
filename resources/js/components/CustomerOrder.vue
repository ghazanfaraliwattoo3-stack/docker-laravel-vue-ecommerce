<template lang="">
    <div class="">
        <div class="row g-4">
            <div class="col" v-if="customerOrders && customerOrders.length > 0">
                <div class="card border-0 shadow p-3 px-5">
                    <div v-for="order in customerOrders" :key="order.id">
                        <div class="row">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4>Order Id #{{ order.id }}</h4>
                                </div>
                                <div>
                                    <p class="m-0">Date</p>
                                    <p class="fw-bold">
                                        {{ formatCreatedAt(order.created_at) }}
                                    </p>
                                </div>
                                <div>
                                    <p class="m-0">Status</p>

                                    <!-- Pending -->
                                    <p
                                        v-if="order.status === 'pending'"
                                        class="badge bg-warning"
                                    >
                                        Pending
                                    </p>

                                    <!-- Shipped -->
                                    <p
                                        v-if="order.status === 'shipped'"
                                        class="badge bg-primary"
                                    >
                                        Shipped
                                    </p>

                                    <!-- Delivered -->
                                    <p
                                        v-if="order.status === 'delivered'"
                                        class="badge bg-success"
                                    >
                                        Delivered
                                    </p>

                                    <!-- Cancelled -->
                                    <p
                                        v-if="order.status === 'cancelled'"
                                        class="badge bg-danger"
                                    >
                                        Cancelled
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row row-cols-1 row-cols-md-2">
                            <div class="col">
                                <p class="m-0 fw-bold">{{ order.name }}</p>
                                <p class="m-0">{{ order.email }}</p>
                                <p class="m-0">{{ order.mobile }}</p>
                                <p class="m-0">{{ order.address }}</p>
                            </div>

                            <div class="col">
                                <p class="m-0">Payment Status</p>
                                <p
                                    class="m-0 badge bg-danger"
                                    v-if="order.payment_status == 'not paid'"
                                >
                                    COD
                                </p>
                                <p
                                    class="m-0 badge bg-success"
                                    v-if="order.payment_status == 'paid'"
                                >
                                    Paid
                                </p>
                            </div>
                        </div>
                        <div class="row py-3">
                            <strong>Items</strong>
                            <div
                                class="row row-cols-1 row-cols-md-2 py-3"
                                v-for="item in order.order_items"
                                :key="item.id"
                            >
                                <div class="col w-75">
                                    <div class="row row-cols-1 row-cols-md-2">
                                        <img
                                            :src="item.image"
                                            class="d-inline-block col"
                                            style="width: 100px"
                                        />
                                        <p class="d-inline-block col p-0">
                                            {{ item.name }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col w-25">
                                    ${{ item.unit_price }}
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col">
                                    <div class="d-flex justify-content-between">
                                        <strong>Subtotal</strong>
                                        <p class="fw-medium">
                                            ${{ order.subtotal }}
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <strong>Shipping</strong>
                                        <p class="fw-medium">
                                            ${{ order.shipping }}
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <strong>Grand Total</strong>
                                        <p class="fw-medium">
                                            ${{ order.grand_total }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col py-3" v-else-if="loading">loading...</div>
            <div class="col py-5 text-center text-danger" v-else>
                <h3>Oops! No order found!</h3>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";

export default {
    name: "customerOrder",
    data() {
        return {
            loading: false,
            customerOrders: [],
            customerToken: this.$store.getters["customer/token"],
        };
    },
    methods: {
        async fetchCustomerOrders() {
            this.loading = true;
            try {
                const response = await axios.get(
                    `/api/customer-orders`,
                    {
                        headers: {
                            Authorization: `Bearer ${this.customerToken}`,
                        },
                    }
                );
                if (response.status == 200 && response.data.data) {
                    console.log("customer order", response.data.data);
                    this.customerOrders = response.data.data;
                }
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
    formatCreatedAt(date) {
        const options = { year: "numeric", month: "long", day: "numeric" };
        return new Date(date).toLocaleDateString("en-US", options);
    },
    },
    mounted() {
        this.fetchCustomerOrders();
    },
};
</script>
<style lang=""></style>
