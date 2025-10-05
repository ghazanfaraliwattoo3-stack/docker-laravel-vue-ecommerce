<template lang="">
    <div class="container">
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb py-3">
                <li class="breadcrumb-item">
                    <router-link to="/">Home</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Card</li>
            </ol>
        </nav>
        <div class="mb-3">
            <h2>Card</h2>
        </div>
        <div
            class="row"
            v-if="$store.state.cart.cart && $store.state.cart.cart.length > 0"
        >
            <div class="col-md-12">
                <table class="table">
                    <tbody>
                        <tr
                            valign="middle"
                            v-for="cart in $store.state.cart.cart"
                        >
                            <th class="col-1">
                                <img
                                    :src="`uploads/products/small/${cart.image}`"
                                    class="img-fluid"
                                    :alt="cart.title"
                                />
                            </th>
                            <td valign="top">
                                <h5>{{ cart.title }}</h5>
                                <div class="py-3">
                                    <span>${{ cart.price }}</span>
                                    <button class="btn btn-size ms-5">
                                        {{ productSize(cart) }}
                                    </button>
                                </div>
                            </td>
                            <td class="col-2">
                                <div class="btn-group pt-2" role="group">
                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary"
                                        @click="descQty(cart)"
                                    >
                                        -
                                    </button>

                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary"
                                        disabled
                                    >
                                        {{ cart.qty }}
                                    </button>

                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary"
                                        @click="incQty(cart)"
                                    >
                                        +
                                    </button>
                                </div>
                            </td>
                            <td>${{cart.price * cart.qty}}</td>

                            <td>
                                <button
                                    class="btn text-danger"
                                    @click="removeCart(cart)"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="20"
                                        height="20"
                                        fill="currentColor"
                                        className="bi bi-trash3"
                                        viewBox="0 0 16 16"
                                    >
                                        <path
                                            d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"
                                        />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-else>
            <h5 class="text-info text-center col-6">Oops! Cart is empty</h5>
        </div>
        <div class="row justify-content-end">
            <div class="col-3">
                <div class="d-flex justify-content-between border-bottom mb-3">
                    <strong>Subtotal</strong>
                    <p>${{$store.getters["cart/subtotal"]}}</p>
                </div>
                <div class="d-flex justify-content-between border-bottom mb-3">
                    <strong>Shipping</strong>
                    <p>${{shipping}}</p>
                </div>
                <div class="d-flex justify-content-between border-bottom mb-3">
                    <strong>Grand Total</strong>
                    <p>${{ (parseFloat($store.getters["cart/subtotal"]) + parseFloat(shipping)).toFixed(2) }}</p>

                </div>
                <div class="d-flex justify-content-end my-4">
                    <router-link to="/checkout" class="btn btn-primary"
                        >Proceed to Checkout</router-link
                    >
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { toast } from "vue3-toastify";

export default {
    data() {
        return {
    
            shipping:0
        };
    },
    methods: {
        async fetchShipping() {
            this.loading = true;
            try {
                const response = await axios.get(
                    "http:///api/shipping",
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
        removeCart(product) {
            const cart = {
                add: false,
                size: null,
                product: product,
            };

            this.$store.dispatch("cart/add_to_cart", cart);
            toast.success("Product has been removed form cart!");
        },
        productSize(cart) {
            const size = cart.sizes.find((p) => p.id == cart.size);
            return size.name;
        },
        //
        productInCart() {
            const cart = this.$store.state.cart["cart"];
            // this.shopping_carts = cart.find(p => p.id == this.product.id);
            return cart.some((p) => p.id == this.product.id);
        },
        incQty(product){
            this.$store.dispatch("cart/inc_qty",product)
            toast.success("Product Quantity Increased!")
        },
        descQty(product){
           if(product.qty>1){
            this.$store.dispatch("cart/desc_qty",product)
            toast.success("Product Quantity Decreased!")

           }else{
            toast.error("Quantiy must be at least 1!")

           }
        }

    },
    mounted() {
        this.fetchShipping()
    },
};
</script>
<style lang=""></style>
