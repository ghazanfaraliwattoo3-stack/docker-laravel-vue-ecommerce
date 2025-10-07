<template lang="">
    <div class="container">
        <div class="row">
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb py-3">
                    <li class="breadcrumb-item">
                        <router-link to="/">Home</router-link>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Checkout
                    </li>
                </ol>
            </nav>
        </div>
        <div class="row mb-5">
            <div class="col-md-7 col-12">
                <h3 class="mb-4 text-black">Billing Details</h3>

                <div class="row">
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
                                type="email"
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
                                type="email"
                                class="form-control"
                                placeholder="Mobile"
                                name="mobile"
                                v-model="form.mobile"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-12 text-black">
                <h3 class="mb-4 text-black">Items</h3>
                <div class="row">
                    <table class="table">
                        <tbody v-if="$store.state.cart['cart'].length > 0">
                            <tr
                                v-for="cart in $store.state.cart['cart']"
                                :key="cart.id"
                            >
                                <th class="col-1">
                                    <img
                                        :src="`/uploads/products/small/${cart.image}`"
                                        width="70"
                                    />
                                </th>
                                <td>
                                    <h5>{{ cart.title }}</h5>
                                    <div>
                                        <span
                                            >${{
                                                (
                                                    parseFloat(cart.price) *
                                                    parseFloat(cart.qty)
                                                ).toFixed(2)
                                            }}</span
                                        >
                                        <button class="btn btn-size ms-5">
                                            {{ productSize(cart) }}
                                        </button>
                                        <!-- <span class="ps-5">XI</span> -->
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row justify-content-end mb-3">
            <div class="col-3 text-black">
                <div
                    class="d-flex justify-content-between border-bottom pb-1 mt-3"
                >
                    <span>Subtotal</span>
                    <span>${{ $store.getters["cart/subtotal"] }}</span>
                </div>
                <div
                    class="d-flex justify-content-between border-bottom pb-1 mt-3"
                >
                    <span>Shipping</span>
                    <span>${{ shipping }}</span>
                </div>
                <div
                    class="d-flex justify-content-between border-bottom pb-1 mt-3"
                >
                    <strong>Grand Total</strong>
                    <span
                        >${{
                            (
                                parseFloat($store.getters["cart/subtotal"]) +
                                parseFloat(shipping)
                            ).toFixed(2)
                        }}</span
                    >
                </div>
                <h3 class="my-3">Payment method</h3>
                <div class="d-flex">
                    <!-- <div class="form-check">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="flexRadioDefault"
                            id="flexRadioDefault1"
                            checked
                            value="stripe"
                            v-model="paymentMethod"
                            disabled
                        />
                        <label class="form-check-label" for="flexRadioDefault1">
                            Stripe
                        </label>
                    </div> -->
                    <div class="form-check ms-1">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="flexRadioDefault"
                            id="flexRadioDefault2"
                            value="cod"
                            v-model="paymentMethod"
                        />
                        <label class="form-check-label" for="flexRadioDefault2">
                            Cod
                        </label>
                    </div>
                </div>
                <div class="d-flex justify-content-end my-3">
                    <button
                        class="btn btn-primary"
                        @click="onSubmit"
                        :disabled="loading"
                    >
                        Pay now
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";

export default {
    name: "Checkout",
    data() {
        return {
            loading: false,
            paymentMethod: "cod",
            shipping: 0,
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
            user_id: this.$store.getters["customer/id"],
            discount: 0,
            user_name: this.$store.getters["customer/name"],
            token: this.$store.getters["user/token"],
            
        };
    },
    methods: {
        async fetchShipping() {
            this.loading = true;
            try {
                const response = await axios.get(
                    "/api/shipping",
                    {
                        headers: {
                            Authorization: `Bearer ${this.customerToken}`,
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
        productSize(cart) {
            const product = cart.sizes.find((p) => p.id === cart.size);
            return product.name;
        },
        onSubmit() {
            // form validation start
            if (!this.form.name) {
                alert("Name is required");
                return;
            }
            if (!this.form.email) {
                alert("Email is required");
                return;
            } else {
                // Email format regex check
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(this.form.email)) {
                    alert("Please enter a valid email address");
                    return;
                }
            }

            if (!this.form.address) {
                alert("Address is required");
                return;
            }
            if (!this.form.city) {
                alert("City is required");
                return;
            }
            if (!this.form.state) {
                alert("State is required");
                return;
            }
            if (!this.form.zip) {
                alert("Zip code is required");
                return;
            }
            if (!this.form.mobile) {
                alert("Mobile number is required");
                return;
            }
            // form vaidation end
            this.loading = true;
            this.submitOrderDetail();
            // yahan tum apna API ya submit ka kaam kar sakte ho
            this.loading = false;
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
        async submitOrderDetail() {
            try {
                if (this.paymentMethod == "cod") {
                    const response = await axios.post(
                        "/api/save-order",
                        {
                            user_id: this.user_id,
                            subtotal: parseFloat(
                                this.$store.getters["cart/subtotal"]
                            ).toFixed(2),
                            grand_total: (
                                parseFloat(
                                    this.$store.getters["cart/subtotal"]
                                ) + parseFloat(this.shipping)
                            ).toFixed(2),
                            shipping: this.shipping,
                            discount: this.discount,
                            payment_status: "not paid",
                            status: "pending",
                            name: this.user_name,
                            email: this.form.email,
                            mobile: this.form.mobile,
                            address: this.form.address,
                            city: this.form.city,
                            state: this.form.state,
                            zip: this.form.zip,
                            cart: this.$store.state.cart["cart"],
                        },
                        {
                            headers: {
                                Authorization: `Bearer ${this.customerToken}`,
                                "Content-Type": "application/json",
                            },
                        }
                    );
                    if (response.status === 200 && response.data) {
                        const order_id = response.data.order_id;
                        // localStorage.removeItem("shopping_carts");
                        this.$router.push(`/order-confirmation/${order_id}`);
                        this.$store.dispatch("cart/empty_cart");

                    }
                } else {
                    alert("ruku zara sabr kro");
                }
            } catch (error) {
                console.log(error);
            }
        },
    },
    mounted() {
        this.getCustomerDetail();
        this.fetchShipping()
    },
};
</script>
<style lang=""></style>
