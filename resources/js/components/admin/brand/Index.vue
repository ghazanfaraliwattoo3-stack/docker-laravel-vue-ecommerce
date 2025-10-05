<template lang="">
    <div class="card border-0 shadow p-3">
        <div class="d-flex justify-content-end mb-3">
            <router-link
                to="/admin/dashboard/brand/create"
                class="btn btn-primary btn-sm"
                >store</router-link
            >
        </div>
        <div v-if="brands && brands.data && brands.data.length > 0">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="col-1">ID</th>
                        <th scope="col">NAME</th>
                        <th scope="col" class="col-2">STATUS</th>
                        <th scope="col" class="col-2">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        valign="middle"
                        v-for="c in brands.data"
                        :key="c.id"
                    >
                        <th>{{ c.id }}</th>
                        <td>{{ c.name }}</td>
                        <td v-if="c.status == 1">
                            <span class="badge bg-success">active</span>
                        </td>
                        <td v-else>
                            <span class="badge bg-danger">block</span>
                        </td>
                        <td>
                            <!-- edit button -->
                            <router-link
                                :to="{
                                    name: 'brand-edit',
                                    params: { id: c.id },
                                }"
                                class="btn text-primary"
                            >
                                <svg
                                    stroke="currentColor"
                                    fill="currentColor"
                                    stroke-width="0"
                                    viewBox="0 0 512 512"
                                    height="1em"
                                    width="1em"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"
                                    ></path>
                                </svg>
                            </router-link>
                            <!-- trash button -->
                            <button
                                class="btn text-danger"
                                @click="trash(c.id)"
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
        <div v-else>
            <p class="text-center">brands Not Found</p>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import { toast } from "vue3-toastify";

export default {
    name: "brandList",
    data() {
        return {
            brands: [],
            loading: false,
            token: this.$store.getters["user/token"],
        };
    },
    methods: {
        async fetchbrand() {
            this.loading= true

            try {
                const response = await axios.get(
                    "/api/brands",
                    {
                        headers: {
                            Authorization: `Bearer ${this.token}`,
                        },
                    }
                );
                if (response.status === 200) {
                    // console.log("brands", response.data);
                    this.loading= false
                    this.brands = response.data;
                }
            } catch (error) {
                console.log("Error fetching brands", error);
            }
        },
        async trash(id) {
            this.$swal
                .fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!",
                })
                .then(async (result) => {
                    if (result.isConfirmed) {
                        try {
                            await axios.delete(
                                `/api/brands/${id}`,
                                {
                                    headers: {
                                        Authorization: `Bearer ${this.token}`,
                                    },
                                }
                            );
                            
                            this.brands.data = this.brands.data.filter(brand => brand.id !== id);

                            toast.success("Delete brand successfully");
                        } catch (error) {
                            toast.error("Oops! Failed to delete brand");
                            console.log(error);
                        }
                    }
                });
        },
    },
    mounted() {
        this.fetchbrand();
    },
};
</script>
<style lang=""></style>
