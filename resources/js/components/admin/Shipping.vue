<template>
    <div class="container mt-4">
        <h2 class="mb-3">Shipping Address</h2>
        <div class="form-group mb-3">
            <label for="shipping">Enter Shipping Amount</label>

            <input
                v-model="shipping"
                id="shipping"
                type="number"
                class="form-control mt-2"
                placeholder="Enter shipping address"
            />
        </div>

        <button @click="saveAddress" :disabled="loading" class="btn btn-info">
            {{ loading ? "Saving..." : "Save" }}
        </button>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            shipping: 0,
            loading: false,
            token: this.$store.getters["user/token"],

        };
    },
    methods: {
        async fetchShipping() {
            this.loading = true;
            try {
                const response = await axios.get(
                    "http:///api/shipping",
                    {
                        headers: {
                            Authorization: `Bearer ${this.token}`,
                        },
                    }
                );
                this.shipping = response.data.data?.shipping || 0;
                // Update Vuex store also
                this.$store.dispatch("shipping/updateAddress", this.shipping);
            } catch (error) {
                console.error("Error fetching shipping:", error);
            } finally {
                this.loading = false;
            }
        },
        async saveAddress() {
            this.loading = true;
            try {
                await axios.post(
                    "http:///api/shipping",
                    {
                        shipping: this.shipping,
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${this.token}`,
                        },
                    }
                );
                // Vuex store update
                this.$store.dispatch("shipping/updateAddress", this.shipping);
            } catch (error) {
                console.error("Error saving shipping:", error);
            } finally {
                this.loading = false;
            }
        },
    },
    mounted() {
        this.fetchShipping();
    },
};
</script>
