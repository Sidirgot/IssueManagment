
export default {
    namespaced: true,

    state: {
        users:[],
        user: []
    },

    mutations: {
        set_users(state, users) {
            state.users = users
        },

        set_user(state, user) {
            state.users.push(user)
            state.user = user
        },

        update_user(state, user) {
            var index = state.users.findIndex(userItem => userItem.id === user.id)
            state.users.splice(index, 1, user)
        },

        delete_user(state, user) {
            var index = state.users.findIndex(userItem => userItem.id === user.id)
            state.users.splice(index, 1)
        },

        clear_users(state) {
            state.users = []
        }
    },

    getters: {
        users: state => {
            return state.users
        },

        user: state => {
            return state.user
        }
    },

    actions: {
        fetchUsers(context, page_url) {
            var page_url = page_url || '/api/users'
            context.commit('clear_users')
            context.commit('loading_status', true, { root: true })
            axios.get(page_url).then( response => {
                context.commit('set_users', response.data.data)
                context.commit('set_pagination', response.data, { root: true })
                context.commit('loading_status', false, { root: true })
            })
        },

        fetchUser(context, user_id) {
            context.commit('loading_status', true, { root: true })
            axios.get(`/api/users/${user_id}`).then( response => {
                context.commit('set_user', response.data)
                context.commit('loading_status', false, { root: true })
            })
        },

        createUser(context, user) {
            context.commit('loading_status', true, { root: true })
            return new Promise ((resolve, reject) => {
                axios.post('/api/users', user)
                     .then( response => {
                        context.commit('set_user', response.data)
                        resolve(response)
                        context.commit('set_flashmessage', {message: 'User Created Successfully', type: 'success'}, { root: true })
                        context.commit('loading_status', false, { root: true })
                    })
                    .catch( error => {
                        reject(error)
                    })
            })
        },

        updateUser(context, user) {
            context.commit('loading_status', true, { root: true })
            axios.patch(`/api/users/${user.id}`, user)
                 .then( response => {
                    context.commit('update_user', response.data)
                    context.commit('set_flashmessage', {message: 'User Update Successfully', type: 'success'}, { root: true })
                    context.commit('loading_status', false, { root: true })
                })
        },

        deleteUser(context, user) {
            context.commit('loading_status', true, { root: true })
            axios.delete(`/api/users/${user.id}`)
                 .then( response => {
                    context.commit('set_flashmessage', {message: 'User Deleted Successfully', type: 'success'}, { root: true })
                    context.commit('delete_user', user)
                    context.commit('loading_status', false, { root: true })
                })
        }
    }
}