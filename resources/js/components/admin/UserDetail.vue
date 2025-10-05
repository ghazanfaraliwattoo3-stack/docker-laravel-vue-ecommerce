<template lang="">
    <div class="card border-0 shadow px-3 py-3">
        <div v-if="customers && customers.length>0">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="c in customers" :key="c.id">
                        <th scope="row">{{ c.id }}</th>
                        <td>{{ c.name }}</td>
                        <td>{{ c.email }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-else-if="loading"
            class=" d-flex align-items-center justify-content-center"
            style="width: 100%; height: 73vh"
        >
            <div
                class="spinner-border text-info"
                style="width: 3rem; height: 3rem"
                role="status"
            >
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div class=" d-flex align-items-center justify-content-center"
            style="width: 100%; height: 73vh" v-else> 
            <h3 class="text-center text-danger py-5">No order Found</h3>
        </div>
    </div>
</template>
<script>
import axios from "axios";

export default {
    name: "UserDetail",
    data() {
        return {
            customers: [],
            test: "test",
            loading: false,
            token: this.$store.getters["user/token"],
            
        };
    },
    methods: {
        async getCustomers() {
            this.loading = false;

            try {
                const response = await axios.get(
                    `/api/all-customers`,
                    {
                        headers: {
                            Authorization: `Bearer ${this.token}`,
                        },
                    }
                );
                if (response.status === 200) {
                    this.customers = response.data.data;
                  

                }
            } catch (error) {
                console.log("Error fetching products", error);
            } finally {
                this.loading = false;
            }
        },
    },
    mounted() {
        this.getCustomers();
    },
};
</script>
<style lang=""></style>
