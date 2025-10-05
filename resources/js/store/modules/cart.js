
const cart = {
    namespaced: true,

    state: () => ({
        cart: JSON.parse(localStorage.getItem("shopping_carts")) || [],
    }),
    mutations: {
        Add_To_Cart(state,payload) {
            const {add,size,product}=payload
            
            if(add){
                const newCartItem ={
                    ...product,
                    size:size,
                    qty:1
                }
                   state.cart.push(newCartItem )
                //    update localStorage
                localStorage.setItem("shopping_carts", JSON.stringify(state.cart));

            }
            else{
                state.cart=state.cart.filter((cart)=>cart.id != product.id)
                //   update local storage
                localStorage.setItem("shopping_carts", JSON.stringify(state.cart));
              
            }
        },
        Empty_Cart(state) {
            state.cart=[];

                localStorage.setItem("shopping_carts", JSON.stringify(state.cart));
             
        },
        Inc_Qty(state,product){
            const cart=state.cart.find(c=>c.id==product.id)
            if(cart){
                cart.qty++
                localStorage.setItem("shopping_carts", JSON.stringify(state.cart));

            }
        },
        Desc_Qty(state,product){
            const cart=state.cart.find(c=>c.id==product.id)
            if (cart && cart.qty > 1) {
                cart.qty--;
                localStorage.setItem("shopping_carts", JSON.stringify(state.cart));

            }
        }
    },
    actions: {
        add_to_cart({ commit },payload) {
            commit("Add_To_Cart", payload);
        },
        inc_qty({commit},product){
               commit("Inc_Qty",product)
        },
        desc_qty({commit},product){
               commit("Desc_Qty",product)
        },
        empty_cart({commit}){
            commit("Empty_Cart")

        }
    },
    getters: {
        subtotal(state) {
            return state.cart.reduce((total, cartItem) => {
                return total + (cartItem.price * cartItem.qty);  // Add price * qty to the total
            }, 0);  // Initial total is 0
        },
        cart(state) {
            return state.cart
        }

    },
    
};

export default cart;
