<template lang="">
    <ul class="nav flex-column">
  <li class="nav-item">
    <router-link class="nav-link " aria-current="page" :to="{name:'profile'}">Account</router-link>
  </li>
  <li class="nav-item">
    <router-link class="nav-link" :to="{name:'customer-order'}">Order</router-link>
  </li>
  <li class="nav-item">
    <router-link class="nav-link" :to="{name:'customer-change-password'}">Forget Password</router-link>
  </li>
  <li class="nav-item">
    <button class="nav-link " @click="logout" :disabled="loading">Logout</button>
  </li>
</ul>
</template>
<script>
import { toast } from "vue3-toastify";

export default {
    name: "CustomerSidebar",
    data() {
        return {
            loading:false,
        }
    },
    methods: {
        logout(){
            this.loading=true
              this.$store.dispatch("customer/set_logout")
              this.$store.dispatch("cart/empty_cart")
              toast.success("Logout Successfully")
              
              this.$router.push('/login')
            this.loading=false

        }
    },
};
</script>
<style scoped>
 .nav-link {
  color: black; /* Default color black */
  transition: color 0.3s ease; /* Smooth color transition */
}

 .nav-link:hover,
 .nav-link:focus,
 .nav-link:active {
  color: #0284FF; /* Hover ya active mein pink */
}
</style>
