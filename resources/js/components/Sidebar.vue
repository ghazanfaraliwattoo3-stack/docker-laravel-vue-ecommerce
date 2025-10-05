<template lang="">
    <div>
                    <div class="border-bottom pb-2 mb-3 ">
                        <strong><router-link :to="{name:'admin-dashboard'}" class="text-decoration-none sidebar">Dashboard</router-link></strong>
                    </div>
                    <div class="border-bottom pb-2 mb-3">
                        <strong><router-link to="/admin/dashboard/categories" class="text-decoration-none sidebar">Categories</router-link></strong>
                    </div>
                    <div class="border-bottom pb-2 mb-3">
                        <strong><router-link :to="{name:'brands'}" class="text-decoration-none sidebar">Brand</router-link></strong>
                    </div>
                    <div class="border-bottom pb-2 mb-3">
                        <strong><router-link :to="{name:'products'}" class="text-decoration-none sidebar">Products</router-link></strong>
                    </div>
                    <div class="border-bottom pb-2 mb-3">
                        <strong><router-link :to="{name:'admin-order'}" class="text-decoration-none sidebar">Orders</router-link></strong>
                    </div>
                    <div class="border-bottom pb-2 mb-3">
                        <strong><router-link :to="{name:'users-detail'}" class="text-decoration-none sidebar">Users</router-link></strong>
                    </div>
                    <div class="border-bottom pb-2 mb-3">
                        <strong><router-link :to="{name:'shipping-detail'}" class="text-decoration-none sidebar">Shipping </router-link></strong>
                    </div>
                    <!-- <div class="border-bottom pb-2 mb-3">
                        <strong><router-link to="#" class="text-decoration-none sidebar">Change Password</router-link></strong>
                    </div> -->
                    <div class="border-bottom pb-2 mb-3">
                            <button @click="onLogout" class="btn fw-bold ps-0 sidebar">logout</button>

                    </div>
                </div>
</template>
<script>
export default {
    name:"Sidebar",
    methods: {
        onLogout() {
            this.$store.dispatch("user/set_logout");
            this.$router.push("/admin/login");
        },
    },
}
</script>
<style lang="">
    
</style>