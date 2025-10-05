
const user = {
    namespaced: true,

    state: () => ({
        userInfo:localStorage.getItem('userInfo')?JSON.parse(localStorage.getItem('userInfo')):null
    }),
    mutations: { 
        SET_LOGIN(state,user_data){
            state.userInfo=user_data;
            localStorage.setItem('userInfo',JSON.stringify(state.userInfo))
         },
         SET_LOGOUT(state){
            localStorage.removeItem('userInfo');
            state.userInfo=null
         }
         
     },
    actions: { 
        set_login({commit},user_data){
             commit('SET_LOGIN',user_data)
        },
        set_logout({commit}){
            commit('SET_LOGOUT')
       },
     },
     getters: { 
        id: (state) => state.userInfo?.id || null,
        name: (state) => state.userInfo?.name || null,
        token: (state) => state.userInfo?.token || null
    }
  }

  export default user;