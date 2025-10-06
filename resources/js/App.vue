<template>
    <div>
      <Header v-if="!isAdminRoute" />
      <div class="container">
        <router-view />
      </div>
      <Footer v-if="!isAdminRoute" />
    </div>
  </template>
  
  <script>
  import Footer from "./components/Footer.vue";
  import Header from "./components/Header.vue";
  
  export default {
    name: "App",
    data() {
      return {
        isAdminRoute: false,
      };
    },
    components: {
      Header,
      Footer,
    },
    watch: {
      $route(to) {
        this.checkAdminRoute(to.path);
      },
    },
    created() {
      this.checkAdminRoute(this.$route.path); // page load par bhi check kare
    },
    methods: {
      checkAdminRoute(path) {
        // Agar route /admin se shuru ho raha hai aur login page nahi hai
        this.isAdminRoute =
          path.startsWith("/admin") && path !== "/admin/login";
      },
    },
  };
  </script>
  