export default {
    namespaced: true,

    state: {},

    mutations: {},

    getters: {},

    actions: {
        updateProfile(context, user) {
            context.commit('loading_status', true, { root: true })
            axios.patch(`/api/profile/update/${user.id}`, user)
                 .then( response => {
                    context.commit('loading_status', false, { root: true })
                    context.commit('set_flashmessage', {message: 'Profile Updated Successfully', type: 'success'}, { root: true })
                 })
        }
    }
}