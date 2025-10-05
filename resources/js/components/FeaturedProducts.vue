<template lang="">
    <session>
        <div class="container py-5">
            <h1>Featured Products</h1>
            <div
                class="row row-cols-md-4 row-cols-2"
                v-if="products && products.length > 0"
            >
                <div class="col" v-for="product in products">
                    <div class="product card border-0">
                        <div class="card-img overflow-hidden">
                          <router-link :to="`/product/${product.id}`" class="text-decoration-none">

                            <img
                                :src="`uploads/products/small/${product.image}`"
                                class="w-100 rounded h-100"
                                :alt="product.title"
                            />
                          </router-link>
                        </div>
                        <div class="card-body">
                          <router-link :to="`/product/${product.id}`" class="text-decoration-none">

                                {{product.title}}</router-link>
                            
                            <div class="price">
                                ${{product.price}}<span class="text-decoration-line-through px-2"
                                    >${{product.compare_price}}</span
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" v-else>
                <div class="d-flex justify-content-center">
                    <div class="spinner-border text-info" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </session>
</template>
<script>
export default {
    name: "FeaturedProducts",
    data() {
        return {
            products: [],
        };
    },
    methods: {
        async fetchProducts() {
            try {
                const response = await axios.get(
                    "/api/featured-product"
                );
                if (response.status === 200 && response.data.data) {
                    // console.log("latest", response.data.data);
                    this.products=response.data.data
                }
            } catch (error) {
                console.log(error);
            }
        },
    },
    mounted() {
        this.fetchProducts();
    },
};
</script>
<style lang=""></style>
