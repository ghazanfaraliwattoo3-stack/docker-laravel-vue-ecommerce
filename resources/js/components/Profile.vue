<template lang="">
    <div class="container border-0 shadow card p-3 pt-5" v-if="!loading">
        <form class="row" @submit.prevent="onSubmit">
            <div class="col-12 mb-3 d-flex">
                <div class="col-6 me-1">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="name"
                        name="Name"
                        v-model="form.name"
                    />
                </div>
                <div class="col-6">
                    <input
                        type="email"
                        class="form-control"
                        placeholder="Email"
                        name="email"
                        v-model="form.email"
                    />
                </div>
            </div>
            <div class="col-12 mb-3">
                <textarea
                    rows="3"
                    class="form-control"
                    placeholder="Address"
                    name="address"
                    v-model="form.address"
                ></textarea>
            </div>
            <div class="col-12 mb-3 d-flex">
                <div class="col-6 me-1">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="City"
                        name="city"
                        v-model="form.city"
                    />
                </div>
                <div class="col-6">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="State"
                        name="state"
                        v-model="form.state"
                    />
                </div>
            </div>
            <div class="col-12 mb-3 d-flex">
                <div class="col-6 me-1">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Zip"
                        name="zip"
                        v-model="form.zip"
                    />
                </div>
                <div class="col-6">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Mobile"
                        name="mobile"
                        v-model="form.mobile"
                    />
                </div>
            </div>
            <div class="clearfix">
                <button
                    class="float-end btn btn-info t text-light"
                    :disabled="loading"
                    
                >
                    Update
                </button>
            </div>
        </form>
    </div>
    <div v-else class="py-5">
        <div class="d-flex justify-content-center">
            <div class="spinner-border text-info" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import { toast } from "vue3-toastify";

export default {
    data() {
        return {
            loading: false,
            form: {
                name: "",
                email: "",
                address: "",
                city: "",
                state: "",
                zip: "",
                mobile: "",
            },
            customerToken: this.$store.getters["customer/token"],
        };
    },
    methods: {
        onSubmit() {
            // form vaidation end
            this.loading = true;
            this.updateProfile();
            // yahan tum apna API ya submit ka kaam kar sakte ho
            this.loading = false;
        },
        async updateProfile() {
            this.loading = true;
            try {
                const response = await axios.post(
                    "/api/edit-user",
                    {
                        name: this.form.name,
                        email: this.form.email,
                        address: this.form.address,
                        city: this.form.city,
                        state: this.form.state,
                        zip: this.form.zip,
                        mobile: this.form.mobile,
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${this.customerToken}`,
                            "Content-Type": "application/json",
                        },
                    }
                );
                if (response.status === 200 ) {
                    this.getCustomerDetail();

                    toast.success("Detail updated successfully!");
                }
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },

        async getCustomerDetail() {
            this.loading = true;
            try {
                const response = await axios.get(
                    "/api/customer-detail",
                    {
                        headers: {
                            Authorization: `Bearer ${this.customerToken}`,
                            "Content-Type": "application/json",
                        },
                    }
                );
                if (response.status === 200 && response.data.data) {
                    const customer = response.data.data;
                    this.form.name = response.data.data.name;
                    this.form.email = response.data.data.email;
                    this.form.address = response.data.data.address;
                    this.form.city = response.data.data.city;
                    this.form.state = response.data.data.state;
                    this.form.zip = response.data.data.zip;
                    this.form.mobile = response.data.data.mobile;
                }
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
    },
    mounted() {
        this.getCustomerDetail();
    },
};
</script>
<style lang=""></style>
