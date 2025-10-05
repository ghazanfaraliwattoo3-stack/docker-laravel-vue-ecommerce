<template lang="">
    <div class="container">
        <div class="d-flex justify-content-end">
            <router-link
                :to="{ name: 'categories' }"
                class="btn text-decoration-underline"
                >Go to back</router-link
            >
        </div>
        <h3 class="text-center my-5">Update Form</h3>
        <div v-if="category">
            <Form class="col-8 mx-auto" @submit="onSubmit" :validation-schema="schema">
                <div v-if="errors">
                        <div class="alert alert-danger">
                                {{errors}}
                        </div>
                        
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <Field
                        type="text"
                        class="form-control"
                        id="name"
                        name="name"
                        aria-describedby="emailHelp"
                        v-model="category.name"
                    />
                    <ErrorMessage name="name" class="text-danger" />
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label"
                        >Status</label
                    >
                    <Field as="select"
                        class="form-select"
                        aria-label="Default select example"
                        name="status"
                        v-model="category.status"
                    >
                        <option value="1" selected>Active</option>
                        <option value="0">Block</option>
                </Field>
                </div>

                <button type="submit" class="btn btn-dark">
                    Update Category
                </button>
            </Form>
        </div>
        <div v-else class="d-flex justify-content-center">
            <div class="spinner-border text-primary" role="status">
                <span class="text-center d-block visually-hidden"
                    >Loading...</span
                >
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import { toast } from "vue3-toastify";
import { Form, Field, ErrorMessage } from "vee-validate";
import * as yup from "yup";

export default {
    name: "EditCategory",
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
            category: {},
            errors: null,
            token: this.$store.getters["user/token"],
            id: this.$route.params.id,
        };
    },
    methods: {
        async fetchCategory() {
            try {
                const response = await axios.get(
                    `/api/categories/${this.id}`,
                    {
                        headers: {
                            Authorization: `Bearer ${this.token}`,
                        },
                    }
                );
                console.log("API Response:", response.data); // Yeh check karega ke kya same data har dafa araha hai?
               
                if (response.status === 200) {
                    this.category = response.data.data;
                }
            } catch (error) {
                if (error.response) {
                    if (error.response.data.errors) {
                        this.errors = error.response.data.errors;
                    } else {
                        this.errors = error.response.data.message;
                    }
                } else {
                    toast.error("Failed to fetch product");
                }
            }
        },
        async onSubmit(value) {
            const name=value.name;
            const status=value.status;
            
            try{
                const response=await axios.put(`/api/categories/${this.id}`,{
                    'name':name,
                    'status':status
                },{
                    headers:{
                        Authorization: `Bearer ${this.token}`,
                    }
                }

                )
                if(response.status===200){
                    this.$router.push({name:'categories'})
                    setTimeout(() => {
                        toast.success("Update category successfully")
                    }, 1);
                }
            }catch(error){
                if(error.response){
                    if(error.response.data.errors){
                       this.errors=error.response.data.errors
                       
                    }else{
                        this.errors=error.response.data.message

                    }
                }
                else{
                     toast.error("Something went wrong. Please try later.")
                }
            }
        },
    },
    mounted() {
        this.fetchCategory();
        console.log('id',this.id);
    },
};
</script>
<style lang=""></style>
