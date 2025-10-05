<template lang="">
    <div class="container-fluid">
        <div
            class="row row-cols-md-3 row-cols-1 px-md-3 g-3 text-md-start text-sm-center"
        >
            <div class="col">
                <div class="card border-0 shadow p-3">
                    <div class="card-body">
                        <h1>{{ users? users:0 }}</h1>
                        <h6>Users</h6>
                    </div>
                    <div class="footer-body border-top p-2">
                        <small
                            ><router-link
                                :to="{ name: 'users-detail' }"
                                class="text-decoration-none text-dark"
                                >View Users</router-link
                            ></small
                        >
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-0 shadow p-3">
                    <div class="card-body">
                        <h1>{{ orders? orders:0 }}</h1>
                        
                        <h6>Orders</h6>
                    </div>
                    <div class="footer-body border-top p-2">
                        <small
                            ><router-link
                                :to="{ name: 'admin-order' }"
                                class="text-decoration-none text-dark"
                                >View Orders</router-link
                            ></small
                        >
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-0 shadow p-3">
                    <div class="card-body">
                       
                        <h1>{{ products? products:0 }}</h1>

                        <h6>Products</h6>
                    </div>
                    <div class="footer-body border-top p-2">
                        <small
                            ><router-link
                                :to="{ name: 'products' }"
                                class="text-decoration-none text-dark"
                                >View Products</router-link
                            ></small
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";

export default {
    data() {
        return {
            users: null,
            orders: null,
            products: null,
            loading: false,
            token: this.$store.getters["user/token"],
        };
    },
    methods: {
        async fetchstatistics() {
            this.loading = true;
            try {
                const response = await axios.get(
                    "/api/dashboard-statics",
                    {
                        headers: {
                            Authorization: `Bearer ${this.token}`,
                        },
                    }
                );
                console.log(response.data.data)
                this.users=response.data.data.users
                this.orders=response.data.data.orders
                this.products=response.data.data.products
            } catch (error) {
           console.log("error fetching statics of dashbaord",error)
            } finally {
                this.loading = false
            }
        },
    },
    mounted() {
        this.fetchstatistics();
    },
};
</script>
<style lang=""></style>
