
const customer = {
    namespaced: true,

    state: () => ({
        customerInfo:localStorage.getItem('customerInfo')?JSON.parse(localStorage.getItem('customerInfo')):null
    }),
    mutations: { 
        SET_LOGIN(state,customer_data){
            state.customerInfo=customer_data;
            localStorage.setItem('customerInfo',JSON.stringify(state.customerInfo))
         },
         SET_LOGOUT(state){
            localStorage.removeItem('customerInfo');
            state.customerInfo=null
         }
         
     },
    actions: { 
        set_login({commit},customer_data){
             commit('SET_LOGIN',customer_data)
        },
        set_logout({commit}){
            commit('SET_LOGOUT')
       },
     },
     getters: { 
        id: (state) => state.customerInfo?.id || null,
        name: (state) => state.customerInfo?.name || null,
        token: (state) => state.customerInfo?.token || null
    }
  }

  export default customer;