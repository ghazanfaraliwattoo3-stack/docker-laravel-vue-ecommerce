<template>
    <div class="row my-3">
        <div class="col-4 mx-auto py-5 border-0 card shadow">
            <form @submit.prevent="onSubmit">
                <h3 class="text-center pb-3">Registration Form</h3>

                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input
                        name="name"
                        :class="['form-control my-1', { 'is-invalid': error.name }]"
                        v-model="user.name"
                    />
                    <span class="invalid-feedback">{{ error.name }}</span>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                        name="email"
                        :class="['form-control my-1', { 'is-invalid': error.email }]"
                        v-model="user.email"
                    />
                    <span class="invalid-feedback">{{ error.email }}</span>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input
                        name="password"
                        type="password"
                        :class="['form-control my-1', { 'is-invalid': error.password }]"
                        v-model="user.password"
                    />
                    <span class="invalid-feedback">{{ error.password }}</span>
                </div>

                <div class="py-3">
                    <button class="btn btn-dark">Register</button>
                </div>

                <div class="text-center mt-3">
                    <span>Already have an account? </span>
                    <router-link to="/login" class="text-primary">Login</router-link>
                </div>
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
                name: "",
                email: "",
                password: "",
            },
            error: {
                name: "",
                email: "",
                password: "",
            },
            errors: null,
        };
    },
    methods: {
        async onSubmit() {
            const validEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            // Validation
            if (!this.user.name) {
                this.error.name = "Name is required";
                return;
            } else {
                this.error.name = "";
            }

            if (!this.user.email) {
                this.error.email = "Email is required";
                return;
            }
            if (this.user.email && !validEmail.test(this.user.email)) {
                this.error.email = "Please enter a valid email";
                return;
            } else {
                this.error.email = "";
            }

            if (!this.user.password) {
                this.error.password = "Password is required";
                return;
            }
            if (this.user.password.length < 6) {
                this.error.password = "Password must be at least 6 characters";
                return;
            } else {
                this.error.password = "";
            }

            // Submit Form
            try {
                const response = await axios.post(
                    "/api/user/register",
                    {
                        name: this.user.name,
                        email: this.user.email,
                        password: this.user.password,
                    }
                );

                if (response.status === 200) {
                    toast.success("Registered successfully! Please login.");
                    this.$router.push("/login");
                }
            } catch (error) {
                if (error.response) {
                    this.errors = error.response.data.errors;
                    if (this.errors) {
                        this.error.name = this.errors.name ? this.errors.name[0] : "";
                        this.error.email = this.errors.email ? this.errors.email[0] : "";
                        this.error.password = this.errors.password ? this.errors.password[0] : "";
                    }
                    if (error.response.data.message) {
                        toast.error(error.response.data.message);
                    }
                } else {
                    toast.error("An error occurred. Please try again.");
                }
            }
        },
    },
};
</script>

<style scoped>
/* Optional: Apna style add kar sakte ho */
</style>
