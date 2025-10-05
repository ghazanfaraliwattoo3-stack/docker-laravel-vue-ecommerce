<template lang="">
    <header class="shadow">
        <div class="bg-dark text-center py-3">
            <span class="text-white">Your fashion partner</span>
        </div>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container">
                <router-link class="navbar-brand" to="/">
                    <img src="/frontend/logo.png" alt="logo" width="170" />
                </router-link>
                <button
                    class="navbar-toggler"
                    type="button"
                    @click="onNavbartoggle"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div
                    class="collapse navbar-collapse"
                    id="navbarSupportedContent"
                    ref="navbar"
                >
                    <ul
                        class="navbar-nav ms-auto mb-2 mb-lg-0"
                        v-if="categories && categories.length > 0"
                    >
                        <li class="nav-item" @click="onCloseNavbar" v-for="category in categories">
                            <router-link
                                class="nav-link "
                                aria-current="page"
                                :to="`/shop?categoryId=${category.id}`"
                                >{{category.name}}</router-link
                            >
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0" v-else>
                        <li class="nav-item" @click="onCloseNavbar">
                            <div class="px-5">
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
                    <div class="d-flex nav-right">
                        <router-link to="/my-account" class="ms-3 text-decoration-none text-black " v-if="$store.getters['customer/name']">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="28"
                                height="28"
                                fill=""
                                class="bi bi-person"
                                viewBox="0 0 16 16"
                            >
                                <path
                                    d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"
                                ></path>
                            </svg>
                            {{$store.getters['customer/name']}}
                        </router-link>
                        <router-link to="/login" class="ms-3 text-decoration-none" v-else>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="28"
                                height="28"
                                fill=""
                                class="bi bi-person"
                                viewBox="0 0 16 16"
                            >
                                <path
                                    d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"
                                ></path>
                            </svg>
                        </router-link>
                        <router-link
                            to="/card"
                            class="ms-3 text-decoration-none position-relative"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="28"
                                fill=""
                                class="bi bi-bag"
                                viewBox="0 0 16 16"
                            >
                                <path
                                    d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"
                                ></path>
                            </svg>
                            <div class="position-absolute  badge badge-sm rounded-circle bg-danger" style="right:-13px;top:-10px">
                                {{ $store.getters['cart/cart'].length }}

                            </div>

                        </router-link>
                    </div>
                </div>
            </div>
        </nav>
    </header>
</template>
<script>
import { Collapse } from "bootstrap";
import axios from "axios";
export default {
    name: "Header",
    data() {
        return {
            navbarInstance: null,
            categories: [],
        };
    },
    methods: {
        onNavbartoggle() {
            if (this.navbarInstance) {
                this.navbarInstance.toggle();
            }
        },
        onCloseNavbar() {
            if (this.navbarInstance) {
                this.navbarInstance.hide();
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
    },
    mounted() {
        this.fetchCategories();
        this.navbarInstance = new Collapse(this.$refs.navbar, {
            toggle: false,
        });
    },
};
</script>
<style lang="" scoped>

</style>
