<template>
    <div class="row my-3">
        <div class="col-4 mx-auto py-5 border-0 card shadow">
            <form @submit.prevent="onSubmit">
                <div v-if=" $route.query.message ">
                        <div class="alert alert-danger">
                            {{ $route.query.message }}
                        </div>
                </div>
                <h3 class="text-center pb-3">User Login</h3>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                        name="email"
                        :class="[
                            'form-control my-1',
                            { 'is-invalid': error.email },
                        ]"
                        v-model="user.email"
                    />
                    <span class="invalid-feedback">{{ error.email }}</span>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input
                        name="password"
                        type="password"
                        :class="[
                            'form-control my-1',
                            { 'is-invalid': error.password },
                        ]"
                        v-model="user.password"
                    />
                    <span class="invalid-feedback">{{ error.password }}</span>
                </div>

                <div class="py-3">
                    <button class="btn btn-dark">Login</button>
                </div>
                <p class="py-3 text-center">
                    Don't have account
                    <router-link  to="/register" class="text-info">Register here</router-link>
                </p>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { toast } from "vue3-toastify";

export default {
    data() {
        return {
            user: {
                email: "",
                password: "",
            },
            userInfo: {
                name: "",
                id: "",
                token: "",
            },
            error: {
                email: "",
                password: "",
            },
            errors: null,
        };
    },
    methods: {
        async onSubmit() {
            const validEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            if (!this.user.email) {
                this.error.email = "Email is required";
                return;
            }
            if (this.user.email && !validEmail.test(this.user.email)) {
                this.error.email = "Please, enter valid email";
                return;
            }
            this.error.email = "";
            if (!this.user.password) {
                this.error.password = "Password is required";
                return;
            }
            if (this.user.password && this.user.password.length < 6) {
                this.error.password = "Password must be at least 6 characters";
                return;
            }
            this.error.email = "";
            try {
                const response = await axios.post(
                    "/api/user/login",
                    {
                        email: this.user.email,
                        password: this.user.password,
                    }
                );
                if (response.status === 200) {
                    const userData = {
                        id: response.data.data.id,
                        name: response.data.data.name,
                        token: response.data.token,
                    };
                    this.$store.dispatch("customer/set_login", userData);

                    this.$router.push("/home");
                    setTimeout(() => {
                        toast.success("login successfully");
                    }, 1);
                }
            } catch (error) {
                if (error.response) {
                    this.errors = error.response.data.errors;
                    console.log(error.response.data.errors);
                    toast.error(error.response.data.errors);
                    if (this.errors) {
                        this.error.email = this.errors.email
                            ? this.error.email[0]
                            : "";
                        this.error.password = this.errors.password
                            ? this.error.password
                            : "";
                    }
                    if (error.response.data.message) {
                        toast.error(error.response.data.message);
                    }
                } else {
                    toast.error("An error occured.Please try again");
                }
            }

        },
    },
};
</script>
