<template lang="">
    <div v-if="order != null">
        <div class="clearfix pb-3">
            <router-link
                :to="{ name: 'admin-order' }"
                class="float-end text-decoration-none btn btn-info border-0 text-light"
            >
                back</router-link
            >
        </div>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <div class="col w-75">
                <div class="card border-0 shadow px-3 py-3">
                    <div class="row">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>Order Id #:{{ order.id }}</h4>
                            </div>
                            <div>
                                <p class="m-0">Date</p>
                                <p class="fw-bold">
                                    {{ formatCreatedAt(order.created_at) }}
                                </p>
                            </div>
                            <div>
                                <p class="m-0">Payment Status</p>
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
                                class="m-0 badge bg-success"
                                v-if="order.payment_status == 'paid'"
                            >
                                Paid
                            </p>
                            <p class="m-0 badge bg-danger" v-else>COD</p>
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
                            <div class="col w-25">${{ item.price }}</div>
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
            <div class="col w-25">
                <div class="card border-0 shadow px-3 py-3">
                    <div>
                        <strong>Status</strong>
                        <select
                            class="form-select"
                            aria-label="Default select example"
                            v-model="status"
                        >
                            <option selected value="pending">Pending</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div>
                        <strong>Payment Status</strong>
                        <select
                            class="form-select"
                            aria-label="Default select example"
                            v-model="payment_status"
                        >
                            <option selected value="not paid" >Not Paid</option>
                            <option value="paid">Paid</option>
                        </select>
                    </div>
                    <button class="btn btn-info my-3 text-light" @click="updateOrder">Update</button>
                </div>
            </div>
        </div>
    </div>
    <div v-else-if="loading" class="py-5">
        <div class="d-flex justify-content-center">
            <div class="spinner-border text-info" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
    <div v-else>
        <h3 class="text-center text-danger py-5">No order Found</h3>
    </div>
</template>
<script>
import axios from "axios";
import { toast } from "vue3-toastify";

export default {
    data() {
        return {
            order: null,
            loading: false,
            token: this.$store.getters["user/token"],
            params: this.$route.params,
            status:"",
            payment_status:""
        };
    },
    methods: {
        async fetchOrder() {
            this.loading = true;

            try {
                const response = await axios.get(
                    `/api/single-order/${this.params.id}`,
                    {
                        headers: {
                            Authorization: `Bearer ${this.token}`,
                        },
                    }
                );
                if (response.status === 200) {
                    // console.log("order", response.data.data);

                    this.order = response.data.data;
                    this.payment_status=this.order.payment_status
                    this.status=this.order.status
                }
            } catch (error) {
                console.log("Error fetching products", error);
            } finally {
                this.loading = false;
            }
        },
        formatCreatedAt(date) {
            const options = { year: "numeric", month: "long", day: "numeric" };
            return new Date(date).toLocaleDateString("en-US", options);
        },
        async updateOrder(){
            this.loading = true;

            try {
                const response = await axios.post(
                    `/api/update-order/${this.order.id}`,
                    {
                        payment_status:this.payment_status,
                        status:this.status,
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${this.token}`,
                        },
                    }
                );
                if (response.status === 200 && response.data) {
                    // console.log('1',response.data)
                    // console.log('2',response)
                    
                    toast.success("Order updated successfully!")

                    this.fetchOrder();
                }
            } catch (error) {
                console.log("Error fetching order update", error);
                toast.error('Some thing went wrond!')
            } finally {
                this.loading = false;
            }
        }
    },
    mounted() {
        this.fetchOrder();
    },
};
</script>
<style lang=""></style>
