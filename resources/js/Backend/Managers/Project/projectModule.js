import actions from './actions'

export default {
    namespaced: true,

    state: {
        projects: [],
        testers: {},
        developers: {},
    },

    mutations: {
        set_projects(state, projects) {
            state.projects = projects
        },

        clear_projects(state) {
            state.projects = {}
        },

        set_testers(state, testers) {
            state.testers = testers
        },

        set_developers(state, developers) {
            state.developers = developers
        },

    },

    getters: {
        projects: state => {
            return state.projects
        },

        project: state => {
            return state.project
        },

        testers: state => {
            return state.testers
        },

        developers: state => {
            return state.developers
        },
    },

    actions: actions
}