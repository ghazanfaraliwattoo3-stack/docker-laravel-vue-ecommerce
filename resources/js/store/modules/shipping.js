

const state = () => ({
  address: 0
})

const mutations = {
  setAddress(state, newAddress) {
    state.address = newAddress
  }
}

const actions = {
  updateAddress({ commit }, newAddress) {
    commit('setAddress', newAddress)
  }
}

const getters = {
  getAddress: (state) => state.address
}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
