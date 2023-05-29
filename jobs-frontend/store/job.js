/* eslint-disable camelcase */
export const state = () => ({
    dataJobList: {},
    success: false,
    error: false,
    message: null,
    exception: false
})

export const getters = {
    dataJobList: (state) => state.dataJobList,
    success: (state) => state.success,
    error: (state) => state.success,
    message: (state) => state.message,
    exception: (state) => state.exception
}

export const mutations = {
    // Setters
    set(state, [variable, value]) {
        state[variable] = value
    },
}

export const actions = {
    async getListJob({ commit }, data) {
        await this.$axios.post(`${process.env.API_BASE}/api/jobs/list`, data)
            .then((response) => {
                const { data } = response
                if (data.success) {
                    commit("set", ["dataJobList", data.data])
                }
            }).catch((error) => {
                if (error.response) {
                    commit("set", ["dataJobList", error.response.data])
                } else {
                    commit("set", ["dataJobList", error.message])
                }
            })
    },

    async createNewJob({ commit }, data) {
        await this.$axios.post(`${process.env.API_BASE}/api/job/create`, data)
            .then((response) => {
                const { data } = response
                if (data.success) {
                    commit("set", ["success", true])
                } else {
                    commit("set", ["error", true])
                }
                commit("set", ["message", data.message])
            }).catch((error) => {
                if (error.response) {
                    commit("set", ["message", error.response.data.message])
                    commit("set", ["exception", true])
                }
            })
    },

    async updateJobById({ commit }, data) {
        await this.$axios.post(`${process.env.API_BASE}/api/job/edit/${data.id}`, data.data)
            .then((response) => {
                const { data } = response
                if (data.success) {
                    commit("set", ["success", true])
                } else {
                    commit("set", ["error", true])
                }
                commit("set", ["message", data.message])
            }).catch((error) => {
                if (error.response) {
                    commit("set", ["message", error.response.data.message])
                    commit("set", ["exception", true])
                }
            })
    },

    async deleteJobById({ commit }, id) {
        await this.$axios.get(`${process.env.API_BASE}/api/job/delete/${id}`)
            .then((response) => {
                const { data } = response
                if (data.success) {
                    commit("set", ["success", true])
                } else {
                    commit("set", ["error", true])
                }
                commit("set", ["message", data.message])
            }).catch((error) => {
                if (error.response) {
                    commit("set", ["message", error.response.data.message])
                    commit("set", ["exception", true])
                }
            })
    },
}
