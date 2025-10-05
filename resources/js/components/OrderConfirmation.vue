<template lang="">
    <div class="container my-5">
        <div v-if="orderDetail != null">
            <h1 class="text-center text-success">Thank You</h1>
            <p class="text-center">Your order has been successfully placed</p>
            <div class="card">
                <div class="card-header">
                    <strong>Order Summary</strong>
                </div>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-2">
                        <div class="col">
                            <p>
                                <strong class="pe-3">Order Id</strong>#{{
                                    orderDetail.id
                                }}
                            </p>
                        </div>
                        <div class="col">
                            <p>
                                <strong class="pe-3">Customer</strong
                                >{{ orderDetail.name }}
                            </p>
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-2">
                        <div class="col">
                            <p>
                                <strong class="pe-3">Order Date</strong
                                >{{ orderDetail.created_at }}
                            </p>
                        </div>
                        <div class="col">
                            <p>
                                <strong class="pe-3">Address</strong
                                >{{ orderDetail.address }}
                            </p>
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-2">
                        <div class="col">
                            <p>
                                <strong class="pe-3">Status</strong
                                ><span class="badge bg-warning text-dark">{{
                                    orderDetail.status
                                }}</span>
                            </p>
                        </div>
                        <div class="col">
                            <p>
                                <strong class="pe-3">Contact</strong
                                >{{ orderDetail.mobile }}
                            </p>
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-2">
                        <div class="col">
                            <p>
                                <strong class="pe-3">Payment</strong
                                >{{ orderDetail.payment_status }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card my-3">
                <div class="card-header">Items</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr class="table table-light">
                                <th scope="col">Item</th>
                                <th scope="col">Quantity</th>
                                <th scope="col" class="col-2">Price</th>
                                <th scope="col" class="col-2">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="item in orderDetail.order_items"
                                :key="item.id"
                            >
                                <td scope="row">{{ item.name }}</td>
                                <td>{{ item.qty }}</td>
                                <td>${{ item.unit_price }}</td>
                                <td>${{ item.price }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col ms-auto col-4 flex-column text-end">
                            <p>
                                <strong class="pe-3">Subtotal</strong>${{
                                    orderDetail.subtotal
                                }}
                            </p>
                            <p>
                                <strong class="pe-3">Shipping</strong>${{
                                    orderDetail.shipping
                                }}
                            </p>
                            <p>
                                <strong class="pe-3">Grand Total</strong>${{
                                    orderDetail.grand_total
                                }}
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-center">
                            <router-link
                                :to="{ name: 'customer-order' }"
                                class="text-decoration-none btn btn-info mx-1 text-light"
                                style="color: white !important"
                            >
                                View Order Detail
                            </router-link>
                            <router-link
                                to="/"
                                class="text-decoration-none btn btn-outline-dark border-0"
                            >
                                Continue Shopping
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else-if="loading">
            <div>loading...</div>
        </div>
        <div v-else>
            <h3 class="text-center text-danger">Oops! not order found!</h3>
        </div>
    </div>
</template>
<script>
import axios from "axios";

export default {
    name: "orderConfirmation",
    data() {
        return {
            loading: false,
            orderDetail: [],
            customerToken: this.$store.getters["customer/token"],
            // customerId:this.$store.getters['customer/id'],
            params: this.$route.params,
        };
    },
    methods: {
        async fetchOrderDetail() {
            this.loading = true;
            try {
                const response = await axios.get(
                    `/api/detail-order/${this.params.id}`,
                    {
                        headers: {
                            Authorization: `Bearer ${this.customerToken}`,
                        },
                    }
                );
                if (response.status == 200 && response.data.data) {
                // console.log("data", response.data.data);
                    this.orderDetail = response.data.data;
                }
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
    },
    mounted() {
        this.fetchOrderDetail();
    },
};
</script>
<style lang=""></style>
