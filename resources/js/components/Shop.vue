<template lang="">
    <div class="container my-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb py-3">
                <li class="breadcrumb-item">
                    <router-link to="/">Home</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Shop</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-3">
                <!-- Categories Filter -->
                <div class="card border-0 shadow mb-3">
                    <div class="card-body p-5">
                        <h3 class="mb-3">Categories</h3>
                        <ul
                            class="p-0"
                            v-if="categories && categories.length > 0"
                        >
                            <li
                                v-for="category in categories"
                                :key="category.id"
                            >
                                <input
                                    type="checkbox"
                                    :id="`category-${category.id}`"
                                    v-model="checkCategories"
                                    :value="category.id"
                                    @change="fetchProducts"
                                />
                                <label
                                    class="ps-2"
                                    :for="`category-${category.id}`"
                                >
                                    {{ category.name }}
                                </label>
                            </li>
                        </ul>
                        <ul class="p-0" v-else>
                            <li>
                                <div class="d-flex justify-content-center">
                                    <div
                                        class="spinner-border spinner-border-sm text-info"
                                        role="status"
                                    >
                                        <span class="visually-hidden"
                                            >Loading...</span
                                        >
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Brands Filter -->
                <div class="card border-0 shadow">
                    <div class="card-body p-5">
                        <h3 class="mb-3">Brands</h3>
                        <ul class="p-0" v-if="brands && brands.length > 0">
                            <li v-for="brand in brands" :key="brand.id">
                                <input
                                    type="checkbox"
                                    :id="`brand-${brand.id}`"
                                    v-model="checkBrands"
                                    :value="brand.id"
                                    @change="fetchProducts"
                                />
                                <label class="ps-2" :for="`brand-${brand.id}`">
                                    {{ brand.name }}
                                </label>
                            </li>
                        </ul>
                        <ul class="p-0" v-else>
                            <li>
                                <div class="d-flex justify-content-center">
                                    <div
                                        class="spinner-border spinner-border-sm text-info"
                                        role="status"
                                    >
                                        <span class="visually-hidden"
                                            >Loading...</span
                                        >
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Products Display -->
            <div class="col-9">
                <div
                    class="row row-cols-md-3 pb-5"
                    v-if="products && products.length > 0"
                >
                    <div
                        class="col"
                        v-for="product in products"
                        :key="product.id"
                    >
                        <div class="product card border-0">
                            <div class="card-img overflow-hidden">
                                <router-link :to="`/product/${product.id}`">
                                    <img
                                        :src="`uploads/products/small/${product.image}`"
                                        class="w-100 rounded"
                                        :alt="product.title"
                                    />
                                </router-link>
                            </div>
                            <div class="card-body">
                                <router-link
                                    :to="`/product/${product.id}`"
                                    class="text-decoration-none"
                                    >{{ product.title }}</router-link
                                >
                                <div class="price">
                                    ${{ product.price }}
                                    <span
                                        class="text-decoration-line-through px-2"
                                        >${{ product.compare_price }}</span
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Loading Spinner -->
                <div class="row pb-5 h-100" v-else-if="loading">
                    <div
                        class="d-flex justify-content-center align-items-center"
                    >
                        <div
                            class="spinner-border spinner-border text-info"
                            role="status"
                        >
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="row pb-5 h-100" v-else>
                    <div
                        class="d-flex justify-content-center align-items-center my-3"
                    >
                        <h3 class="text-center text-danger">
                            Oops! No Products Found
                        </h3>
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
            checkCategories: [],
            checkBrands: [],
            brands: [],
            categories: [],
            products: [],
            loading: false,
        };
    },
    methods: {
        async fetchBrands() {
            try {
                const response = await axios.get(
                    "/api/get-brands"
                );
                if (response.status === 200 && response.data) {
                    this.brands = response.data.data;
                }
            } catch (error) {
                console.log(error);
            }
        },
        async fetchCategories() {
            try {
                const response = await axios.get(
                    "/api/get-categories"
                );
                if (response.status === 200 && response.data) {
                    this.categories = response.data.data;
                }
            } catch (error) {
                console.log(error);
            }
        },
        async fetchProducts() {
            this.loading = true;
            try {
                const response = await axios.post(
                    "/api/filter-products",
                    {
                        categoryId: this.checkCategories,
                        brandId: this.checkBrands,
                    }
                );
                if (response.status === 200 && response.data) {
                    this.products = response.data.data;
                    // Initially set filtered products to all products
                }
            } catch (error) {
                console.log(error);
            }
        },
    },
    watch: {
    '$route.query.categoryId'(newCategoryId) {
        if (newCategoryId) {
            this.checkCategories = [parseInt(newCategoryId)];
        } else {
            this.checkCategories = [];
        }
        this.fetchProducts();
    }
},

    mounted() {
        const categoryId=this.$route.query.categoryId
        if (categoryId) {
        this.checkCategories = [parseInt(categoryId)];
    }

        this.fetchBrands();
        this.fetchCategories();
        this.fetchProducts();
    },
};
</script>

<style lang=""></style>
