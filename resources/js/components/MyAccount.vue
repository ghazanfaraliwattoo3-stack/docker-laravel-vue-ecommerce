<template lang="">
    <div class="container-fluid my-5">
        <div class="row">
            <div class="col-12 col-md-2">
                <div class="card border-0 shadow px-3 " >
                    <CustomerSidebar />
                </div>
            </div>
            <div class="col-12 col-md-10">
                <div class="card border-0 shadow">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import CustomerSidebar from "./CustomerSidebar.vue";
export default {
    name: "MyAccount",
    components: {
        CustomerSidebar,
    },
};
</script>
<style lang=""></style>
