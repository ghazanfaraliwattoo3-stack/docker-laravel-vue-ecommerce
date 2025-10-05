import { createStore } from "vuex";
import user from "./modules/user";
import cart from "./modules/cart";
import customer from "./modules/customer";
import shipping from "./modules/shipping";

const store = createStore({
    modules: {
        user,
        cart,
        customer,
        shipping,
    },
});

export default store;
