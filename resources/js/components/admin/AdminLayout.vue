<template lang="">
    <div class="container">
        <div class="row mb-5">
            <h3 class="fw-bold my-4">Dashboard</h3>
            <div class="col-12 col-md-3 card border-0 shadow p-5 mb-sm-5">
                <Sidebar />
            </div>
            <div class="col-md-9">
                    <router-view></router-view>
            </div>
        </div>
    </div>
    
</template>
<script>
import Sidebar from "../Sidebar.vue";
export default {
    name: "AdminDashboard",
    components: {
        Sidebar,
    },
    
};
</script>
<style lang=""></style>
