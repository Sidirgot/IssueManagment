export default {
    namespaced: true,

    state: {
        followups: [],
        followups_count: 0
    },

    mutations: {
        set_followups(state, followups) {
            state.followups = followups
        },

        set_followups__count(state, followups_count) {
            state.followups_count = followups_count
        },

        push_followup(state, followup) {
            state.followups.unshift(followup)
            state.followups_count += 1
        },

        update_followup(state, followup) {
            var index = state.followups.findIndex(followupItem => followupItem.id === followup.id)
            state.followups.splice(index, 1, followup)
        },

        delete_followup(state, followup) {
            var index = state.followups.findIndex(followupItem => followupItem.id === followup.id)
            state.followups.splice(index, 1)
            state.followups_count -= 1
        },

        clear_followups(state) {
            state.followups = []
        }
    },

    getters: {
        followups: state => {
            return state.followups
        },

        followups_count: state => {
            return state.followups_count
        },
    },

    actions: {
        fetchFollowups(context, {project, issue}) {
            axios.get(`/api/followups/${project.id}/${issue.id}`)
                 .then( response => {
                     context.commit('set_followups', response.data.followups)
                     context.commit('set_followups__count', response.data.followups_count)
                 })
        },

        openFollowup(context, {project, issue, followup}) {
            axios.post(`/api/followups/${issue.id}/${project.id}`, followup)
                 .then( response => {
                     context.commit('push_followup', response.data)
                     context.commit('set_flashmessage', {message: 'Followup Created Successfully', type: 'success'}, { root: true })
                 })
        },

        updateFollowup(context, followup) {
            axios.patch(`/api/followups/${followup.id}`, followup)
                 .then( response => {
                     context.commit('update_followup', response.data)
                     context.commit('set_flashmessage', {message: 'Followup Updated Successfully', type: 'success'}, { root: true })
                 })
        },

        deleteFollowup(context, followup) {
            axios.delete(`/api/followups/${followup.id}`)
                 .then( response => {
                     context.commit('delete_followup', followup)
                     context.commit('set_flashmessage', {message: 'Followup Deleted Successfully', type: 'success'}, { root: true })
                 })
        }
    }
}