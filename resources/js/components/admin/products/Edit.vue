<template lang="">
    <div class="container">
        
        <div class="d-flex justify-content-end">
            <router-link
                :to="{ name: 'products' }"
                class="btn text-decoration-underline"
                >Go to back{{ image_id }}</router-link
            >
        </div>
        <h3 class="text-center mb-md-5">Edit product</h3>

        <form class="col-md-8 mx-auto" @submit.prevent="onSubmit">
            <div class="alert alert-danger" v-if="errors">
                <div v-for="(error, index) in errors" :key="index">
                    <span v-for="(err, index) in error" :key="index">
                        {{ err }}
                    </span>
                </div>
            </div>
            <div class="row">
                <!-- title field -->
                <div class="mb-3 col-12">
                    <label for="title" class="form-label">Title</label>
                    <input
                        type="text"
                        class="form-control"
                        id="title"
                        aria-describedby="emailHelp"
                        placeholder="Enter product"
                        v-model="title"
                    />
                </div>
                <!-- category field -->
                <div class="mb-3 col-md-6 col-12">
                    <label for="category" class="form-label"> Category </label>
                    <select
                        class="form-select"
                        aria-label="Default select example"
                        as="select"
                        id="category"
                        v-model="category"
                        v-if="showCategory && showCategory.length > 0"
                    >
                        <option value="" disabled>Select a Category</option>
                        <option
                            v-for="cat in showCategory"
                            :key="cat.id"
                            :value="cat.id"
                        >
                            {{ cat.name }}
                        </option>
                    </select>
                </div>
                <!-- brand field -->
                <div class="mb-3 col-md-6 col-12">
                    <label for="brand" class="form-label"> Brand </label>
                    <select
                        class="form-select"
                        aria-label="Default select example"
                        id="brand"
                        as="select"
                        v-model="brand"
                        v-if="showBrand && showBrand.length > 0"
                    >
                        <option value="" disabled>Select a Brand</option>
                        <option
                            v-for="brand in showBrand"
                            :key="brand.id"
                            :value="brand.id"
                        >
                            {{ brand.name }}
                        </option>
                    </select>
                </div>
                <!-- short description -->
                <div class="mb-3">
                    <label for="short_description" class="form-label"
                        >Short Description</label
                    >
                    <textarea
                        class="form-control"
                        id="short_description"
                        rows="3"
                        placeholder="Short Description"
                        v-model="short_description"
                    ></textarea>
                </div>
                <!-- description -->
                <div class="mb-3">
                    <label for="" class="form-label">Description</label>
                    <textarea
                        class="form-control"
                        id="description"
                        rows="7"
                        placeholder="description"
                        v-model="description"
                    ></textarea>
                </div>
                <h3 class="my-3">Pricing</h3>

                <!-- price field -->
                <div class="mb-3 col-md-6 col-12">
                    <label for="price" class="form-label"> Price </label>
                    <input
                        type="number"
                        class="form-control"
                        id="price"
                        aria-describedby="emailHelp"
                        placeholder="Enter price"
                        v-model="price"
                    />
                </div>
                <!-- comapre price field -->
                <div class="mb-3 col-md-6 col-12">
                    <label for="compare_price" class="form-label">
                        Comapre Price
                    </label>
                    <input
                        type="number"
                        class="form-control"
                        id="compare_price"
                        aria-describedby="emailHelp"
                        placeholder="Enter compare price"
                        v-model="compare_price"
                    />
                </div>
                <h3 class="my-3">Inventory</h3>

                <!-- sku field -->
                <div class="mb-3 col-md-6 col-12">
                    <label for="sku" class="form-label"> Sku </label>
                    <input
                        type="text"
                        class="form-control"
                        id="sku"
                        aria-describedby="emailHelp"
                        placeholder="Sku"
                        v-model="sku"
                    />
                </div>
                <!-- barcode price field -->
                <div class="mb-3 col-md-6 col-12">
                    <label for="barcode" class="form-label"> Barcode </label>
                    <input
                        type="text"
                        class="form-control"
                        id="barcode"
                        placeholder="barcode"
                        v-model="barcode"
                    />
                </div>
                <!-- qty field -->
                <div class="mb-3 col-md-6 col-12">
                    <label class="form-label" for="qty"> Qty </label>
                    <input
                        type="number"
                        class="form-control"
                        id="qty"
                        placeholder="qty"
                        v-model="qty"
                    />
                </div>
                <!-- status field -->

                <div class="mb-3 col-md-6 col-12">
                    <label for="status" class="form-label"> Status </label>
                    <select
                        class="form-select"
                        id="status"
                        as="select"
                        v-model="status"
                    >
                        <option value="" disabled>Select a status</option>
                        <option value="1" selected>Active</option>
                        <option value="0">Block</option>
                    </select>
                </div>
                <h3 class="my-3">Product Image</h3>
                <!-- featured field -->

                <div class="mb-3 col-12">
                    <label for="featured " class="form-label"> Featured </label>
                    <select
                        class="form-select"
                        id="featured "
                        as="select"
                        v-model="is_featured"
                    >
                        <option value="" disabled>Select a featured</option>
                        <option value="yes" selected>Yes</option>
                        <option value="no">No</option>
                    </select>
                    
                </div>
                <!-- sizes field -->
                <h3 class="my-3">Product Sizes</h3>

                <div class="d-flex flex-wrap gap-1">
                    <div
                        class="form-check form-check-inline"
                        v-for="size in sizes"
                        :key="size.id"
                    >
                        <input
                            class="form-check-input"
                            type="checkbox"
                            :id="'size-' + size.id"
                            :value="size.id"
                            v-model="selectSizes"
                        />
                        <label
                            class="form-check-label"
                            :for="'size-' + size.id"
                        >
                            {{ size.name }}
                        </label>
                    </div>
                </div>
                <!-- image field -->
                <div class="mb-3 col-12">
                    <label for="image" class="form-label">Edit Image</label>
                    <input
                        type="file"
                        class="form-control"
                        id="image"
                        @change="handleFileChange"
                    />
                </div>
                <div class="my-3" v-if="imageName">
                    <h3>New Image</h3>
                    <img
                        :src="`/uploads/temp/${imageName}`"
                        class="img-fluid rounded-top"
                        :alt="imageName"
                    />
                </div>
                <div class="my-3" v-if="old_image">
                    <h3>Old Image</h3>

                    <img
                        :src="`/uploads/products/large/${old_image}`"
                        class="img-fluid rounded-top"
                        alt=""
                    />
                </div>
            </div>

            <button type="submit" class="btn btn-dark" :disabled="loading">
                Update product
            </button>
        </form>
    </div>
</template>
<script>
import axios from "axios";
import { Form, Field, ErrorMessage } from "vee-validate";
import * as yup from "yup";
import { toast } from "vue3-toastify";
import { shallowReactive } from "vue";

export default {
    name: "product Edit",

    components: {
        Form,
        Field,
        ErrorMessage,
    },
    data() {
        return {
            isActive: 1,
            loading: false,
            errors: null,
            title: "",
            category: "",
            brand: "",
            short_description: "",
            description: "",
            price: "",
            comapre_price: "",
            sku: "",
            barcode: "",
            qty: "",
            status: "",
            image: null,
            image_id: "",
            imageName: "",
            showCategory: [],
            showBrand: [],
            is_featured: "",
            old_image:"",
            token: this.$store.getters["user/token"],
            sizes: [],
            selectSizes: [],
        };
    },
    methods: {
        async fetchSizes() {
            const token = this.$store.getters["user/token"];

            this.loading = true;

            try {
                const response = await axios.get(
                    "/api/sizes",
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    }
                );
                if (response.status === 200) {
                    // console.log("brands", response.data);
                    this.loading = false;
                    this.sizes = response.data.data;
                }
            } catch (error) {
                console.log("Error fetching brands", error);
            }
        },
        async handleFileChange(event) {
            this.loading = true;
            const token = this.$store.getters["user/token"];

            const formFile = new FormData();
            const file = event.target.files[0];
            this.image = file;
            formFile.append("image", this.image);
            try {
                const response = await axios.post(
                    "/api/images",

                    formFile,
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    }
                );
                if (response.status === 200) {
                    // console.log("data", response.data);
                    // console.log("image", response.data.data.name);
                    // console.log("id", response.data.data.id);
                    (this.image_id = response.data.data.id),
                        (this.imageName = response.data.data.name);
                }
            } catch (error) {
                toast.error("Oops, Failed to create images");
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
        async fetchCategory() {
            this.loading = true;
            const token = this.$store.getters["user/token"];

            try {
                const response = await axios.get(
                    "/api/categories",
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    }
                );
                if (response.status === 200) {
                    // console.log("categories", response.data);
                    this.loading = false;
                    this.showCategory = response.data.data;
                }
            } catch (error) {
                console.log("Error fetching categories", error);
            }
        },
        async fetchbrand() {
            const token = this.$store.getters["user/token"];

            this.loading = true;

            try {
                const response = await axios.get(
                    "/api/brands",
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    }
                );
                if (response.status === 200) {
                    // console.log("brands", response.data);
                    this.loading = false;
                    this.showBrand = response.data.data;
                }
            } catch (error) {
                console.log("Error fetching brands", error);
            }
        },
        async onSubmit(value) {
            const name = value.name;
            const token = this.$store.getters["user/token"];

            try {
                const id = this.$route.params.id;

                const response = await axios.put(
                    `/api/products/${id}`,
                    {
                        title: this.title,
                        price: this.price,
                        compare_price: this.compare_price,
                        category_id: this.category,
                        brand_id: this.brand,
                        qty: this.qty,
                        sku: this.sku,
                        barcode: this.barcode,
                        short_description: this.short_description,
                        description: this.description,
                        status: this.status,
                        is_featured: this.is_featured,
                        image: this.image_id,
                        sizes:this.selectSizes

                    },
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    }
                );
                if (response.status === 200) {
                    toast.success("Product has been updated successfully");
                    // this.isActive = 1;
                    this.$router.push({ name: 'products' })
                }
            } catch (error) {
                if (error.response) {
                    if (error.response.data.errors) {
                        this.errors = error.response.data.errors;
                    } else {
                        this.errors = error.response.data.message;
                    }
                } else {
                    toast.error("Oops, Failed to create brand");
                    console.log(error);
                }
            }
        },
        async fetchproduct() {
            this.loading = true;

            try {
                const id = this.$route.params.id;
                const response = await axios.get(
                    `/api/products/${id}`,
                    {
                        headers: {
                            Authorization: `Bearer ${this.token}`,
                        },
                    }
                );
                if (response.status === 200) {
                    // console.log("products", response.data);
                    this.loading = false;
                    const product = response.data.data;
                    // console.log("edit product", response.data.data);
                    this.title = product.title;
                    this.category = product.category_id;
                    this.brand = product.brand_id;
                    this.short_description = product.short_description;
                    this.description = product.description;
                    this.price = product.price;
                    this.compare_price = product.compare_price;
                    this.sku = product.sku;
                    this.barcode = product.barcode;
                    this.qty = product.qty;
                    this.status = product.status;
                    this.is_featured = product.is_featured;
                    this.old_image=product.image
                   console.log('size',product)
                   this.selectSizes = product.sizes.map(size => size.id);  // <- Important
                   console.log(this.selectSizes)


                }
            } catch (error) {
                console.log("Error fetching products", error);
            }
        },
        
    },
    mounted() {
        this.fetchproduct();
        this.fetchCategory();
        this.fetchbrand();
        this.fetchSizes();
    },
};
</script>
<style scoped></style>
