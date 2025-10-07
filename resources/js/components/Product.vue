<template lang="">
<div class="container" v-if="product">
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb py-3">
                <li class="breadcrumb-item">
                    <router-link to="/" class="text-decoration-none text-info"
                        >Home</router-link
                    >
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <router-link
                        to="/shop"
                        class="text-decoration-none text-info"
                        >Shop</router-link
                    >
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ product.title }}
                </li>
            </ol>
        </nav>
        <div class="row my-3 text-black">
            <div class="col-5 d-flex justify-content-center">
                <img
                    :src="`/uploads/products/large/${product.image}`"
                    :alt="product.title"
                    class="img-fluid object-fit-cover"
                />
            </div>
            <div class="col-7">
                <h3>{{ product.title }}</h3>
                <div class="d-flex align-items-center">
                    <star-rating
                        v-bind:increment="0.5"
                        v-bind:max-rating="5"
                        inactive-color="gray"
                        active-color="yellow"
                        v-bind:star-size="30"
                        @update:rating="setRating"
                    >
                    </star-rating>
                    <span class="px-1"> reviews</span>
                </div>
                <div class="h2 py-3">
                    ${{ product.price
                    }}<span class="text-decoration-line-through old-price px-2"
                        >${{ product.compare_price }}</span
                    >
                </div>
                <div>
                    {{ product.short_description }}
                </div>
                <div class="mt-3">
                    <strong>Select Size</strong><br />
                    <div
                        class="btn-group pt-2"
                        role="group"
                        aria-label="Size options"
                    >
                        <button
                            type="button"
                            class="btn btn-outline-secondary btn-active"
                            :class="{ 'btn-selected': product_size === size.id }"
                            v-for="size in product.sizes"
                            @click="productSize(size.id)"
                        >
                            {{ size.name }}
                        </button>
                    </div>
                </div>
                <div class="my-3" v-if="!productInCart()">
                    <button
                        class="btn btn-primary text-uppercase"
                        @click="addToCart(product)"
                    >
                        Add to Cart
                    </button>
                </div>

                <div class="mt-3" v-else>
                    <div class="btn-group pt-2" role="group">
                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            @click="descQty(product)"
                        >
                            -
                        </button>

                        <button type="button" class="btn btn-outline-secondary" disabled>
                            {{shopping_carts.qty}}
                        </button>

                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            @click="incQty(product)"
                            
                        >
                            +
                        </button>
                    </div>
                </div>

                <hr />
                <div class="d-flex">
                    <strong>SKU:</strong>
                    <p class="px-2">{{ product.sku }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button
                        class="nav-link active"
                        id="home-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#description-tab"
                        type="button"
                        role="tab"
                        aria-controls="home-tab-pane"
                        aria-selected="true"
                    >
                        Description
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button
                        class="nav-link"
                        id="profile-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#reviews-tab"
                        type="button"
                        role="tab"
                        aria-controls="profile-tab-pane"
                        aria-selected="false"
                    >
                        Reviews (10)
                    </button>
                </li>
            </ul>
            <div class="tab-content my-3 text-black" id="myTabContent">
                <div
                    class="tab-pane fade show active"
                    id="description-tab"
                    role="tabpanel"
                    aria-labelledby="home-tab"
                    tabindex="0"
                >
                    {{ product.description }}
                </div>
                <div
                    class="tab-pane fade"
                    id="reviews-tab"
                    role="tabpanel"
                    aria-labelledby="profile-tab"
                    tabindex="0"
                >
                    Reviews area
                </div>
            </div>
        </div>
    </div>
    <div v-else>
        <!-- loader -->
        <div
            class="d-flex justify-content-center align-items-center"
            style="height: 100vh"
        >
            <div class="spinner-border text-info" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
</template>
<script>
import StarRating from "vue-star-rating";

// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from "swiper/vue";

// Import Swiper styles
import "swiper/css";
import { toast } from "vue3-toastify";

import "swiper/css/free-mode";
import "swiper/css/navigation";
import "swiper/css/thumbs";

// import required modules
import { FreeMode, Navigation, Thumbs } from "swiper/modules";

export default {
    name: "Product",
    components: {
        Swiper,
        SwiperSlide,
        StarRating,
    },
    data() {
        return {
            thumbsSwiper: null,
            modules: [FreeMode, Navigation, Thumbs],
            rating: 0,
            params: this.$route.params,
            loading: false,
            product: null,
            product_size: null,
            shopping_carts:null
        };
    },
    methods: {
        setThumbsSwiper(swiper) {
            this.thumbsSwiper = swiper;
        },
        setRating(rating) {
            this.rating = rating;
        },
        async fetchProduct() {
            this.loading = true;
            try {
                const response = await axios.get(
                    `/api/get-product/${this.params.id}`
                );
                if (response.status && response.data.data) {
                    // console.log("detail", response);
                    this.product = response.data.data;
                }
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
        productSize(id) {
            this.product_size = id;
        },
        addToCart(product) {
            if (!this.product_size) {
                //   if size is not selected
                toast.error("Please select size");
            } else {
                const cart = {
                    add: true,
                    size: this.product_size, // Size ko bhi include karna hoga
                    product: product,
                };

                // Vuex store mein add_to_cart action ko call karna
                this.$store.dispatch("cart/add_to_cart", cart);
                toast.success("Product has been added to cart");
            }
        },
        productInCart() {
            const cart = this.$store.state.cart["cart"];
            this.shopping_carts = cart.find(p => p.id == this.product.id);
            return cart.some((p) => p.id == this.product.id);
        },
        incQty(product){
            this.$store.dispatch("cart/inc_qty",product)
            toast.success("Product Quantity Increased!")
        },
        descQty(product){
           if(this.shopping_carts.qty>1){
            this.$store.dispatch("cart/desc_qty",product)
            toast.success("Product Quantity Decreased!")

           }else{
            toast.error("Quantiy must be at least 1!")

           }

        }
    },
    mounted() {
        this.fetchProduct();
    },
};
</script>
<style scoped>
.mySwiper {
    height: 500px;
    overflow: hidden;
}
.mySwiper2 {
    height: 500px;
}
.thumbs-container {
    height: 500px;
}

.btn-selected {
  background-color: #43c3D1; /* Bootstrap primary blue */
  color: white;
  border-color: #43c3D1;
}


</style>
