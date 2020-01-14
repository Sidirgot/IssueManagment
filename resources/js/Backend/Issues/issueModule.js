export default {
    namespaced: true,

    state: {
        issues: [],
        issue:[],
        openedIssues: [],
        closedIssues: []
    },

    mutations: {
        set_issues(state, issues) {
            state.issues = issues
            state.openedIssues = issues.filter(issue => issue.status === 'opened')
            state.closedIssues = issues.filter(issue => issue.status === 'closed')
        },

        set_issue(state, issue) {
            state.issue = issue
        },

        push_new_issue(state, issue) {
            state.issues.unshift(issue)
            state.openedIssues.unshift(issue)
        },

        close_issue(state, issue) {
            const index = state.openedIssues.findIndex(openedIssue => openedIssue.id === issue.id)
            state.openedIssues.splice(index, 1)
            state.closedIssues.push(issue)
        },

        findIssue(state, issueID) {
            return state.issue = state.issues.find(issue => issue.id === issueID)
        }
    },

    getters: {
        issues: state => {
            return state.issues
        },

        issue: state => {
            return state.issue
        },

        openedIssues: state => {
            return state.openedIssues
        },

        closedIssues: state => {
            return state.closedIssues
        },

    },

    actions: {
        fetchProjectIssue(context, {projectId, issueId}) {
            axios.get(`/api/project/issue/${projectId}/${issueId}`)
                 .then( response => {
                     context.commit('set_issue', response.data)
                 })
        },

        OpenIssue(context, {project, issue}) {
            return new Promise ((resolve, reject) => {
                context.commit('loading_status', true, { root: true })
                 axios.post(`/api/issues/${project.id}`, issue)
                        .then( response => {
                            context.commit('push_new_issue', response.data)
                            resolve(response)
                            context.commit('loading_status', false, { root: true })
                        })
                        .catch( (error) => {
                            console.log(error)
                            reject(error)
                        })
            })
        },

        closeIssue(context, {issue, project}) {
            context.commit('loading_status', true, { root: true })
            axios.patch(`/api/issues/${project.id}/${issue.id}`)
                 .then( response => {
                     context.commit('close_issue', response.data)
                     context.commit('loading_status', false, { root: true })
                 })
        },
    }
}
