import axios from 'axios'

export default {
  namespaced: true,

  state: {
    token: null,
    user: null,
  },

  getters: {
    authenticated(state) {
      return state.token && state.user
    },

    user(state) {
      return state.user
    }
  },

  mutations: {
    SET_TOKEN(state, token) {
      state.token = token
    },

    SET_USER(state, data) {
      state.user = data
    }
  },

  actions: {
    async signIn({ dispatch }, credentials) {
      let response = await axios.post('login', credentials)
      return dispatch('attempt', response.data.access_token)
    },

    async signUp({ dispatch }, credentials) {
      let response = await axios.post('register', credentials)
      return dispatch('attempt', response.data.token, response.data.user);
    },

    async attempt({ commit, state }, token, user = null) {
      if (token) {
        commit('SET_TOKEN', token)
      }

      if (!state.token) {
        return
      }

      try {
        if (!user) {
          let response = await axios.get('/me')
          commit('SET_USER', response.data)
        } else {
          commit('SET_USER', user)
        }
      } catch (e) {
        commit('SET_TOKEN', null)
        commit('SET_USER', null)
      }
    },

    signOut({ commit }) {
      return axios.get('logout').then(() => {
        commit('SET_TOKEN', null)
        commit('SET_USER', null)
      })
    }
  }
}
