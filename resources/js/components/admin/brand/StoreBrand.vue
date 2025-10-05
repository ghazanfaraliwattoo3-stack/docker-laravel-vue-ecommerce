<template lang="">
    <div class="container">
        <div class="d-flex justify-content-end">
            <router-link :to="{name:'brands'}" class="btn text-decoration-underline">Go to back</router-link>
        </div>
        <h3 class="text-center mb-md-5">Create Brand</h3>

        <Form
            class="col-md-8 mx-auto"
            @submit="onSubmit"
            :validation-schema="schema"
            ref="form"
        >
            <div class="alert alert-danger" v-if="errors">
                <div v-for="(error,index) in errors" :key="index">
                  <span v-for="(err,index) in error" :key="index">
                        {{err}}
                  </span>
                </div>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Name</label>
                <Field
                    type="email"
                    class="form-control"
                    id="exampleInputEmail1"
                    aria-describedby="emailHelp"
                    placeholder="Enter brand"
                    name="name"
                />
                <ErrorMessage name="name" class="text-danger" />
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">
                    Status
                </label>
                <select
                    class="form-select"
                    aria-label="Default select example"
                    v-model="isActive"
                >
                    <option value="1" selected>Active</option>
                    <option value="0">Block</option>
                </select>
            </div>

            <button type="submit" class="btn btn-dark">Create Brand</button>
        </Form>
    </div>
</template>
<script>
import axios from "axios";
import { Form, Field, ErrorMessage } from "vee-validate";
import * as yup from "yup";
import { toast } from "vue3-toastify";
export default {
    name: "brand Create",
    components: {
        Form,
        Field,
        ErrorMessage,
    },
    data() {
        const schema = yup.object().shape({
            name: yup.string().required(),
        });
        return {
            schema,
            isActive: 1,
            loading: true,
            errors: null,
        };
    },
    methods: {
        async onSubmit(value) {
            const name = value.name;
            const token = this.$store.getters["user/token"];

            try {
                const response = await axios.post(
                    "/api/brands/",
                    {
                        name: name,
                        status: this.isActive,
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    }
                );
                if(response.status===200){
                   
                    toast.success("brand added successfully")
                    this.$refs.form.resetForm();
                    this.isActive=1
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

                }
            }
        },
    },
};
</script>
<style lang=""></style>
