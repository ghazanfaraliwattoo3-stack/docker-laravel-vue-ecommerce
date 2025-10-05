import { createWebHistory, createRouter } from "vue-router";

const routes = [
    {
        path: "/home",
        alias: "/",
        component: () => import("./components/Home.vue"),
    },
    { path: "/shop", component: () => import("./components/Shop.vue") },
    {
        path: "/product/:id",
        component: () => import("./components/Product.vue"),
    },
    { path: "/card", component: () => import("./components/Card.vue") },
    {
        path: "/checkout",
        component: () => import("./components/Checkout.vue"),
        meta: { role: "customer" },
    },
    { path: "/admin/login", component: () => import("./components/Login.vue") },
    { path: "/register", component: () => import("./components/Register.vue") },
    { path: "/login", component: () => import("./components/UserLogin.vue") },
    {
        path: "/order-confirmation/:id",
        component: () => import("./components/OrderConfirmation.vue"),
    },
    {
        path: "/my-account",
        component: () => import("./components/MyAccount.vue"),
        meta: { role: "customer" },
        children: [
            {
                path: "",
                name: "profile",
                component: () => import("./components/Profile.vue"),
            },
            {
                path: "order",
                name: "customer-order",
                component: () => import("./components/CustomerOrder.vue"),
            },
            {
                path: "change-password",
                name: "customer-change-password",
                component: () => import("./components/ChangePassword.vue"),
            },
        ],
    },

    {
        path: "/admin/dashboard",
        component: () => import("./components/admin/AdminLayout.vue"),
        meta: { requiresAuth: true },
        children: [
            // Categories routes
            {
                path: "",
                name: "admin-dashboard",
                component: () => import("./components/admin/dashboard.vue"),
            },
            {
                path: "categories",
                name: "categories",
                component: () =>
                    import("./components/admin/categories/Index.vue"),
            },
            {
                path: "category/create",
                component: () =>
                    import("./components/admin/categories/StoreCategory.vue"),
            },
            {
                path: "category/edit/:id",
                name: "category-edit",
                component: () =>
                    import("./components/admin/categories/Edit.vue"),
            },
            // Brand routes
            {
                path: "brands",
                name: "brands",
                component: () => import("./components/admin/brand/Index.vue"),
            },
            {
                path: "brand/create",
                name: "brand-create",
                component: () =>
                    import("./components/admin/brand/StoreBrand.vue"),
            },
            {
                path: "brand/update/:id",
                name: "brand-edit",
                component: () => import("./components/admin/brand/Update.vue"),
            },
            // Product routes
            {
                path: "products",
                name: "products",
                component: () =>
                    import("./components/admin/products/Index.vue"),
            },
            {
                path: "product/create",
                name: "product-create",
                component: () =>
                    import("./components/admin/products/StoreProduct.vue"),
            },
            {
                path: "product/update/:id",
                name: "product-edit",
                component: () => import("./components/admin/products/Edit.vue"),
            },
            // all order
            {
                path: "order",
                name: "admin-order",
                component: () => import("./components/admin/Order.vue"),
            },
            // order detail
            {
                path: "order/:id",
                name: "admin-detail",
                component: () => import("./components/admin/OrderDetail.vue"),
            },
            {
                path: "users-detail",
                name: "users-detail",
                component: () => import("./components/admin/UserDetail.vue"),
            },
            // shipping
            {
                path: "shipping-detail",
                name: "shipping-detail",
                component: () => import("./components/admin/Shipping.vue"),
            },
        ],
    },
    { path: "/test", component: () => import("./components/Text.vue") },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        // always scroll to top
        return { top: 0 };
    },
});
export default router;

router.beforeEach((to, from, next) => {
    const admin = JSON.parse(localStorage.getItem("userInfo"));
    const customer = JSON.parse(localStorage.getItem("customerInfo"));

    if (to.meta.requiresAuth) {
        if (!admin) {
            next("/admin/login"); // Admin login nahi hai
        } else {
            next(); // Admin login hai
        }
    } else if (to.meta.role) {
        if (!customer) {
            next("/login?message=please login first"); // Customer login nahi hai ya wrong role
        } else {
            next(); // Customer login hai aur role match karta hai
        }
    } else {
        next(); // Normal route, koi auth ya role nahi chahiye
    }
});
