<template lang="">
    <div class="card border-0 shadow px-3">
        <table class="table" v-if="all_orders && all_orders.length > 0">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Email</th>
                    <th scope="col" >Amount</th>
                    <th scope="col">Date</th>
                    <th scope="col">Payment Status</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="order in all_orders" :key="order.id">
                    <td>
                        <router-link
                            :to="{
                                name: 'admin-detail',
                                params: { id: order.id },
                            }"
                            class="text-decoration-none text-dark"
                            >1
                        </router-link>
                    </td>
                    <td>{{ order.name }}</td>
                    <td>{{ order.email }}</td>
                    <td v-for="item in order.order_items">
                        ${{ getTotalAmount(order.order_items) }}
                    </td>
                    <td>{{ formatCreatedAt(order.created_at) }}</td>
                    <td>
                        <p
                            class="badge bg-success"
                            v-if="order.payment_status == 'paid'"
                        >
                            Paid
                        </p>
                        <p class="badge bg-danger" v-else>Not Paid</p>
                    </td>
                    <td>
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
                    </td>
                </tr>
            </tbody>
        </table>
        <table v-else-if="loading">
            <thead>
                <tr>
                    <div class="d-flex justify-content-center py-5">
                        <div class="spinner-border text-info" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </tr>
            </thead>
        </table>
        <table v-else>
            <thead>
                <tr>
                    <h3 class="text-center py-5 text-danger">
                        Oops! No Order found!
                    </h3>
                </tr>
            </thead>
        </table>
    </div>
</template>
<script>
export default {
    data() {
        return {
            all_orders: [],
            loading: false,
            token: this.$store.getters["user/token"],
        };
    },
    methods: {
        async fetchAllOrders() {
            this.loading = true;

            try {
                const response = await axios.get(
                    "/api/all-orders",
                    {
                        headers: {
                            Authorization: `Bearer ${this.token}`,
                        },
                    }
                );
                if (response.status === 200) {
                    // console.log("orders", response.data.data);

                    this.all_orders = response.data.data;
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
        getTotalAmount(items) {
            return items
                .reduce((total, item) => total + parseFloat(item.price), 0)
                .toFixed(2);
        },
    },
    mounted() {
        this.fetchAllOrders();
    },
};
</script>
<style lang=""></style>
