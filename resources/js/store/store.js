import Vue from 'vue'
import Vuex from 'vuex'

import managers from '../Backend/Managers/managersModule'
import issues from '../Backend/Issues/issueModule'
import followups from '../Backend/Followups/followupModule'
import projects from '../Backend/Projects/projectModule'
import team from '../Backend/Team/teamModule'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        managers,
        issues,
        followups,
        projects,
        team,
    },

    state: {
        auth_user: {},
        loading: false,
        flashMessage: {
            message: '',
            type: '',
            bag: ''
        },
        flashMessageFlag: false,
        pagination: false,
        paginator: {},
    },

    mutations: {
        set_auth_user(state, user) {
            return state.auth_user = user
        },

        revoke_auth_user(state) {
            return state.auth_user = {}
        },

        loading_status(state, status) {
            return state.loading = status
        },

        set_flashmessage(state, flashMessage) {
            state.flashMessageFlag = true

            state.flashMessage = flashMessage

            setTimeout(() => {
                state.flashMessageFlag = false
            }, 3000)
        },

        set_pagination(state, pagination) {

            state.paginator  = {}
            state.pagination = false

            if (pagination.per_page < pagination.total) {

                state.pagination = true

                state.paginator = {
                    current_page: pagination.current_page,
                    last_page: pagination.last_page,
                    next_page_url: pagination.next_page_url,
                    prev_page_url: pagination.prev_page_url,
                    total: pagination.total
                }
            }
        }
    },

    getters: {
        auth_user: state => {
            return state.auth_user
        },

        isManager: state => {
            return state.auth_user.role === 'manager'
        },

        isTester: state => {
            return state.auth_user.role === 'tester'
        },

        isDeveloper: state => {
            return state.auth_user.role === 'developer'
        },

        loading: state => {
            return state.loading
        },

        flashMessage: state => {
            return state.flashMessage
        },

        flashMessageFlag: state => {
            return state.flashMessageFlag
        },

        pagination: state => {
            return state.pagination
        },

        paginator: state => {
            return state.paginator
        }
    },

    actions: {
        userData(context) {
            axios.get('/api/userInfo')
                 .then(response => {
                     context.commit('set_auth_user', response.data)
                 })
        },

        logout(context) {
            axios.post('/logout')
                 .then( () => {
                     context.commit('revoke_auth_user')
                     location.replace('/login')
                 })
        }
    }
})