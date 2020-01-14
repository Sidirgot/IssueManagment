export default {
    namespaced: true,

    state: {
        projects: {},
        project: {},
    },

    mutations: {
        set_projects(state, projects) {
            state.projects = projects
        },

        set_project(state, project) {
            state.project = project
        },

        findProject(state, projectID) {
            state.project = state.projects.find(project => project.id === projectID)
        }
    },

    getters: {
        projects: state => {
            return state.projects
        },

        project: state => {
            return state.project
        },
    },

    actions: {
        fetchProjects(context) {
            context.commit('loading_status', true, { root: true })
            axios.get('/api/teamProjects')
                 .then( response => {
                     context.commit('set_projects', response.data.data)
                     context.commit('loading_status', false, { root: true })
                 })
        },

        fetchProject(context, project_id) {
            context.commit('loading_status', true, { root: true })
            axios.get(`/api/projects/${project_id}`)
                 .then( response => {
                     context.commit('set_project', response.data)
                     context.commit('issues/set_issues', response.data.issues, { root: true })
                     context.commit('loading_status', false, { root: true })
                 })
        },
    }
}
